<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Classes\DynamicModel;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Modules\Admin\Classes\Base;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

/**
 * Class ModuleController
 * @package App\Modules\Admin\Http\Controllers
 */
class ModuleController extends Controller
{
	/**
	 * @var Request
	 */
	public static $requests_self;

	/**
	 * @var Base
	 */
	protected $base;

	/**
	 * @var array
	 */
	protected $request;

	/**
	 * @var
	 */
	protected $requests;

	/**
	 * @var DynamicModel
	 */
	private $dynamic;

	/**
	 * @var PluginsController
	 */
	private $plugins;

	/**
	 * ModuleController constructor.
	 * @param Request $request
	 */
	public function __construct(Request $request)
	{
		parent::__construct();

		$this->dynamic       = new DynamicModel();
		$this->plugins       = new PluginsController($request);
		$this->base          = new Base($request, Auth::user());
		$this->request       = $request->all();
		self::$requests_self = $this->requests = $request;
	}

	/**
	 * Функция рендера input.
	 *
	 * @param       $inp
	 * @param array $param
	 * @return string
	 */
	public static function _body($inp, $param = [])
	{
		return '<div class="form-group ' . ($param['class'] ?? '') . '">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">
			' . ($inp['translateKey'] ?? false ? trans('admin::plugins.' . $inp['translateKey']) : $inp['nameText']) . '
			</label>
			
			<input type="hidden" id="' . $inp['idAttr'] . '-]-options-[-" />
			<div class="col-md-6 col-sm-6 col-xs-12">' . ($inp['body']['text'] ?? '') . '</div>
			<br class="clear" />
		</div>';
	}

