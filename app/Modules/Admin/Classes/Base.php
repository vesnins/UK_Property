<?php

namespace App\Modules\Admin\Classes;

use App\Classes\DynamicModel;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Mail;
use Session;

ini_set('display_errors', 'On');
error_reporting('E_ALL');

class Base
{
	/**
	 * @var array
	 */
	public static $partnersURI = [
		"/",
	];

	/**
	 * @var
	 */
	public static $user;

	/**
	 * авторизованный пользователь
	 *
	 * @var
	 */
	public static $authenticate;

	/**
	 * @var array
	 */
	static $month = [
		'01' => 'Январь',
		'02' => 'Февраль',
		'03' => 'Март',
		'04' => 'Апрель',
		'05' => 'Май',
		'06' => 'Июнь',
		'07' => 'Июль',
		'08' => 'Август',
		'09' => 'Сентябрь',
		'10' => 'Октябрь',
		'11' => 'Ноябрь',
		'12' => 'Декабрь',
	];

	/**
	 * @var array
	 */
	protected $monthLang = [
		'en' => [
			'01' => 'January',
			'02' => 'February',
			'03' => 'March',
			'04' => 'April',
			'05' => 'May',
			'06' => 'June',
			'07' => 'July',
			'08' => 'August',
			'09' => 'September',
			'10' => 'October',
			'11' => 'November',
			'12' => 'December',
		],

		'ru' => [
			'01' => 'Января',
			'02' => 'Февраля',
			'03' => 'Марта',
			'04' => 'Апреля',
			'05' => 'Мая',
			'06' => 'Июня',
			'07' => 'Июля',
			'08' => 'Августа',
			'09' => 'Сентября',
			'10' => 'Октября',
			'11' => 'Ноября',
			'12' => 'Декабря',
		],
	];

	/**
	 * @var mixed
	 */
	protected $right;

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
	 * Base constructor.
	 *
	 * @param Request $request
	 */
	public function __construct(Request $request)
	{
		$this->request  = $request->all();
		$this->requests = $request;
		$this->dynamic  = new DynamicModel();
	}

	/**
	 * инициация авторизированного пользователя, будет доступен везде в Base::$user
	 *
	 * @param $request
	 * @return mixed
	 */
	static public function init($request)
	{
		global $right;
		self::$user         = Auth::user();
		self::$authenticate = Auth::check();

		$base = new Base($request);
		$base->right_check();
		$right = $base->right();

		return $base->right();
	}

	/**
	 * проверка прав
	 *
	 * @return bool
	 */
	public function right_check()
	{
		if(!Auth::check())
			return redirect()->guest('/admin/login');

		$right = $this->right();

		if(empty($right)) {
			// создане прав
		} else {
			$seg = $this->requests->segments()[1] ?? '';
			$r   = true;

			switch($seg) {
			case 'index':
				// добавление
				if(!$right['r']) {
					$r = false;
				}
			break;

			case 'update':
				if(isset($this->requests->segments()[3])) {
					// редактирование
					if(!$right['x']) {
						$r = false;
					}
				} else {
					// добавлени
					if(!$right['w']) {
						$r = false;
					}
				}
			break;

			case 'delete':
				// удаление
				if(!$right['d']) {
					$r = false;
				}
			break;

			default:
				$r = true;
			}

			if(!$r) {
				abort(503, 'Недостаточно прав');
			} else {
				return $r;
			}
		}

		return false;
	}

	/**
	 * проверка/получение прав пользователя
	 *
	 * @param null $table
	 * @return mixed
	 */
	public function right($table = null)
	{
		if($table) {
			$segment3 = $table;
		} else {
			$segment3 = $this->requests->segment(3);
			$segment2 = $this->requests->segment(2);

			if(!$segment3 || $segment2 == 'settings') {
				$segment3 = $segment2;
			}
		}

		return $this->getModule("link_module", $segment3)[0] ?? '';
	}

