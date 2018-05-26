<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Classes\DynamicModel;
use App\Http\Controllers\Controller;
use App\Modules\Admin\Classes\Base;
use App\Modules\Admin\Models\Modules;
use App\Modules\Admin\Models\Plugins;
use App\Modules\Admin\Models\Right;
use App\User;
use Carbon\Carbon;
use Config;
use Illuminate\Http\Request;
use Response;
use Session;
use Storage;

class BackupController extends Controller
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */

	protected $signature = 'backup:mysql-dump {filename? : Mysql backup filename}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Dump your Mysql database to a file';

	public function __construct(Request $request)
	{
		parent::__construct();

		$this->modules  = new Modules();
		$this->plugins  = new Plugins();
		$this->base     = new Base($request);
		$this->request  = $request->all();
		$this->requests = $request;
		$this->rights   = new Right();
		$this->dynamic  = new DynamicModel();
		$this->file     = new FilesController($request);
	}

	public function getIndex()
	{
		try {
			$users      = User::all();
			$menu       = $this->base->get_cat();
			$name_table = $this->dynamic->getAllTableName();
			$modules    = [];

			foreach($name_table as $table)
				if(Base::getModule("link_module", $table)[0] ?? false)
					$modules[$table] = Base::getModule("link_module", $table)[0];

			return Base::view(
				"admin::backup.index",

				[
					'right'      => Session::get('right'),
					'users'      => $users,
					'menu'       => $menu,
					'modules'    => $modules,
					'name_table' => $name_table,
				]
			);
		} catch(\Exception $err) {
			return json_encode($err);
		}
	}

	public function postUploadXml()
	{
		try {
			if($this->requests->hasFile('uploadfile')) {
				$Mod      = $this->dynamic;
				$table    = $this->requests['table'];
				$file     = $this->requests->file('uploadfile');
				$fileExt  = strtolower($file->getClientOriginalExtension());
				$filename = str_random(10) . time() . str_random(5) . '.' . $fileExt;
				$path     = public_path() . '/images/upload/';

				if(!file_exists($path))
					chmod(mkdir($path), 0777);

				$file->move($path, $filename);
				$file = $path . $filename;

				chmod($file, 0777);
				$fp   = fopen($file, "r");
				$file = fread($fp, 1000000);
				fclose($fp);

				$xml   = simplexml_load_string($file);
				$json  = json_encode($xml);
				$array = json_decode($json, true);

				$result['result']   = 'ok';
				$document           = $this->base->makeSingleArray($array);
				$result['document'] = [];

				foreach($document as $key_0 => $val_0) {
					$i = 0;

					foreach($val_0 as $key => $val) {
						$result['document'][$key_0][$i]['key'] = $key;
						$result['document'][$key_0][$i]['val'] = $val;

						$i++;
					}
				}

				$result['column'] = $this->dynamic->getAllColumnTableName($table);
				$result['script'] = $Mod->t('params')->where(['type' => 'parser'])->get();
				$result['result'] = 'ok';
			} else {
				$result['column'] = [];
				$result['script'] = [];
				$result['result'] = 'error';
			}

			return json_encode($result);
		} catch(\Exception $err) {
			return json_encode($err);
		}
	}

	/**
	 * @return string
	 */
	public function postSaveXmlSchema()
	{
		try {
			$request = $this->requests;

			if($request['name']) {
				$req['result'] = 'ok';

				$Mod = $this->dynamic;

				$data['little_description'] = json_encode(['parent' => $request['parent'], 'column' => $request['column']]);
				$req['name']                = $data['name'] = $request['name'];
				$data['type']               = 'parser';

				$data['updated_at'] = Carbon::now();
				$data['created_at'] = Carbon::now();

				$req['id'] = $req['id_create'][] = $Mod->t('params')->insertGetId($data);
			} else {
				$req['result'] = 'error';
				$req['error']  = '';
			}

			return json_encode($req);
		} catch(\Exception $err) {
			return json_encode($err);
		}
	}

	/**
	 * @return string
	 */
	public function postGetXmlSchema()
	{
		try {
			$request = $this->requests;

			if($request['id']) {
				$Mod           = $this->dynamic;
				$req['result'] = 'ok';

				$script = $Mod->t('params')->where(['id' => $request['id']])->first();

				$req['data'] = json_decode($script['little_description'], true);
			} else {
				$req['result'] = 'error';
				$req['error']  = '';
			}

			return json_encode($req);
		} catch(\Exception $err) {
			return json_encode($err);
		}
	}

	public function postUpdateXml()
	{
		try {
			$request  = $this->requests;
			$document = $request['document'];
			$column   = $request['column'];
			$parent   = $request['parent'];
			$table    = $request['table'];
			$create   = 0;
			$update   = 0;
			$counter  = 0;
			$image    = [];

			if($document) {
				$Mod = $this->dynamic;

				foreach($document as $val) {
					$data  = [];
					$where = [];

					for($i = 0; count($parent['parent_key']) > $i; $i++) {
						$parent_i   = $parent['parent_val'][$i]['document'];
						$key_parent = array_filter(
							$val,

							function($innerArray) use ($parent_i, $i) {
								return ($innerArray['key'] == $parent_i);
							}
						);

						$val_parent                                                = ($key_parent) ? array_shift($key_parent)['val'] : -1;
						$where[$table . '.' . $parent['parent_key'][$i]['column']] = $val_parent;
					}

					if(isset($parent['parent_key'])) {
						$old_array = $data = $Mod
							->t('flat')
							->where($where)
							->join(
								'files', function($join) {
								$join->type = 'LEFT OUTER';
								$join->on('flat.id', '=', 'files.id_album')
									->where('files.name_table', '=', 'flat')
									->where('files.main', '=', 1);
							}
							)
							->groupBy('flat.id')
							->orderBy('flat.id', 'DESC')
							->first();
					} else {
						$old_array = false;
					}

					$key_image = array_filter(
						$val, function($innerArray) {
						return ($innerArray['key'] == 'image');
					}
					);

					$image_val  = ($key_image) ? array_shift($key_image)['val'] : false;
					$image_file = (isset($old_array->file)) ? $old_array->file : '';

					if(empty($old_array) || empty($parent['parent_val'])) {//insert
						$data = [];

						foreach($column as $v) {
							$key = array_filter(
								$val, function($innerArray) use ($v) {
								return ($innerArray['key'] == $v['document']);
							}
							);

							if($key) {
								$data[$v['column']] = array_shift($key)['val'];
							}
						}

						$id = $req['id_create'][] = $Mod->t('flat')->insertGetId($data);

						if($image_val && $image_file == '') {
							$image[$counter]['id']  = $id;
							$image[$counter]['img'] = $image_val;

							$counter++;
						}

						$create++;
					} else {//update
						$data = $old_array;

						foreach($column as $v) {
							$key = array_filter(
								$val, function($innerArray) use ($v) {
								return ($innerArray['key'] == $v['document']);
							}
							);

							if($key) {
								$key_v        = (string) $v['column'];
								$data->$key_v = array_shift($key)['val'];
							}
						}

						$data->save();
						$update++;

						if($image_val && $image_file == '') {
							$image[$counter]['id'] = $old_array->id;;
							$image[$counter]['img'] = $image_val;

							$counter++;
						}
					}
				}

				$req['request'] = $image;
				$req['update']  = $update;
				$req['create']  = $create;
				$req['result']  = 'ok';
			} else {
				$req['result'] = 'error';
				$req['error']  = '';
			}

			return json_encode($req);
		} catch(\Exception $err) {
			return json_encode($err);
		}
	}

	public function postUploadImgRooms()
	{
		$request = $this->requests;
		$image   = $request->input("image");
		$id      = $request->input("id_album");

		$ex   = explode('/', $image);
		$file = public_path() . '/images/upload/' . trim($ex[count($ex) - 1]);

		if(file_exists($image)) {
			$g = file_put_contents($file, file_get_contents($image));
			chmod($file, 0777);

			if(file_exists($file)) {
				$ext = explode('.', trim($ex[count($ex) - 1]));

				$data['ext']        = $ext[count($ext) - 1];
				$data['orig_name']  = $ex[count($ex) - 1];
				$data['size']       = $g;
				$data['file'][]     = $file;
				$data['name']       = 'images';
				$data['name_table'] = 'flat';
				$data['id_album']   = $id;
				$data['type']       = 'url';

				$Mod = $this->dynamic;
				$dat = $Mod->t('modules')->where('link_module', 'flat')->first()->toArray();

				$data['big_width']    = $dat['big_width'];
				$data['big_height']   = $dat['big_height'];
				$data['small_width']  = $dat['small_width'];
				$data['small_height'] = $dat['small_height'];

				$this->file->upload_img($data);

				$req['result'] = 'ok';
			} else {
				/* файл не получен*/
				$req['result']     = 'error';
				$req['text_error'] = 'error file_exists local';
			}
		} else {
			/* файл не получен*/
			$req['result']     = 'error';
			$req['text_error'] = 'error file_exists url';
		}

		$req['id']    = $id;
		$req['image'] = $image;

		return json_encode($req);
	}

	function _upFile($data, $i = 0, $g = 0)
	{
		if($i >= 5) {
			return ['r' => false, 'g' => $g];
		}

		print_r(strlen(trim($data['image'])));

		if(strlen(file_get_contents(trim($data['image']))) < 200) {
			return ['r' => false, 'g' => $g];
		}

		if(!file_get_contents(trim($data['image']))) {
			return ['r' => false, 'g' => 0];
		}


		if(!file_exists($data['file'])) {


			$g = file_put_contents($data['file'], file_get_contents(trim($data['image'])));
			chmod($data['file'], 0777);

			$i++;
			$this->_upFile($data, $i, $g);
		} else {
			return ['r' => true, 'g' => $g];
		}
	}

	function subdivide($dataarray, $level = 1, $parent_id = 0)
	{
		$temparray = [];

		foreach($dataarray as $key => $dat) {
			if(isset($dat['attributes']['INTERNAL-ID'])) {
				$parent_id = $dat['attributes']['INTERNAL-ID'];
			}

			$toplvltag = strtolower($dat['tag']);

			if($dat['level'] === $level && $dat['type'] === "open") {
				$toplvltag = strtolower($dat['tag']);
			} elseif($dat['level'] === $level && $dat['type'] === "close" && strtolower($dat['tag']) === $toplvltag) {
				$newarray[$toplvltag][] = $this->subdivide($temparray, ($level + 1), $parent_id);

				unset($temparray, $nextlvl);
			} elseif($dat['level'] === $level && $dat['type'] === "complete") {

				if(isset($newarray['description'])) {
					$newarray['parent_id'][] = $parent_id;
				}
				if(isset($newarray['image'])) {
					if(gettype(($newarray['image'])) == "array") {
						if(isset($dat['value'])) {
							$value                               = iconv(mb_detect_encoding(trim($dat['value']), mb_detect_order(), true), "UTF-8", trim($dat['value']));
							$newarray[strtolower($dat['tag'])][] = $value;
						}
					} else {
						if(isset($newarray[strtolower($dat['tag'])])) {
							$image = $newarray[strtolower($dat['tag'])];

							$newarray[strtolower($dat['tag'])]    = [];
							$newarray[strtolower($dat['tag'])][0] = $image;
						}

						if(isset($dat['value'])) {
							$value                               = iconv(mb_detect_encoding(trim($dat['value']), mb_detect_order(), true), "UTF-8", trim($dat['value']));
							$newarray[strtolower($dat['tag'])][] = $value;
						}
					}
				} else {
					if(isset($dat['value'])) {
						$value                             = iconv(mb_detect_encoding(trim($dat['value']), mb_detect_order(), true), "UTF-8", trim($dat['value']));
						$newarray[strtolower($dat['tag'])] = $value;
					}
				}
			} elseif($dat['type'] === "complete" || $dat['type'] === "close" || $dat['type'] === "open") {
				$temparray[] = $dat;
			}
		}

		return (array) $newarray;
	}

	function correctentries($dataarray)
	{

		if(is_array($dataarray)) {
			$keys = array_keys($dataarray);
			if(count($keys) == 1 && is_int($keys[0])) {
				$tmp = $dataarray[0];
				unset($dataarray[0]);
				$dataarray = $tmp;
			}

			$keys2 = array_keys($dataarray);
			foreach($keys2 as $key) {
				$tmp2 = $dataarray[$key];
				unset($dataarray[$key]);
				$dataarray[$key] = $this->correctentries($tmp2);
				unset($tmp2);
			}
		}
		return $dataarray;
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function sqlBackup()
	{
		header("Content-type: application/octet-stream");

		$host         = env('DB_HOST', 'localhost');
		$database     = env('DB_DATABASE', 'forge');
		$username     = env('DB_USERNAME', 'forge');
		$password     = env('DB_PASSWORD', '');
		$backupPath   = public_path() . '/images/backup/';
		$cloudStorage = Config::get('backup.mysql.cloud-storage.enabled');
		$cloudDisk    = Config::get('backup.mysql.cloud-storage.disk');
		$cloudPath    = public_path() . '/images/backup/';
		$keepLocal    = Config::get('backup.mysql.cloud-storage.keep-local');
		$filename     = $database . '_' . Carbon::now()->format('Y-m-d') . '.sql';
		$dumpCommand  = "mysqldump -e -f -h $host -u $username -p'$password' $database > $backupPath$filename";

		if(!file_exists($backupPath))
			chmod(mkdir($backupPath), 0777);

		exec($dumpCommand);

		if($cloudStorage) {
			$fileContents = file_get_contents("$backupPath$filename");
			Storage::disk($cloudDisk)->put("$cloudPath$filename", $fileContents);
			if(!$keepLocal) {
				$rmCommand = "rm $backupPath$filename";
				exec($rmCommand);
			}
			//            $this->info('Backup uploaded to cloud storage!');
		}

		chmod($backupPath . $filename, 0777);

		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=' . basename($backupPath . $filename));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($backupPath . $filename));

		readfile($backupPath . $filename);

		exit;
	}


	public function tarBackup()
	{
		header("Content-type: application/x-tar");

		$database    = env('DB_DATABASE', 'forge');
		$cloudPath   = public_path() . '/images/backup/';
		$filename    = $database . '_' . Carbon::now()->format('Y-m-d') . '.tar.gz';
		$backupPath  = public_path() . '/images/backup/';
		$dumpCommand = "tar -cvzf $cloudPath$filename " . $_SERVER['DOCUMENT_ROOT'] . " --exclude=*tar.gz*";

		exec($dumpCommand);

		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=' . basename($backupPath . $filename));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($backupPath . $filename));

		readfile($backupPath . $filename);
	}

	/**
	 * delete backup's
	 */
	public function delBackup()
	{
		exec('rm -rf ' . public_path() . '/images/backup/*');

		return redirect('/admin/index/backup');
	}
}