	/**
	 * функция для подгрузки инфы
	 * @param $page
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|string|\Symfony\Component\HttpFoundation\Response
	 */
	public function getData($page)
	{
		try {
			$requests = $this->requests;
			$Mod      = $this->dynamic;
			$t        = $this->requests->segment(3);
			$length   = $this->request['iDisplayLength'];
			$skip     = $this->request['iDisplayStart'];
			$sort     = $this->request['sSortDir_0'];
			$search   = $this->request['sSearch'];
			$sortF    = $this->request['mDataProp_' . $this->request['iSortCol_0']];
			$locale   = \App::getLocale();
			$modules  = Base::getModule("link_module", $page)[0];
			$plugins  = config('admin.plugins');
			$st       = [trans('admin::main.hidden'), trans('admin::main.shown')];

			$status_room = [
				0 => trans('admin::main.free'),
				1 => trans('admin::main.reservation'),
				2 => trans('admin::main.reservation'),
			];

			$where       = [];
			$where_get   = [];
			$columnSel   = [];
			$plugins_sel = [];

			foreach($modules['filters'] as $v)
				$plugins_sel[$v] = $plugins[$v];
			foreach($modules['column_index'] as $v)
				$columnSel[$v] = $plugins[$v];

			foreach($plugins_sel as $v) {
				if($requests['pl'][$v['name']] !== '') {
					$where_get[$v['name']] = $requests['pl'][$v['name']];

					if($requests['pl'][$v['name']])
						$where[$page . '.' . $v['name']] = $requests['pl'][$v['name']];
				}
			}

			$query = $Mod->t($t)
				->where($where)
				->join(
					'files',

					function($join) use ($t) {
						$join->type = 'LEFT OUTER';

						$join->on($t . '.id', '=', 'files.id_album')
							->where('files.name_table', '=', $t . 'album')
							->where('files.main', '=', 1);
					}
				);

			if(($modules['showOnlyYour'] ?? false) && $this->base->getUser('usertype') !== 'admin' &&
				$this->base->getUser('user_another_type') !== 'specialist')
				$query->where($t . '.user_id', '=', $this->base->getUser('id'));

			$req['data'] = $query->select($t . '.*', 'files.file', 'files.crop')
				->groupBy($t . '.id', 'files.file', 'files.crop')
				->orderBy(($sortF === 'album' ? 'files' : $t) . '.' . ($sortF === 'album' ? 'file' : $sortF), $sort)
				->where($t. '.name', 'like', '%' . trim($search ?? '') . '%')
				->skip($skip)
				->take($length)
				->get()
				->toArray();

			foreach($req['data'] as $key => $val) {
				$id = '<tr class="rowID-' . $val['id'] . '" ><td class="a-center " >
			<input value="' . $val['id'] . '" id="' . $val['id'] . '"  type="radio" title="' .
					$this->base->lang($val['name']) . '"
			class="flat flt-' . $val['id'] . '" name="table_records" >';

				if(!trim($modules['link_site_module']) == "") {
					$id .= '<a href="' . $modules['link_site_module'] . $val['id'] . '" title="Посмотреть на сайте" target="_blank" >
				<i class="fa fa-mail-forward" ></i >' . $val['id'] . ' </a >';
				}

				$req['data'][$key]['id'] = $id;

				foreach($columnSel as $v) {
					switch($v['name']) {
					case 'album':
						if(isset($val['file'])) {
							if($val['crop'] != '') {
								$album = '<img src="/images/files/small/' . $val['crop'] . '" style="max-width: 200px"/>';
							} else {
								$album = '<img src="/images/files/small/' . $val['file'] . '" style="max-width: 200px"/>';
							}
						} else {
							if(isset($val['name_free'])) {
								$album = '<img src="' . $val['name_free'] . '" style="max-width: 200px"/>';
							} else {
								$album = '<img src="/images/files/no-image.jpg" style="max-width: 200px"/>';
							}
						}

						$req['data'][$key]['album'] = $album;
					break;

					case 'name':
						$val_name = $this->base->lang($val['name']);

						$name = '<a href="/admin/update/' . $modules['link_module'] . '/' . $val['id'] . '">';
						$name .= (trim($val_name) == "") ? trans('admin::main.reservation') : $val_name;
						$name .= '</a>';

						$req['data'][$key]['name'] = $name;
					break;

					case 'little_description':
						$req['data'][$key]['little_description'] = mb_substr(
							htmlspecialchars($this->base->lang($val['little_description'])),
							0,
							100,
							'UTF-8'
						);
					break;
					break;

					case 'cat':
						$cat = $val[$v['name']];

						$cat_data = $Mod->t($modules['menu_table_name'] ?? 'menu')
							->where('id', $cat)
							->first();

						$req['data'][$key]['cat'] = $cat_data['name'] ?? false
								? '<a href="?pl[cat]=' . $cat . '">' . $this->base->lang($cat_data['name']) . '</a>'
								: trans('admin::main.not_category');
					break;

					case 'text':
						$req['data'][$key]['text'] = mb_substr(
							htmlspecialchars(strip_tags($this->base->lang($val['text']))),
							0,
							100,
							'UTF-8'
						);
					break;

					case 'status_room':
						$req['data'][$key]['status_room'] = $status_room[$val[$v['name']]];
					break;

					case 'active':
						$req['data'][$key]['active'] = $st[$val[$v['name']]];
					break;

					case 'tags':
						$id        = json_decode($val['tags'], true);
						$tags_name = '';
						$tags      = $this->dynamic->t('tags')->whereIn('id', $id)->get()->toArray();

						foreach($tags as $tag)
							$tags_name .= '#' . $this->base->lang($tag['name']) . ' ';

						$tags_name = mb_substr(htmlspecialchars(strip_tags($tags_name)), 0, 100, 'UTF-8');

						$req['data'][$key]['tags'] = empty($tags_name) ? '—' : $tags_name;
					break;

					default:
						$v_name = $this->base->lang($val[$v['name']]);

						$req['data'][$key][$v['name']] = (!trim($v_name)) ? '—' : $v_name;
					}
				}
			}

			$tt = $Mod->t($t)->select('id')->where($where)->get()->toArray();

			$req['iTotalRecords']        = count($tt);
			$req['iTotalDisplayRecords'] = count($tt);
			$req['where']                = $where;
			$req['where_get']            = $where_get;

			return json_encode($req);
		} catch(\Exception $err) {
			return response($err->getMessage(), 500);
		}
	}