	/**
	 * модули|модуль и сразу присваиваем права
	 *
	 * @param $keySearch - ключ
	 * @param $name - с чем сверять
	 * @param $list - игнорировать parent и оставить массив одномерным
	 * @param $id - id юзера для которого надо сформировать права
	 * @return mixed
	 * admin - если тип юзера (admin) то права будут полные, всегда
	 * r - просмотр
	 * x - редактирование
	 * w - добавление
	 * d - удаление
	 */
	public static function getModule($keySearch = "link_module", $name = null, $list = false, $id = null)
	{
		$module = config('admin.module');

		if($id)
			$user = User::find($id);
		else
			$user = Auth::user();

		if($user['usertype'] == 'admin') {
			foreach($module as $key => $v) {
				if($name === $module[$key][$keySearch] || !$name) {
					$module[$key] = array_merge($v, ['r' => 1, 'x' => 1, 'w' => 1, 'd' => 1]);

					if(isset($v['parent']) && !$list) {
						$parent = Base::findKey($module, 'id', $v['parent']);

						$module[$parent]['m'] = array_merge(
							$module[$parent]['m'] ?? [],

							[
								array_merge(
									$module[$key],

									[
										'r' => 1,
										'x' => 1,
										'w' => 1,
										'd' => 1,
									]
								),
							]
						);

						unset($module[$key]);
					}
				} else {
					unset($module[$key]);
				}

				if(!$v['active'])
					unset($module[$key]);
			}
		} else {
			$right = DynamicModel::t('right')
				->select('id_menu', 'r', 'x', 'w', 'd')
				->where('id_user', $user['id'])
				->whereIn('id_menu', Base::getArrayVal("id", $module))
				->groupBy('id')
				->get()
				->toArray();

			$right = Base::revertToKey("id_menu", $right);

			foreach($module as $key => $v) {
				if($name === $module[$key][$keySearch] || !$name) {
					if(!isset($right[$v['id']]))
						$module[$key] = array_merge($v, ['r' => 0, 'x' => 0, 'w' => 0, 'd' => 0]);
					 else
						$module[$key] = array_merge(['r' => 1, 'x' => 1, 'w' => 1, 'd' => 1], $v, $right[$v['id']]);

					if(isset($v['parent']) && !$list) {
						$parent = Base::findKey($module, 'id', $v['parent']);

						if(!($module[$parent]['m'] ?? false))
							$module[$parent]['m'] = [];

						$module[$parent]['m'] = array_merge(
							$module[$parent]['m'],

							[
								array_merge(
									$v,

									[
										'r' => $module[$key]['r'],
										'x' => $module[$key]['x'],
										'w' => $module[$key]['w'],
										'd' => $module[$key]['d'],
									]
								),
							]
						);

						unset($module[$key]);
					}
				} else {
					unset($module[$key]);
				}

				if(!$v['active'])
					unset($module[$key]);
			}
		}

		// sorting to order
		usort(
			$module,

			function($a, $b) {
				return $a['order'] <=> $b['order'];
			}
		);

		return isset($module[0]['m']) ? $module[0]['m'] : $module;
	}

	/**
	 * Functions find key by key in array
	 *
	 * @param $arr
	 * @param $key
	 * @param $search
	 * @return int|string
	 */
	public static function findKey($arr, $key, $search)
	{
		foreach($arr as $k => $v)
			if($v[$key] === $search)
				return $k;

		return -1;
	}

	/**
	 * создаёт массив значений
	 *
	 * @param $name
	 * @param $arr
	 * @return array
	 */
	public static function getArrayVal($name, $arr)
	{
		$nevArr = [];

		foreach($arr as $v) {
			$nevArr[] = $v[$name];
		}

		return $nevArr;
	}

	/**
	 * замена порядкового номера массива на значение из массива
	 *
	 * @param $name
	 * @param $arr
	 * @return array
	 */
	public static function revertToKey($name, $arr)
	{
		$nevArr = [];

		foreach($arr as $v) {
			$nevArr[$v[$name]] = $v;
		}

		return $nevArr;
	}

	/**
	 * редирект назад с сообщением об ошибке
	 *
	 * @param $message - сообщение об ошике
	 * @return mixed
	 */
	public static function wrong($message)
	{
		Session::flash('error', $message);
		return redirect()->back();
	}

	/**
	 * редирект назад с сообщением
	 *
	 * @param $message - сообщение
	 * @return mixed
	 */
	public static function back($message)
	{
		Session::flash('info', $message);
		return redirect()->back();
	}

