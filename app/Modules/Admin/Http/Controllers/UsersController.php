<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Classes\DynamicModel;
use App\Http\Controllers\Controller;
use App\Modules\Admin\Classes\Base;
use App\Modules\Admin\Models\Modules;
use App\Modules\Admin\Models\Right;
use App\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Requests;
use Session;

class UsersController extends Controller
{
	protected $rights;
	protected $request;
	protected $base;
	protected $dynamic;
	protected $plugins;
	protected $modules;

	public function __construct(Guard $auth, Request $request)
	{
		parent::__construct();

		$this->modules = new Modules();
		$this->dynamic = new DynamicModel();
		$this->plugins = new PluginsController($request);
		$this->base    = new Base($request);
		$this->request = $request->all();
		$this->rights  = new Right();
	}

	/**
	 * вывод всех человековf
	 * @return \Illuminate\View\View
	 */
	public function getIndex()
	{
		try {
			$t     = 'users';
			$where = [];

			$users = (new User())->where($where)
				->join(
					'files',

					function($join) use ($t) {
						$join->type = 'LEFT OUTER';

						$join->on($t . '.id', '=', 'files.id_album')
							->where('files.name_table', '=', $t . 'album')
							->where('files.main', '=', 1);
					}
				)

				->select('users.*', 'files.file', 'files.crop')
				->get()
				->toArray();

			return Base::view(
				"admin::users.index",

				[
					'modules' => Base::getModule("link_module", 'users')[0],
					'right'   => Session::get('right'),
					'users'   => $users,
				]
			);
		} catch(\Exception $err) {
			return Base::errorPage($err);
		}
	}

	/**
	 * редактирование человека
	 * @param null $id
	 * @param null $apply
	 * @return mixed
	 */
	public function update($id = null, $apply = null)
	{
		try {
			if(isset($this->request['pl'])) {
				if($id) {

					// редактирование пользователя
					$users = User::find($id);

					$save_password = isset($this->request['pl']['save_password'])
						? $this->request['pl']['save_password']
						: '';

					if($this->request['pl']['password'] == $save_password) {
						unset($this->request['pl']['password']);
						unset($this->request['pl']['save_password']);
					}

					if(isset($this->request['pl']['password']) || !$id) {
						$users->password      = Hash::make($this->request['pl']['password']);
						$users->save_password = $this->request['pl']['password'];
					}

					unset($this->request['pl']['password']);
					unset($this->request['pl']['save_password']);

					foreach($this->request['pl'] as $key => $v)
						$users->$key = is_array($v) ? json_encode($v, JSON_UNESCAPED_UNICODE) : $v;;

					$users->save();
				} else {

					// создаём пользователя
					$users = new User();

					foreach($this->request['pl'] as $key => $v)
						if($v)
							$users->$key = is_array($v) ? json_encode($v, JSON_UNESCAPED_UNICODE) : $v;

					if(!empty($this->request['pl']['password'])) {
						$users->password = Hash::make($this->request['pl']['password']);

						$users->save_password = $this->request['pl']['password'];
					}

					$users->save();
					$id = $users->id;
				}

				$Right                    = $this->rights;
				$this->request['id_menu'] = isset($this->request['id_menu']) ? $this->request['id_menu'] : [];

				// добавление обновлени прав пользователя
				foreach($this->request['id_menu'] as $v => $key) {
					$post = $this->request;

					if(isset($post['r'][$key])) {
						$p['r'] = $post['r'][$key];
					} else {
						$p['r'] = 0;
					};

					if(isset($post['x'][$key])) {
						$p['x'] = $post['x'][$key];
					} else {
						$p['x'] = 0;
					};

					if(isset($post['w'][$key])) {
						$p['w'] = $post['w'][$key];
					} else {
						$p['w'] = 0;
					};

					if(isset($post['d'][$key])) {
						$p['d'] = $post['d'][$key];
					} else {
						$p['d'] = 0;
					};

					$p['id_user'] = $id;
					$p['id_menu'] = $key;
					$right        = $Right->where(['id_user' => $p['id_user'], 'id_menu' => $p['id_menu']])->first();

					if(!isset($right->id)) {
						$right = new Right();
					}

					$right->id_user = $p['id_user'];
					$right->id_menu = $p['id_menu'];
					$right->r       = $p['r'];
					$right->x       = $p['x'];
					$right->w       = $p['w'];
					$right->d       = $p['d'];

					$right->save();
				}

				if($apply) {
					return redirect('/admin/update/users/' . $id);
				} else {
					return redirect('/admin/index/users');
				}
			} else {
				$menu    = Base::getModule("link_module", null, true);
				$modules = Base::getModule("link_module", null, true, $id);

				if(!$id)
					$id = 0;

				$album = $this->plugins->album(
					['name' => 'album'],
					'',
					['id' => $id, 'table' => 'users']
				);

				$lang = $this->dynamic->t('params_lang')->get()->toArray();

				return Base::view(
					"admin::users.update",

					[
						'id'         => $id,
						'album'      => $album,
						'menu'       => $menu,
						'modules'    => $modules,
						'right'      => Session::get('right'),
						'data'       => User::find($id),
						'lang_array' => $lang,
					]
				);
			}
		} catch(\Exception $err) {
			return Base::errorPage($err);
		}
	}
}