	/**
	 *  просмотр (выбод списков)
	 * @param $page
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index($page)
	{
		try {
			$requests = $this->requests;
			$cat      = $this->requests['cat'];
			$get_id   = isset($this->requests['id']) ? $this->requests['id'] : 0;
			$t        = $this->requests->segment(3);

			unset($requests['q']);

			$url     = explode('?', $requests->fullUrl());
			$ses_url = (isset($_SESSION['url'])) ? $_SESSION['url'] : false;

			if(count($url) > 1) {
				$url = $url[count($url) - 1];
			} else {
				$url = '';
			}

			if(strlen($url) < 50)
				$url = '';

			if(!$ses_url) {
				$_SESSION['url'] = $url;
			} else {
				if($url != '' || $url = !$ses_url) {
					$_SESSION['url'] = $url;;
				} else {
					$url = $ses_url;
				}
			}

			$menu        = $this->base->get_cat($page);
			$modules     = Base::getModule("link_module", $page)[0];
			$plugins     = config('admin.plugins');
			$plugins_sel = [];
			$columnSel   = [];
			$filters     = [];
			$where_get   = [];

			foreach($modules['filters'] as $v)
				$plugins_sel[$v] = $plugins[$v];
			foreach($modules['column_index'] as $v)
				$columnSel[$v] = $plugins[$v];

			foreach($plugins_sel as $c) {
				$filters[$c['name']]         = $c;
				$filters[$c['name']]['html'] = $this->_switch($c, $modules['menu_table_name']);
			}

			foreach($filters as $v)
				if($requests['pl'][$v['name']])
					$where_get[$v['name']] = $requests['pl'][$v['name']];

			if($modules['sort']) {
				$sort = $this->base->_menu_site_select(['sort' => $page]);
			} else {
				$sort = false;
			}

			return Base::view(
				"admin::module.index",

				[
					'cat'       => $cat,
					'column'    => $columnSel,
					'data'      => [],
					'get_id'    => $get_id,
					'filters'   => $filters,
					'menu'      => Base::view_cat($menu, 0, 0, 1),
					'modules'   => $modules,
					'right'     => Session::get('right'),
					'sort'      => $sort,
					'table'     => $t,
					'where_get' => $where_get,
					'url'       => $url,
				]
			);
		} catch(\Exception $err) {
			return response($err->getMessage(), 500);
		}
	}

	/**
	 * switch
	 *
	 * @param $c - array fields
	 * @param $t - table name
	 * @param $p - params
	 * @return string
	 */
	private function _switch($c, $t, $p)
	{
		$plugins = '';
		$name    = $c['name'];

		if($c['typeField'] == 'input')
			$plugins = $this->_input($c);

		if($c['typeField'] == 'textarea')
			$plugins = $this->_textarea($c);

		if($c['typeField'] == 'select')
			$plugins = $this->_cat($c, $t, $p);

		if($c['typeField'] == 'checkbox')
			$plugins = $this->_checkbox($c);

		if($c['typeField'] == 'functions')
			$plugins = $this->plugins->$name($c, $t, $p);

		return $plugins;
	}