	/**
	 * редирект с сообщением
	 *
	 * @param $url - путь редиректа
	 * @param $message - сообщение
	 * @return mixed
	 */
	public static function redirect($url, $message)
	{
		Session::flash('info', $message);
		return redirect($url);
	}

	/**
	 * формируем склонения
	 * @param $number - число, для которого формируем
	 * @param $after - массив склонений, например ['день','дня','дней']
	 * @return string - возвращаем склонение
	 */
	public static function plural($number, $after)
	{
		$cases = [2, 0, 1, 1, 1, 2];
		return $number . ' ' . $after[($number % 100 > 4 && $number % 100 < 20) ? 2 : $cases[min($number % 10, 5)]];
	}

	/**
	 * Отправляет письмо
	 *
	 * @param $layout - шаблон письма
	 * @param $user - модель пользователя
	 * @param $password - пароль пользователя
	 */
	public static function mail($layout, $user, $password)
	{
		Mail::send(
			'emails.' . $layout, ['user' => $user, 'password' => $password], function($m) use ($user) {
			$m->from('igorian.ru@mail.ru', 'Служба техподдержки');
			$m->to($user->email, $user->name)->subject('Создание аккаунта');
		}
		);
	}

	/**
	 * логирование внутренних ошибок
	 *
	 * $err - ошибка, класс Exception
	 * @param \Exception $err
	 */
	public static function logError(\Exception $err)
	{
		$file = '../storage/logs/system-error.log';
		error_log('Date: ' . date('Y-m-d H:m:s', time()) . "\n", 3, $file);
		error_log('Error message: ' . $err->getMessage() . "\n", 3, $file);
		error_log('File: ' . $err->getFile() . "\n", 3, $file);
		error_log('Line: ' . $err->getLine() . "\n\n", 3, $file);
	}

	/**
	 * @param \Exception $err
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public static function errorPage(\Exception $err)
	{
		Log::error('Error: ' . $err->getMessage());
		Log::error('File: ' . $err->getFile() . ' at line ' . $err->getLine());
		return self::view('admin::dashboard.error', ['error' => $err]);
	}

	/**
	 * формируем вьюху, с обязательными параметрами
	 *
	 * @param       $url - путь вьюхи
	 * @param array $args - аргументы
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public static function view($url, $args = [])
	{
		if(Auth::user()) {
			$args['segment3']  = \Request::segment(3);
			$args['left_menu'] = Base::getModule();
		}

		$args['version'] = '4.3.22-dev';
		$args['lang']    = Session::get('lang');

		$args['langSt']  = function($t, $l = '') {
			return Base::langSt($t, $l);
		};

		if(isset($args['meta_c']))
			$args['meta'] = $args['meta_c'];

		return view($url, $args);
	}

	/**
	 * Copy lang
	 * @param        $t
	 * @param string $lang
	 * @return mixed
	 */
	public static function langSt($t, $lang = '')
	{
		$arr  = is_array($t) ? $t : json_decode($t, true);
		$lang = empty($lang) ? \App::getLocale() : $lang;

		if(is_array($arr))
			if($arr[$lang] ?? false || $arr[$lang] === null)
				$t = $arr[$lang];
			else

				$t = current($arr) ?? $t;

		return $t;
	}

	/**
	 * @param $message
	 * @return \Illuminate\Http\JsonResponse
	 */
	public static function returnJSON($message)
	{
		return response()->json(['message' => $message]);
	}

	public static function view_cat($arr, $cat = 0, $i = 0, $rights, $menu = '')
	{
		$menuCurrent = '';

		if(empty($arr[$cat])) {
			return $menu;
		}

		if($i == 0) {
			$cj = 'class="files menu_tree"';
		} else {
			$cj = '';
		}

		$menu .= '<ul ' . $cj . ' >';

		if(!empty($arr[$cat])) {
			if(!($arr[$cat][$i]['id'] ?? true))
				$menuCurrent .= '<ul ' . $cj . ' >';

			if(!($arr[$cat][$i]['id'] ?? true))
				$liCurrent = true;

			//перебираем в цикле массив и выводим на экран
			for($i = 0; $i < count($arr[$cat]); $i++) {
				$l    = '#';
				$name = json_decode($arr[$cat][$i]['name'], true)[\App::getLocale()] ?? $arr[$cat][$i]['name'];

				$menu .= '
					<li class="rowID-' . $arr[$cat][$i]['id'] . '" id="rowID' . $arr[$cat][$i]['id'] . '">
						<div class="inp_edit_u inp_edit_' . $arr[$cat][$i]['id'] . '">
							<input
								type="radio"
								name="id_m"
								autocomplete="off"
								class="inp_edit flat"
								title="' . $name . '"
								value="' . $arr[$cat][$i]['id'] . '"
								id="' . $arr[$cat][$i]['id'] . '"
							/>
            </div>
            
            <a href="' . $l . '" >&nbsp;&nbsp;' . $name . '</a>';

				$menu .= Base::view_cat($arr, $arr[$cat][$i]['id'], $i, $rights, (!($liCurrent ?? false) ? '' : '</li>'));
			}

			return $menuCurrent . $menu . (!($liCurrent ?? false) ? '</li>' : '') . '</ul>';
		}

		return '';
	}

