<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Classes\DynamicModel;
use App\Http\Controllers\Controller;
use App\Modules\Admin\Classes\Base;
use App\Modules\Admin\Models\Files;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Validator;

class FilesController extends Controller
{
	/**
	 * @var Request
	 */
	protected $requests;

	/**
	 * @var array
	 */
	protected $request;

	/**
	 * @var Files
	 */
	protected $files;

	/**
	 * @var DynamicModel
	 */
	protected $dynamic;

	/**
	 * @var Base
	 */
	protected $base;

	public function __construct(Request $request)
	{
		parent::__construct();
		$this->request  = $request->all();
		$this->requests = $request;

		$this->files   = new Files();
		$this->base    = new Base($request);
		$this->dynamic = new DynamicModel();
	}

	/**
	 * upload images
	 * @param null $data
	 * @return mixed
	 */
	public function upload_img($data = null)
	{
		if(!$data) {
			$request              = $this->requests;
			$data['file'][]       = $request->file("Filedata");
			$data['name']         = 'images';
			$data['name_table']   = $request->input("name_table") . $request->input("name_field");
			$data['id_album']     = $request->input("id_album");
			$modules_product      = Base::getModule("link_module", $request->input("name_table"))[0];
			$data['big_width']    = $modules_product['big_width'];
			$data['big_height']   = $modules_product['big_height'];
			$data['small_width']  = $modules_product['small_width'];
			$data['small_height'] = $modules_product['small_height'];
		}

		$res           = $this->_load_img($data);
		$res['result'] = 'ok';

		return $res;
	}

	/**
	 * загрузка изображения
	 * @param $data
	 * @return mixed
	 */
	private function _load_img($data)
	{
		if(isset($data['images']))
			$images = $data['images'];
		else
			$images = [];

		$res        = [];
		$valid      = false;
		$file       = $data['file'];
		$name_table = $data['name_table'];
		$name       = $data['name'];
		$bw         = $data['big_width'];
		$bh         = $data['big_height'];
		$sw         = $data['small_width'];
		$sh         = $data['small_height'];

		if(!isset($data['type']))
			$data['type'] = 'input';

		if(!isset($data['id_album']))
			$id_album = 0;
		else
			$id_album = $data['id_album'];

		foreach($file as $i => $f) {
			if($f == null) {
				$valid = true;
			} else {
				if($data['type'] != 'url') {
					$validator2 = Validator::make(
						['img' => $f],
						['img' => 'image']
					);

					if($validator2->fails()) {
						$valid        = true;
						$res['error'] = "Файл должен быть изображением";

						break;
					}
				}

				$path_o = public_path() . "/images/files/original/";
				$path_b = public_path() . "/images/files/big/";
				$path_s = public_path() . "/images/files/small/";

				if($data['type'] == 'url') {
					$fileExt   = $data['ext'];
					$orig_name = $data['orig_name'];
					$size      = $data['size'];
				} else {
					$fileExt   = strtolower($f->getClientOriginalExtension());
					$orig_name = $f->getClientOriginalName();
					$size      = $f->getSize();
				}

				$filename = str_random(10) . time() . str_random(5);
				$img      = Image::make($f);
				$img->backup();

				/* original */
				$img->save($path_o . $filename . '.' . $fileExt);
				/* original */
				/* big */

				// делаем ресайз по ширине
				$img->reset();

				$img->resize(
					$bw,
					null,

					function($constraint) {
						$constraint->aspectRatio();
						$constraint->upsize();
					}
				);

				$img->save($path_b . $filename . '.' . $fileExt);

				/* big */
				/*  small */
				$img->reset();

				// Crop and resize combined
				$img->fit($sw, $sh);
				$img->save($path_s . $filename . '.' . $fileExt);
				$img->reset();
				/*  small */

				// задаём полные права
				chmod($path_o . $filename . '.' . $fileExt, 0777);
				chmod($path_b . $filename . '.' . $fileExt, 0777);
				chmod($path_s . $filename . '.' . $fileExt, 0777);

				if($data['type'] == 'url')
					unlink($f);
			}

			$file = $this->files->where(['id_album' => $id_album, 'name_table' => $name_table])->first();
			$fil  = $this->files;

			$fil->type       = 'img';
			$fil->orig_name  = $orig_name;
			$fil->size       = $size;
			$fil->file       = $filename . '.' . $fileExt;
			$fil->id_album   = $id_album;
			$fil->name_table = $name_table;

			if(empty($file)) {
				$fil->main   = 1;
				$res['main'] = 1;
			} else {
				$res['main'] = 0;
			}

			$fil->save();

			$res['id'] = $fil->id;
		}

		$res['name']  = $filename . '.' . $fileExt;
		$res['img']   = $images;
		$res['valid'] = $valid;

		return $res;
	}