	/**
	 * функция рендера input
	 * @param $inp
	 * @return string
	 */
	public static function _input($inp)
	{
		$classAttr = isset($inp['classAttr']) ? $inp['classAttr'] : '';
		$maxlength = isset($inp['maxlength']) ? 'maxlength="' . $inp['maxlength'] . '"' : '';
		$type      = isset($inp['type']) ? $inp['type'] : 'text';

		return '<div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">' . ($inp['translateKey'] ?? false ? trans('admin::plugins.' . $inp['translateKey']) : $inp['nameText']) . '</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="' . $type . '" ' . $maxlength . ' name="' . $inp['nameAttr'] . '--options--" id="' . $inp['idAttr'] . '" class="form-control ' . $classAttr . '" placeholder="' . ($inp['translateKey'] ?? false ? trans('admin::plugins.' . $inp['translateKey']) : $inp['nameText']) . '">
            </div>
             <br class="clear"/>
        </div>';
	}

	/**
	 * функция рендера checkbox
	 * @param $inp
	 * @return string
	 */
	public static function _checkbox($inp)
	{
		$classAttr    = isset($inp['classAttr']) ? $inp['classAttr'] : '';
		$classAttrDiv = isset($inp['classAttrDiv']) ? $inp['classAttrDiv'] : '';
		$maxlength    = isset($inp['maxlength']) ? 'maxlength="' . $inp['maxlength'] . '"' : '';

		return '<div class="form-group ' . $classAttrDiv . '">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">' . ($inp['translateKey'] ?? false ? trans('admin::plugins.' . $inp['translateKey']) : $inp['nameText']) . '</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="checkbox" ' . $maxlength . ' name="' . $inp['nameAttr'] . '--options--" id="' . $inp['idAttr'] . '" class="form-control ' . $classAttr . '" placeholder="' . ($inp['translateKey'] ?? false ? trans('admin::plugins.' . $inp['translateKey']) : $inp['nameText']) . '">
            </div>
             <br class="clear"/>
        </div>';
	}

	/**
	 * функция рендера textarea
	 * @param $inp
	 * @return string
	 */
	public static function _textarea($inp)
	{
		$classAttr = isset($inp['classAttr']) ? $inp['classAttr'] : '';
		$maxlength = isset($inp['maxlength']) ? 'maxlength="' . $inp['maxlength'] . '"' : '';
		$rows = isset($inp['rows']) ? 'rows="' . $inp['rows'] . '"' : '';

		return '<div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">' . ($inp['translateKey'] ?? false ? trans('admin::plugins.' . $inp['translateKey']) : $inp['nameText']) . '</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <textarea ' . $rows . $maxlength . ' class="form-control ' . $classAttr . '" id="' . $inp['idAttr'] . '" name="' . $inp['nameAttr'] . '--options--" placeholder="' . ($inp['translateKey'] ?? false ? trans('admin::plugins.' . $inp['translateKey']) : $inp['nameText']) . '" rows="3"></textarea>
            </div>
             <br class="clear"/>
        </div>';
	}

	/**
	 * функция рендера select
	 *
	 * @param      $inp
	 * @param      $table
	 * @param null $page
	 * @return string
	 */
	public static function _cat($inp, $table, $page = null)
	{
		$modules = Base::getModule("link_module", $page['table'])[0];
		$params  = $modules['params'] ?? [];

		if($page['table'] ?? false) {
			$idCatShow = $modules['idCatShow'][$inp['name']]?? 0;
		} else
			$idCatShow = 0;

		$list_base = function() use ($inp, $table, $modules, $idCatShow) {
			return (new Base(self::$requests_self))->_menu_site_select(
				[],
				null,
				0,
				0,
				0,
				$inp['parent_table'] ?? $table,
				$idCatShow,
				(array_search($inp['name'], $modules['isList'] ?? []) !== false)
			);
		};

		if($inp['body']['type'] = 'insert') {
			if(isset($params[$inp['name']])) {
				$params = $params[$inp['name']];

				if(isset($params['table'])) {
					$menu_cat = '';

					$list = DynamicModel::t($params['table'])
						->where($params['where'])
						->get()
						->toArray();

					foreach($list as $v)
						$menu_cat .= '<option value="' . $v['id'] . '">' . Base::langSt($v['name']) . '</option>';
				} else {
					$menu_cat = $list_base();
				}
			} else {
				$menu_cat = $list_base();
			}

			$sel = str_replace('{-option-}', $menu_cat, $inp['body']['text']);
		} else {
			$sel = $inp['body']['text'];
		}

		$classAttr = isset($inp['classAttr']) ? $inp['classAttr'] : '';
		$multiple  = ($inp['body']['multiple'] ?? false) ? 'multiple' : '';

		if($multiple)
			$inp['nameAttr'] = $inp['nameAttr'] . '[]';

		return '<div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">' . ($inp['translateKey'] ?? false ? trans('admin::plugins.' . $inp['translateKey']) : $inp['nameText']) . '</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select ' . $multiple . ' name="' . $inp['nameAttr'] . '--options--" id="' . $inp['idAttr'] . '" class="form-control ' . $classAttr . '">
                    ' . $sel . '
                </select>
            </div>
            <br class="clear"/>
        </div>';
	}