	/**
	 * @param string $param
	 * @return mixed
	 */
	public function getUser($param = '')
	{
		return $param ? (self::$user[$param] ?? self::$user) : self::$user;
	}

	/**
	 * @param        $url
	 * @param array  $args
	 * @param string $menu_mame
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function view_s($url, $args = [], $menu_mame = 'menu')
	{
		$args['menu'] = $this->get_cat($menu_mame, ['active' => 1]);

		/**/
		// при использовании языков идёт смещение сегментов урла
		if(\App::getLocale() == $this->requests->segment(1)) {
			$segment1 = $this->requests->segment(2);
			$segment2 = $this->requests->segment(3);
			$segment3 = $this->requests->segment(4);
		} else {
			$segment1 = $this->requests->segment(1);
			$segment2 = $this->requests->segment(2);
			$segment3 = $this->requests->segment(3);
		}

		if($segment3 && $segment1 != 'm') {
			$args['data'] = $this->dynamic->t('str')->where(['active' => 1, 'cat' => $segment3])->get()->toArray();
		} else {
			if(isset($args['field'])) {
				if($segment2 == '') {
					$text = htmlspecialchars(urldecode($segment1));
				} else {
					$text = htmlspecialchars(urldecode($segment2));
				}

				if($segment1 == 'm' && $segment3)
					$text = htmlspecialchars(urldecode($segment3));
				$menu = $this->dynamic->t($menu_mame)->where(['active' => 1, 'translation' => $text])->first();

				$args['data'] = $this
					->dynamic
					->t('str')
					->where(['active' => 1, $args['field'] => $text])
					->get()
					->toArray();

				if(empty($args['data']))
					$args['data'][0] = $menu;
			} else {
				if($segment2) {
					$menu = $this->dynamic->t($menu_mame)->where(['active' => 1, 'id' => $segment2])->first();

					$args['data'] = $this
						->dynamic
						->t('str')
						->where(['active' => 1, 'cat' => $segment2])
						->get()
						->toArray();

					if(empty($args['data'])) {
						$args['data'][0] = $menu;
					}
				} else {
					$menu = $this->dynamic->t($menu_mame)->where(['active' => 1, 'translation' => $segment1])->first();

					if(!empty($menu)) {
						$args['data'] = $this
							->dynamic
							->t('str')
							->where(['active' => 1, 'cat' => $menu->id])
							->get()
							->toArray();
					}

					if(empty($args['data'])) {
						$args['data'][0] = $menu;
					}
				}
			}
		}

		if(!empty($args['data'])) {
			$args['meta']['title']       = $this->lang($args['data'][0]['title']);
			$args['meta']['description'] = $this->lang($args['data'][0]['description']);
			$args['meta']['keywords']    = $this->lang($args['data'][0]['keywords']);
		}

		if(isset($args['meta'])) {
			if(!$segment1)
				$segment1 = 'main';

			$dat = $this->dynamic->t('seo')->where(['name' => $segment1])->get()->toArray();

			if(!empty($dat)) {
				$args['meta']['title']       = $this->lang($dat[0]['title']);
				$args['meta']['description'] = $this->lang($dat[0]['description']);
				$args['meta']['keywords']    = $this->lang($dat[0]['keywords']);
			}
		}

		$param = $this->dynamic->t('params')->select('params.*', 'little_description as key')->get();