	/**
	 * Upload files.
	 *
	 * @param null $data
	 * @return mixed
	 */
	public function upload_files($data = null)
	{
		if(!$data) {
			$request            = $this->requests;
			$data['file']       = $data['file'] ?? [$request->file("Filedata")];
			$data['name']       = 'files';
			$data['name_table'] = $data['name_table'] ?? $request->input("name_table") . $request->input("name_field");
			$data['id_album']   = $data['id_album'] ?? $request->input("id_album");
			$data['limit']      = $data['limit'] ?? $request->input("limit");
			$data['path']       = $data['path'] ?? "/images/files/files/";
		}

		$res           = $this->_load($data);
		$res['result'] = 'ok';

		return $res;
	}

	/**
	 * Загрузка файла.
	 *
	 * @param $data
	 * @return mixed
	 */
	private function _load($data)
	{
		if(isset($data['files']))
			$files = $data['files'];
		else
			$files = [];

		$res        = [];
		$valid      = false;
		$file       = $data['file'];
		$name_table = $data['name_table'];

		if(!isset($data['type']))
			$data['type'] = 'input';

		if(!isset($data['id_album']))
			$id_album = 0;
		else
			$id_album = $data['id_album'];

		foreach($file as $i => $f) {
			if($f == null) {
				$valid = true;
			} else {
				if($data['type'] != 'url') {
					$validator2 = Validator::make(
						['file' => $f],
						['file' => 'required|max:20000']
					);

					if($validator2->fails()) {
						$valid        = true;
						$res['error'] = "Не правильный формат файла";
						break;
					}
				}

				if($data['type'] == 'url') {
					$fileExt   = $data['ext'];
					$orig_name = $data['orig_name'];
					$size      = $data['size'];
				} else {
					$fileExt   = strtolower($f->getClientOriginalExtension());
					$orig_name = $f->getClientOriginalName();
					$size      = $f->getSize();
				}

				$path     = public_path() . $data['path'];
				$filename = str_random(10) . time() . str_random(5);

				if(!file_exists($path)) {
					mkdir($path);
					chmod($path, 0777);
				}

				$f->move($path, $orig_name);
				rename($path . $orig_name, $path . $filename . '.' . $fileExt);
				chmod($path . $filename . '.' . $fileExt, 0777);

				if($data['type'] == 'url')
					unlink($f);

				$file = $this->files->where(['id_album' => $id_album, 'name_table' => $name_table])->first();
				$fil  = $this->files;

				$fil->type       = 'file';
				$fil->orig_name  = $orig_name;
				$fil->size       = $size;
				$fil->file       = $filename . '.' . $fileExt;
				$fil->id_album   = $id_album;
				$fil->name_table = $name_table;

				if(empty($file)) {
					$fil->main   = 1;
					$res['main'] = 1;
				} else
					$res['main'] = 0;

				$fil->save();
				$res['id'] = $fil->id;
			}
		}

		$res['name']  = !isset($filename) ? 'error files' : ($filename ?? '') . '.' . ($fileExt ?? '');
		$res['file']  = $files;
		$res['valid'] = $valid;

		return $res;
	}

	/**
	 * function for load ajax crop img
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
	 */
	public function get_crop()
	{
		$request      = $this->requests;
		$data['name'] = $this->request['nameId'] ?? '';

		if($request['id']) {
			$data['file'] = $this->files->find(['id' => $request['id']]);

			return Base::view("admin::plugins.album.crop_img", $data);
		} else {
			return 'error getting';
		}
	}

	/**
	 * function for load ajax edit file.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
	 */
	public function get_edit_file()
	{
		return $this->get_edit('admin::plugins.files.edit_file');
	}

	/**
	 * function for load ajax edit img.
	 *
	 * @param string $path
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|string
	 */
	public function get_edit($path = 'admin::plugins.album.edit_img')
	{
		$request      = $this->requests;
		$data['name'] = $this->request['nameId'] ?? '';

		if($request['id']) {
			if(!$request['save']) {
				$data['lang_array'] = $this->dynamic->t('params_lang')->get()->toArray();
				$data['file']       = $this->files->find(['id' => $request['id']])->first();

				return Base::view($path, $data);
			} else {
				$file = $this->files->find(['id' => $request['id']])->first();
				$form = $this->base->decode_serialize($request['form']);

				$file->name = is_array($form['name_img_edit' . $data['name']])
					? json_encode($form['name_img_edit' . $data['name']], JSON_UNESCAPED_UNICODE)
					: $form['name_img_edit' . $data['name']];

				$file->text = is_array($form['text_img_edit' . $data['name']])
					? json_encode($form['text_img_edit' . $data['name']], JSON_UNESCAPED_UNICODE)
					: $form['text_img_edit' . $data['name']];

				$file->order = (int) $form['order_img_edit' . $data['name']];

				$file->save();

				$res['result'] = 'ok';
				$res['file']   = $file;

				echo json_encode($res);
			}
		} else {
			return 'error getting';
		}
	}