	/**
	 * копирование
	 * @param     $page
	 * @param int $id
	 * @return mixed
	 */
	public function copy($page, $id = 0)
	{
		try {
			$Mod  = $this->dynamic;
			$data = $Mod->t($page)->where(['id' => $id])->first()->toArray();
			unset($data['id']);

			$data['name'] = 'Копия ' . $this->base->lang($data['name']);

			if($data['email'])
				$data['email'] = 'Копия ' . $data['email'];

			$data['updated_at'] = $data['created_at'] = Carbon::now();
			$id                 = $Mod->t($page)->insertGetId($data);

			return redirect('/admin/update/' . $page . '/' . $id);
		} catch(\Exception $err) {
			return response($err->getMessage(), 500);
		}
	}

	/**
	 * редактирование и добавление
	 * @param      $page
	 * @param int  $id
	 * @param null $apply
	 * @return mixed
	 */
	public function update($page, $id = 0, $apply = null)
	{
		try {
			$plugins = config('admin.plugins');
			$url     = (isset($_SESSION['url'])) ? '?' . $_SESSION['url'] : '';
			$modules = Base::getModule("link_module", $page)[0];

			if($id === 'main_page') {
				$modules['plugins'] = $modules['main_page'];
				$modules['lang']    = $modules['lang_main_page'];
			}

			if(isset($this->request['pl'])) {
				if(!empty($id)) {
					// редактированине
					if($id == 'main_page') {

						if(!$this->dynamic->t($id)->where(['table' => $page])->first())
							$this->dynamic->t($id)->insertGetId(['created_at' => Carbon::now(), 'table' => $page]);

						$data        = $this->dynamic->t($id)->where(['table' => $page])->first();
						$dataArray   = $this->dynamic->t($id)->where(['table' => $page])->first()->toArray();
					} else {
						$data      = $this->dynamic->t($page)->where(['id' => $id])->first();
						$dataArray = $this->dynamic->t($page)->where(['id' => $id])->first()->toArray();
					}

					// если поле массив(multiple), то без выбранного значения(при очистке) в pl оно вообще не приходит, по этому
					// для очистки надо принудительно ему задать пустой массив
					foreach($dataArray as $key => $v)
						if($plugins[$key]['body']['multiple'] ?? false)
							$this->request['pl'][$key] = $this->request['pl'][$key] ?? [];

					foreach($modules['plugins'] as $key) {
						$data->$key = is_array($this->request['pl'][$key])
							? json_encode($this->request['pl'][$key], JSON_UNESCAPED_UNICODE)
							: $this->request['pl'][$key];

						if($data->$key == '[]')
							$data->$key = '';

						// functionsBefore
						if($plugins[$key]['functionsBefore'] ?? false) {
							$functionsBefore = $plugins[$key]['functionsBefore'];
							$data->$key      = $this->plugins->$functionsBefore($this->request['pl'][$key], $key, null);
						}

						if($plugins[$key]['noSaveInDatabase'])
							unset($data->$key);
					}

					$data->updated_at = Carbon::now();
					$result_a_ar      = [];
					$result_b_ar      = [];
					$data->save();

					/* DIFF */
					foreach($this->request['pl'] as $kk => $vv) {
						$text_b = Base::is_json($dataArray[$kk]) ? json_decode($dataArray[$kk], true) : $dataArray[$kk];

						$result_a = '';
						$result_b = '';
						$text_a   = $vv;

						if(is_array($text_a)) {
							foreach($text_a as $key => $v) {
								$a = strip_tags($text_a[$key]);
								$b = strip_tags($text_b[$key]);

								$this->base->SelectedDiffs($a, $b, $result_a, $result_b, true);

								if(isset($result_a_ar[$kk][$key]))
									$result_a_ar[$kk] = [];

								$result_a_ar[$kk][$key] = $result_a;
								$result_b_ar[$kk][$key] = $result_b;
							}
						} else {
							$a = strip_tags($text_a);
							$b = strip_tags($text_b);

							$this->base->SelectedDiffs($a, $b, $result_a, $result_b, true);
							$result_a_ar[$kk] = $result_a;
							$result_b_ar[$kk] = $result_b;
						}
					}

					foreach($result_a_ar as $k => $r) {
						if(is_array($r)) {
							$s = false;

							foreach($r as $rr) {
								if(!empty($rr)) {
									$s = true;

									continue;
								}
							}
						} else
							$s = !empty($r);

						if(!$s)
							unset($result_a_ar[$k]);
					}

					foreach($result_b_ar as $k => $r) {
						if(is_array($r)) {
							$s = false;
							foreach($r as $rr) {
								if(!empty($rr)) {
									$s = true;

									continue;
								}
							}
						} else
							$s = !empty($r);

						if(!$s)
							unset($result_b_ar[$k]);
					}
					/* DIFF END */

					if(!empty($result_a_ar) || !empty($result_b_ar))
						// create item log action
						SettingsController::addingLogActions(
							[
								'table_name'     => $page,
								'table_row_id'   => $data->id ?? null,
								'users_id'       => Base::$user['id'],
								'type_actions'   => 'update_table_row',
								'table_tow_name' => $data->name ?? 'no name',
								'text'           => json_encode(['a' => $result_a_ar, 'b' => $result_b_ar], JSON_UNESCAPED_UNICODE),
							]
						);
				} else {
					$data = [];

					foreach($this->request['pl'] as $key => $v) {
						$data[$key] = is_array($v) ? json_encode($v, JSON_UNESCAPED_UNICODE) : $v;

						if($data[$key] == '[]')
							$data[$key] = '';

						// functionsBefore
						if($plugins[$key]['functionsBefore'] ?? false) {
							$functionsBefore = $plugins[$key]['functionsBefore'];
							$data[$key]      = $this->plugins->$functionsBefore($v, $key, null);
						}
					}

					$data['created_at'] = Carbon::now();
					$data['user_id']    = $this->base->getUser('id');
					$id                 = $this->dynamic->t($page)->insertGetId($data);

					// create item log action
					SettingsController::addingLogActions(
						[
							'table_name'     => $page,
							'table_row_id'   => $id,
							'users_id'       => Base::$user['id'],
							'type_actions'   => 'insert_table_row',
							'table_tow_name' => $data['name'] ?? 'no name',
						]
					);
				}

				if($apply) {
					return redirect('/admin/update/' . $page . '/' . $id);
				} else {
					$need = isset(explode('?', $url)[1]) ? '' : '?';
					return redirect('/admin/index/' . $page . $need . 'id=' . $id . '#rowID' . $id);
				}
			} else {
				if($id)
					if($id == 'main_page')
						$data = $this->dynamic->t($id)->where(['table' => $page])->first();
					else
						$data = $this->dynamic->t($page)->where(['id' => $id])->first();
				else
					$data = [];

				// TODO пересмотреть политику дополнительных админов
				if(($modules['showOnlyYour'] ?? false) && $this->base->getUser('usertype') !== 'admin' && $this->base->getUser('user_another_type') !== 'specialist')
					if($data->user_id !== $this->base->getUser('id') && $data->user_id)
						abort(503, 503);

				$plugins          = config('admin.plugins');
				$plugins_sel      = [];
				$plugins_sel_tabs = [];
				$js_init_function = [];
				$plugins_lang     = [];

				foreach($modules['plugins'] as $v)
					$plugins_sel[$v] = $plugins[$v];

				foreach($plugins_sel as $k => $c) {
					$plugins_sel[$k]['html_top']    = '';
					$plugins_sel[$k]['html_bottom'] = '';
					$plugins_sel[$k]['html']        = ''; /* !!!!! */

					$showOnly          = is_array($c['showOnly'] ?? false) ? $c['showOnly'] : [];
					$isUserType        = array_search($this->base->getUser('usertype'), $showOnly);
					$isUserAnotherType = array_search($this->base->getUser('user_another_type'), $showOnly);

					if(empty($showOnly))
						$plugins_sel[$k]['html'] = $this->_switch(
							$c,
							$modules['menu_table_name'],
							['id' => $id, 'table' => $page, 'modules' => $modules]
						);
					else
						if($isUserType !== false || $isUserAnotherType !== false)
							$plugins_sel[$k]['html'] = $this->_switch(
								$c,
								$modules['menu_table_name'],
								['id' => $id, 'table' => $page, 'modules' => $modules]
							);
						else
							unset($plugins_sel[$k]);

					if($plugins_sel[$k]['html'] ?? false) {
						if(isset($c['body']['text']) && $plugins_sel[$k]['html'] == '') {
							$plugins_sel[$k]['html'] = $c['body']['text'];
						}

						// проверяем к какому табу принадлежит поле, смотрим надо ли его вынести в таб языков, если не то определяем
						// родительский таб и заносим поле в него
						if(array_search($plugins_sel[$k]['name'], $modules['lang']) !== false) {
							$plugins_lang[] = $plugins_sel[$k];
						} else {
							if(isset($plugins_sel[$k]['tabs'])) {
								$plugins_sel_tabs[$plugins_sel[$k]['tabs']][$k] = $plugins_sel[$k];
							} else {
								$plugins_sel_tabs['basic'][$k] = $plugins_sel[$k];
							}
						}

						if($plugins_sel[$k]['js_init_function'] ?? false)
							$js_init_function[] = $plugins_sel[$k]['js_init_function'];
					}
				}

				$lang = $this->dynamic->t('params_lang')->get()->toArray();

				if(isset($data['little_description']))
					$data['little_description'] = htmlspecialchars($data['little_description']);

				if(isset($data['html_top']))
					$data['html_top'] = htmlspecialchars($data['html_top']);
				if(isset($data['html_bottom']))
					$data['html_bottom'] = htmlspecialchars($data['html_bottom']);

				return Base::view(
					"admin::module.update",

					[
						'plugins'          => $plugins_sel,
						'plugins_tabs'     => $plugins_sel_tabs,
						'lang_array'       => $lang,
						'modules'          => $modules,
						'data'             => $data,
						'page'             => $page,
						'id'               => $id,
						'plugins_lang'     => $plugins_lang,
						'right'            => Session::get('right'),
						'show_lang'        => !empty($modules['lang']),
						'js_init_function' => $js_init_function,
						'order'            => $modules['plugins'],
						'url'              => $url,
					]
				);
			}
		} catch(\Exception $err) {
			if($err->getMessage() == 503)
				return abort(503);

			return response($err->getMessage(), 500);
		}
	}
}