		foreach($param as $key => $p)
			$args['params'][$p->name] = $p->toArray();

		if(isset($args['meta_c']))
			$args['meta'] = $args['meta_c'];

		$args['lang']     = \App::getLocale();
		$args['segment1'] = $segment1;

		$args['langSt'] = function($t, $l = '') {
			return $this->lang($t, $l);
		};

		$args['mount'] = function($m) {
			return $this->monthLang[\App::getLocale()][$m];
		};

		$args['isShowFavorite'] = count(array_values($this->requests->session()->get('cart') ?? []));

		if(isset($args['meta_d'])) {
			if(isset($args['meta_d']['title']))
				$args['meta']['title'] = $args['meta']['title'] . $args['meta_d']['title'];

			if(isset($args['meta_d']['description']))
				$args['meta']['description'] = $args['meta']['description'] . $args['meta_d']['description'];

			if(isset($args['meta_d']['keywords']))
				$args['meta']['keywords'] = $args['meta']['keywords'] . $args['meta_d']['keywords'];
		}

		return view($url, $args);
	}

	/**
	 * формируем массив меню для вывода деревом
	 *
	 * @param null   $table
	 * @param array  $where
	 * @param string $order
	 * @param string $sort
	 * @return array|null
	 */
	public function get_cat($table = null, $where = [], $order = 'order', $sort = 'ASC')
	{
		if(!$table) {
			$table = 'menu';
		}

		$Mod  = new DynamicModel();
		$data = $Mod->t($table)->where($where)->orderBy($order, $sort)->get();

		if(!$data) {
			return null;
		}

		$arr_cat = [];
		if(!empty($data)) {

			//В цикле формируем массив
			for($i = 0; $i < count($data); $i++) {
				$row = $data[$i];

				//Формируем массив, где ключами являются адишники на родительские категории
				if(empty($arr_cat[$row['cat']])) {
					$arr_cat[$row['cat']] = [];
				}

				$arr_cat[$row['cat']][] = $row->toArray();
			}

			//возвращаем массив
			return $arr_cat;
		} else {
			return [];
		}
	}

	/**
	 * is JSON
	 *
	 * @param $string
	 * @return bool
	 */
	static function is_json($string)
	{
		json_decode($string);
		return (json_last_error() == JSON_ERROR_NONE);
	}

	/**
	 * Get string to current lang
	 * @param        $t
	 * @param string $lang
	 * @return mixed
	 */
	public function lang($t, $lang = '')
	{
		$arr  = json_decode($t, true);
		$lang = empty($lang) ? \App::getLocale() : $lang;

		if(is_array($arr))
			if(json_decode($t, true)[$lang] ?? false || json_decode($t, true)[$lang] === null)
				$t = json_decode($t, true)[$lang];
			else

				$t = current(json_decode($t, true)) ?? $t;

		return $t;
	}

	/**
	 * @param array  $where
	 * @param null   $array
	 * @param int    $cat
	 * @param int    $parent
	 * @param int    $level
	 * @param string $table
	 * @param int    $idCat
	 * @param bool   $isList
	 * @return string
	 */
	public function _menu_site_select(
		$where = [],
		$array = null,
		$cat = 0,
		$parent = 0,
		$level = 0,
		$table = 'menu',
		$idCat = 0,
		$isList = false
	) {
		if(!$array)
			$array = $this->dynamic->t($table)->where($where)->get()->toArray();

		$l      = ['', '---', '-------', '-----------', '--------------', '-----------------', '----------------------'];
		$return = '';
		$left   = $l[$level];

		if(!$isList)
			foreach($array as $item) {
				if($cat == $item['id']) {
					$t = 'selected';
				} else {
					$t = '';
				}

				if($item['cat'] != $parent)
					continue;

				if($idCat === ($item['cat'] === 0 ? false : $item['cat']) || $idCat === 0) {
					$return .= '<option value="' . $item['id'] . '" ' . $t . '>
				' . $left . ' ' . $this->lang($item['name']) .
						'</option>';

					$idCat = 0;
				} else {
					if($level !== -1)
						$level--;
				}

				//вывод вложенных записей
				$return .= $this->_menu_site_select($where, $array, $cat, $item['id'], $level + 1, $table, $idCat);
			}
		else
			foreach($array as $item) {
				if($cat == $item['id']) {
					$t = 'selected';
				} else {
					$t = '';
				}

				$return .= '<option value="' . $item['id'] . '" ' . $t . '>
				' . $left . ' ' . $this->lang($item['name']) .
					'</option>';
			}

		return $return . '';
	}

	/**
	 * @param        $where
	 * @param string $cat
	 * @param string $table
	 * @return array|int|null
	 */
	function get_cat_c($where, $cat = '', $table = 'menu')
	{
		$Mod   = new DynamicModel();
		$array = $Mod->t($table)
			->where($where)
			->get()->toArray();

		if(!$array) {
			return null;
		}

		$arr_cat = [];

		//В цикле формируем массив
		for($i = 0; $i < count($array); $i++) {
			$row = $array[$i];

			//Формируем массив, где ключами являются адишники на родительские категории
			if(empty($arr_cat[$row['cat']])) {
				$arr_cat[$row['cat']] = [];
			}

			$arr_cat[$row['cat']][] = $row['id'];
		}

		$arr = [];
		if(isset($arr_cat[$cat])) {
			$arr = array_merge($arr, $arr_cat[$cat]);
			for($i = 0; $i < count($arr_cat[$cat]); $i++) {
				if(isset($arr_cat[$cat][$i])) {
					for($ii = 0; $ii < count($arr_cat[$cat][$i]); $ii++) {
						$id = $arr_cat[$cat][$i];

						if(isset($arr_cat[$id])) {
							if(isset($arr_cat[$id][$ii])) {
								for($iii = 0; $iii < count($arr_cat[$id][$ii]); $iii++) {
									$id2 = $arr_cat[$id][$ii];

									if(isset($arr_cat[$id2])) {

										$arr = array_merge($arr, $arr_cat[$id2]);
									} /*else {
											$arr = array_push($arr, $arr_cat[$id2][$iii]);
										}*/
								}
							} else {
								$arr = array_push($arr, $arr_cat[$id][$ii]);
							}

							$arr = array_merge($arr, $arr_cat[$id]);
						}/* else {
								$arr = array_push($arr, $arr_cat[$id]);
							}*/
					}
				} else {
					$arr = array_push($arr, $arr_cat[$cat][$i]);
				}
			}
		} else {
			$arr = [$cat];
		}

		return $arr;
	}

	/**
	 * function for transform to one-dimensional array
	 *
	 * @param $arr
	 * @return array|bool
	 */
	public function makeSingleArray($arr)
	{
		if(!is_array($arr))
			return false;
		$tmp = [];

		$arr = (isset($arr['offer'][0])) ? $arr['offer'] : [$arr['offer']];

		foreach($arr as $val) {
			$tmp[] = $this->_makeSingleArray($val, '');
		}

		return $tmp;
	}

	public function _makeSingleArray($arr, $key_arr = '')
	{
		if(!is_array($arr))
			return false;
		$tmp = [];
		$i   = 0;

		foreach($arr as $key => $val) {
			if(is_array($val) && isset($val[0]) == false) {
				$tmp = array_merge($tmp, $this->_makeSingleArray($val, $key));
			} else {
				$key_arr_p              = ($key_arr && !$i) ? '_' . $key_arr : '';
				$tmp[$key . $key_arr_p] = $val;
			}

			$i++;
		}

		return $tmp;
	}

	/**
	 * Get meta.
	 *
	 * @param array  $data
	 * @param string $key
	 * @return mixed
	 */
	public function getMeta(array $data = [], string $key = '')
	{
		if($data['title'] ?? false) {
			$meta['title']       = $this->lang($data['title']);
			$meta['description'] = $this->lang($data['description']);
			$meta['keywords']    = $this->lang($data['keywords']);
			$meta['author']      = $this->lang($data['author']);
			$meta['created_at']  = $data['created_at'];
			$meta['updated_at']  = $data['updated_at'];
		} else {
			$key                 = $key ? $key : key($data);
			$meta['title']       = $this->lang($data[$key]['title']);
			$meta['description'] = $this->lang($data[$key]['description']);
			$meta['keywords']    = $this->lang($data[$key]['keywords']);
			$meta['author']      = $this->lang($data[$key]['author']);
			$meta['created_at']  = $data[$key]['created_at'];
			$meta['updated_at']  = $data[$key]['updated_at'];
		}

		return $meta;
	}

	/**
	 * Decode serialize array.
	 *
	 * @param $array
	 * @return array
	 */
	public function decode_serialize($array)
	{
		$data = [];

		foreach($array as $v) {
			if(count(explode('[', $v['name'])) > 1) {
				$s = explode('[', $v['name']);

				if(!isset($data[$s[0]]))
					$data[$s[0]] = [];

				$data[$s[0]][str_replace(']', '', $s[1])] = $v['value'];
			} else
				$data[$v['name']] = $v['value'];
		}

		return $data;
	}

	function SelectedDiffs(&$sA, &$sB, &$retA, &$retB, $only_diff = false)
	{
		$this->SelDiffsText($sA, $sB, $retAText, $retBText);
		$this->MergeInsertAndDelete($retAText, $retBText);
		$this->SelDiffsColor($retAText, $retBText, $retA, $retB, $only_diff);
	}

	function SelDiffsText(&$aText, &$bText, &$retAText, &$retBText)
	{
		$arrA       = str_replace("r", "", $aText);
		$arrB       = str_replace("r", "", $bText);
		$arrA       = explode("\n", $arrA);
		$arrB       = explode("\n", $arrB);
		$unickTable = array_unique(array_merge($arrA, $arrB));

		$strA = $this->GetUnickStr($arrA, $unickTable);
		$strB = $this->GetUnickStr($arrB, $unickTable);

		$this->SelDiffsStr($strA, $strB, $retA, $retB);
		$retAText = $this->FromUnickToArr($retA, $unickTable);
		$retBText = $this->FromUnickToArr($retB, $unickTable);
	}

	function GetUnickStr(&$arr, &$arrUnick)
	{
		$s            = '';
		$arrUnickFlip = array_flip($arrUnick);
		foreach($arr as $v) {
			$s .= $arrUnickFlip[$v] . ' ';
		}
		return trim($s);
	}

	function SelDiffsStr(&$_a, &$_b, &$retA, &$retB)
	{
		$_longest = $this->GetLCSAlgoritm($_a, $_b);
		$longest  = explode(" ", $_longest);

		$a  = explode(" ", $_a);
		$b  = explode(" ", $_b);
		$rB = [];

		$i1 = 0;
		$i2 = 0;
		for($i = 0, $iters = count($b); $i < $iters; $i++) {
			$simbol = [];
			if(isset($longest[$i1]) && ($longest[$i1] ?? 0) == $b[$i2]) {
				if(isset($longest[$i1]))
					$simbol[] = $longest[$i1];

				$simbol[] = "*";
				$rB[]     = $simbol;
				$i1++;
				$i2++;
			} else {
				$simbol[] = $b[$i2];
				$simbol[] = "+";
				$rB[]     = $simbol;
				$i2++;
			}
		}
		$retB = $rB;

		$i1 = 0;
		$i2 = 0;
		for($i = 0, $iters = count($a); $i < $iters; $i++) {
			$simbol = [];
			if(isset($longest[$i1]) && ($longest[$i1] ?? 0) == $a[$i2]) {
				if(isset($longest[$i1]))
					$simbol[] = $longest[$i1];

				$simbol[] = "*";
				$rA[]     = $simbol;
				$i1++;
				$i2++;
			} else {
				$simbol[] = $a[$i2];
				$simbol[] = "-";
				$rA[]     = $simbol;
				$i2++;
			}
		}
		$retA = $rA;
	}

	public function GetLCSAlgoritm(&$_a, &$_b)
	{
		$a      = explode(" ", $_a);
		$b      = explode(" ", $_b);
		$maxLen = [];


		for($i = 0, $x = count($a); $i <= $x; $i++) {
			$maxLen[$i] = [];

			for($j = 0, $y = count($b); $j <= $y; $j++)
				$maxLen[$i][$j] = 0;
		}


		for($i = count($a) - 1; $i >= 0; $i--) {
			for($j = count($b) - 1; $j >= 0; $j--) {
				//				if(isset($maxLen[$i]))
				//					$maxLen = [$i];
				//
				//
				//
				//				if(isset($maxLen[$i][$j]))
				//					$maxLen[$i] = [$j];

				//				print_r($maxLen[$i][$j]);
				//				var_dump($maxLen[$i + 1][$j + 1] );

				if(($a[$i] ?? 0) == ($b[$j] ?? 0)) {
					$maxLen[$i][$j] = 1 + (isset($maxLen[$i + 1])
							? isset($maxLen[$i + 1][$j + 1]) ? $maxLen[$i + 1][$j + 1] : 0
							: 0);
				} else {
					$maxLen[$i][$j] = max($maxLen[$i + 1][$j], $maxLen[$i][$j + 1]);
				}
			}
		}

		$rez = "";

		for($i = 0, $j = 0; $maxLen[$i][$j] != 0 && $i < $x && $j < $y = count($b);) {
			if($a[$i] == $b[$j]) {
				$rez .= $a[$i] . " ";
				$i++;
				$j++;
			} else {
				if($maxLen[$i][$j] == $maxLen[$i + 1][$j] ?? 0)
					$i++;
				else $j++;
			}
		}

		//		exit;

		return trim($rez);
	}

	function FromUnickToArr(&$arrStr, &$arrUnick)
	{
		$r = [];
		foreach($arrStr as $v) {
			$buff   = [];
			$buff[] = $arrUnick[$v[0]];
			$buff[] = $v[1];
			$r[]    = $buff;
		}
		return $r;
	}

	function MergeInsertAndDelete(&$rdyAText, &$rdyBText)
	{
		$max = count($rdyAText) > count($rdyBText) ? count($rdyAText) : count($rdyBText);

		for($i1 = 0, $i2 = 0; $i1 < $max && $i2 < $max;) {
			if($rdyAText[$i1][1] == "-" && $rdyBText[$i2][1] == "+" && $rdyBText[$i2][0] != "") {
				$rdyAText[$i1][1] = "*";
				$rdyBText[$i2][1] = "m";
			} elseif($rdyAText[$i1][1] != "-" && $rdyBText[$i2][1] == "+")
				$i2++;
			elseif($rdyAText[$i1][1] == "-" && $rdyBText[$i2][1] != "+")
				$i1++;

			$i1++;
			$i2++;
		}
	}

	// ***********************************************************
	// 					Main function
	// ***********************************************************
	// string  $sA, $sB 	= 	strings where try find differences
	// string  $retA, $retB	=	strings for return result of work

	function SelDiffsColor(&$rdyAText, &$rdyBText, &$strRetA, &$strRetB, $only_diff)
	{
		$strRetA = "";
		$strRetB = "";

		foreach($rdyAText as $v) {
			if($v[1] == "+")
				$strRetA .= '<span style="color: #ac0b06;"><s>' . $v[0] . '</s></span>';
			elseif($v[1] == '-')
				$strRetA .= '<span style="color: #00cc33;">' . $v[0] . '</span>';
			elseif($v[1] == 'm')
				$strRetA .= '<span style="color: #2c2f88;">' . $v[0] . '</span>';
			elseif($v[1] == '*')
				if(!$only_diff)
					$strRetA .= $v[0];
		}

		foreach($rdyBText as $v) {
			if($v[1] == "+")
				$strRetB .= '<span style="color: #ac0b06;"><s>' . $v[0] . '</s></span>';
			elseif($v[1] == '-')
				$strRetB .= '<span style="color: #00cc33;">' . $v[0] . '</span>';
			elseif($v[1] == 'm')
				$strRetB .= '<span style="color: #2c2f88;">' . $v[0] . '</span>';
			elseif($v[1] == '*')
				if(!$only_diff)
					$strRetB .= $v[0];
		}
	}

	/**
	 * Range date.
	 *
	 * @param $date_time_from
	 * @param $date_time_to
	 * @return array
	 */
	function getDatesFromRange($date_time_from, $date_time_to)
	{
		// cut hours, because not getting last day when hours of time to is less than hours of time_from
		// see while loop
		$start = Carbon::createFromFormat('Y-m-d', substr($date_time_from, 0, 10));
		$end   = Carbon::createFromFormat('Y-m-d', substr($date_time_to, 0, 10));
		$dates = [];

		while($start->lte($end)) {
			$dates[] = $start->copy()->format('Y-m-d');
			$start->addDay();
		}

		return $dates;
	}
}