	/**
	 *
	 */
	public function edit_img()
	{
		$request      = $this->requests;
		$data['name'] = $this->request['nameId'] ?? '';

		if($request['id']) {
			$file   = $request['file'];
			$option = $request['option'];

			//			$path_s = public_path() . "/images/files/small/";
			$filename = str_random(10) . time() . str_random(5);
			$ext      = explode('.', $file);
			$fileExt  = $ext[count($ext) - 1];
			$pathP    = public_path() . '/images/files/small/' . $filename . '.' . $fileExt;
			$pathO    = public_path() . '/images/files/original/' . $file;

			$im = imagecreate(round($option['width']), round($option['height']));
			imagecolorallocate($im, 255, 255, 255);

			switch($fileExt) {
			case 'gif':
				imagegif($im, $pathP);

			break;
			case 'jpeg':
				imagejpeg($im, $pathP);

			break;
			case 'jpg':
				imagejpeg($im, $pathP);

			break;
			case 'png':
				imagepng($im, $pathP);

			break;
			default:
				$data['result'] = 'error';
				$data['text']   = 'error 1';
				$data['text1']  = $ext;

				return json_encode($data);
			}

			imagedestroy($im);

			switch($fileExt) {
			case 'gif':
				$impF = imagecreatefromgif($pathP);
				$impS = imagecreatefromgif($pathO);

			break;
			case 'jpeg':
				$impF = imagecreatefromjpeg($pathP);
				$impS = imagecreatefromjpeg($pathO);

			break;
			case 'jpg':
				$impF = imagecreatefromjpeg($pathP);
				$impS = imagecreatefromjpeg($pathO);

			break;
			case 'png':
				$impF = imagecreatefrompng($pathP);
				$impS = imagecreatefrompng($pathO);

			break;
			default:
				$data['text']   = 'error 2';
				$data['result'] = 'error';

				return json_encode($data);
			}

			$sizeS = getimagesize($pathO);
			$wmSH  = $sizeS[1];
			$wmSW  = $sizeS[0];

			imagecopyresampled($impF, $impS, -$option['x'], -$option['y'], 0, 0, $wmSW, $wmSH, $wmSW, $wmSH);

			switch($fileExt) {
			case 'gif':
				imagegif($impF, $pathP);

			break;
			case 'jpeg':
				imagejpeg($impF, $pathP);

			break;
			case 'jpg':
				imagejpeg($impF, $pathP);

			break;
			case 'png':
				imagepng($impF, $pathP);

			break;
			default:
				$data['text']   = 'error 3';
				$data['result'] = 'error';

				return json_encode($data);
			}

			chmod($pathP, 0777);
			imagedestroy($impF);
			//			imagedestroy($impF);
			/**/
			$file = $this->files->where(['id' => $request['id']])->first();

			if($file->crop) {
				if(file_exists(public_path() . "/images/files/small/" . $file->crop)) {
					unlink(public_path() . "/images/files/small/" . $file->crop);
				}
			}

			$file->crop = $filename . '.' . $fileExt;
			$file->save();

			$data['file']   = "/images/files/small/" . $filename . '.' . $fileExt;
			$data['result'] = 'ok';
		} else {
			$data['result'] = 'error';
		}

		echo json_encode($data);
	}

	/**
	 * To main
	 */
	function to_main()
	{
		$request = $this->requests;

		if($request['id']) {
			$file       = $this->files->where(['id' => $request['id']])->first();
			$file->main = 1;

			$res['save_cat'] = $this->files->where(
				[
					'id_album'   => $file->id_album,
					'name_table' => $file->name_table,
				]
			)->update(['main' => 0]);

			$res['save']   = $file->save();
			$res['result'] = 'ok';
			$res['id']     = $request['id'];

			echo json_encode($res);
		} else {
			$res['result'] = 'ok';
			$res['text']   = 'error getting';

			echo json_encode($res);
		}
	}
}
