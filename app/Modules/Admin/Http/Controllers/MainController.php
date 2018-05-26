<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Classes\DynamicModel;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Modules\Admin\Classes\Base;
use App\Modules\Admin\Models\Modules;
use App\Modules\Admin\Models\Plugins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Schema;

class MainController extends Controller
{
	/**
	 * @var Base
	 */
	protected $base;

	/**
	 * @var array
	 */
	protected $request;

	/**
	 * @var Request
	 */
	protected $requests;

	/**
	 * @var DynamicModel
	 */
	protected $dynamic;

	/**
	 * @var Plugins
	 */
	protected $plugins;

	public function __construct(Request $request)
	{
		parent::__construct();

		$this->modules  = new Modules();
		$this->dynamic  = new DynamicModel();
		$this->plugins  = new Plugins();
		$this->base     = new Base($request);
		$this->request  = $request->all();
		$this->requests = $request;
	}

	public function getIndex()
	{
		try {
			$data = [];
			$Mod  = $this->dynamic;
			$menu = Base::getModule();

			foreach($menu as $v)
				if(isset($v['link_module']))
					if(!Schema::hasTable($v['link_module']) || !$v['show_count'])
						$data[$v['id']] = 0;
					elseif($this->base->getUser('usertype') !== 'admin' &&
						$this->base->getUser('user_another_type') !== 'specialist')
						$data[$v['id']] = $Mod->t($v['link_module'])->where('user_id', $this->base->getUser('id'))->count();
					else$data[$v['id']] = $Mod->t($v['link_module'])->count();

			return Base::view(
				"admin::dashboard.index",

				[
					'menu' => $menu,
					'data' => $data,
				]
			);
		} catch(\Exception $err) {
			return Base::errorPage($err);
		}
	}

	/**
	 * @return mixed
	 */
	public function getLogout()
	{
		Auth::logout();

		return redirect('admin');
	}

	/**
	 * function for deleting row in table and files linked this table
	 */
	public function rowDelete()
	{
		$request = $this->requests;
		$Mod     = $this->dynamic;

		if(isset($request['table']) || isset($request['id'])) {
			if($request['table'] != 'files') {
				$data['request'] = $Mod->t($request['table'])->where(['id' => $request['id']])->delete();

				$where_table['id_album']   = $request['id'];
				$where_table['name_table'] = $request['table'];
			} else {
				$where_table['id'] = $request['id'];
			}

			$data['album'] = $Mod->t('files')
				->where($where_table)
				->get();

			foreach($data['album'] as $a) {
				if($a->file) {
					if(file_exists(public_path() . "/images/files/original/" . $a->file)) {
						unlink(public_path() . "/images/files/original/" . $a->file);
					}

					if(file_exists(public_path() . "/images/files/big/" . $a->file)) {
						unlink(public_path() . "/images/files/big/" . $a->file);
					}

					if(file_exists(public_path() . "/images/files/small/" . $a->file)) {
						unlink(public_path() . "/images/files/small/" . $a->file);
					}

					if($a->crop) {
						if(file_exists(public_path() . "/images/files/original/" . $a->crop)) {
							unlink(public_path() . "/images/files/original/" . $a->crop);
						}

						if(file_exists(public_path() . "/images/files/big/" . $a->crop)) {
							unlink(public_path() . "/images/files/big/" . $a->crop);
						}

						if(file_exists(public_path() . "/images/files/small/" . $a->crop)) {
							unlink(public_path() . "/images/files/small/" . $a->crop);
						}
					}
				}
			}

			$data['album']->toArray();

			$data['request_file'] = $Mod->t('files')->where($where_table)->delete();

			$data['result'] = 'ok';
			$data['mess']   = '';
		} else {
			$data['result'] = 'error';
			$data['mess']   = 'Неверные параметры';
		}

		echo json_encode($data);
	}
}
