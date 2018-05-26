<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Classes\DynamicModel;
use App\Http\Controllers\Controller;
use App\Modules\Admin\Classes\Base;
use App\Modules\Admin\Models\Booking_calendar;
use App\Modules\Admin\Models\Files;
use App\Modules\Admin\Models\Tags;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PluginsController extends Controller
{
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
	private $dynamic;

	public function __construct(Request $request)
	{
		parent::__construct();

		$this->request = $request->all();
		$this->files   = new Files();
		$this->dynamic = new DynamicModel();
	}

	/**
	 * Function generation field album
	 *
	 * @see FilesController::getLoaderAlbum()
	 * @param        $field
	 * @param string $table_params - table load params
	 * @param array  $params
	 * @return string
	 */
	public function album($field, $table_params = '', $params = [])
	{
		$id_album   = $params['id'];
		$name_table = $table_params;
		$Files      = $this->files;
		$files      = $Files->where(['name_table' => $params['table'] . $field['name'], 'id_album' => $id_album])->get();

		return Base::view(
			"admin::plugins.album.index",

			[
				'name'       => $field['name'],
				'plugin'     => $field,
				'id_album'   => $id_album,
				'name_table' => $params['table'],
				'files'      => $files,
			]
		);
	}

	/**
	 * @param        $field
	 * @param string $table_params
	 * @param array  $params
	 * @return string
	 */
	public function what_is_next($field, $table_params = '', $params = [])
	{
		return $this->album($field, $table_params, $params);
	}

	/**
	 * @param        $field
	 * @param string $table_params
	 * @param array  $params
	 * @return string
	 */
	public function working_conditions($field, $table_params = '', $params = [])
	{
		return $this->album($field, $table_params, $params);
	}

	/**
	 * @param        $field
	 * @param string $table_params
	 * @param array  $params
	 * @return string
	 */
	public function benefits($field, $table_params = '', $params = [])
	{
		return $this->album($field, $table_params, $params);
	}

	/**
	 * @param        $field
	 * @param string $table_params
	 * @param array  $params
	 * @return string
	 */
	public function benefits_accommodation($field, $table_params = '', $params = [])
	{
		return $this->album($field, $table_params, $params);
	}

	/**
	 * @param        $field
	 * @param string $table_params
	 * @param array  $params
	 * @return string
	 */
	public function collections($field, $table_params = '', $params = [])
	{
		return $this->album($field, $table_params, $params);
	}

	/**
	 * @param        $field
	 * @param string $table_params
	 * @param array  $params
	 * @return string
	 */
	public function main_img_small($field, $table_params = '', $params = [])
	{
		return $this->album($field, $table_params, $params);
	}

	/**
	 * Functions render tag filed
	 * @param        $field
	 * @param string $table_params
	 * @param array  $params
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function tags($field, $table_params = '', $params = [])
	{
		return Base::view(
			"admin::plugins.tags",

			[
				'field'  => ModuleController::_cat($field, $table_params),
				'plugin' => $field,
			]
		);
	}

	/**
	 * @return string
	 */
	public function getTagsList()
	{
		$tags = $this->dynamic->t('tags')->whereIn('tags.id', $this->request['id_tags'] ?? [])->get()->toArray();

		return json_encode(['items' => $tags, 'lang' => \App::getLocale()]);
	}

	/**
	 * @return string
	 */
	public function getTags()
	{
		$search_check = false;
		$q            = $this->request['q'];

		$tags = $this->dynamic->t('tags')
			->where('tags.name', 'like', '%' . $q . '%')
			->limit(100)
			->get()
			->toArray();


		$qUnicode = str_replace('\\', '\\', str_replace(['[', ']', '"'], '', json_encode([$q])));

		$tags_enc = $this->dynamic->t('tags')
			->where(
				'tags.name',
				'like',

				'%' . str_replace(
					'\\',
					'\\\\',
					str_replace(['[', ']', '"'], '', json_encode([mb_convert_case($q, MB_CASE_TITLE, "UTF-8")]))
				) . '%')

			->limit(100)
			->get()
			->toArray();

		$tags = array_merge($tags, $tags_enc);

		foreach($tags as $k => $v) {
			foreach(json_decode($v['name'], true) ?? [] as $val)
				if($val === $q)
					$search_check = true;

			if($v['name'] === $q)
				$search_check = true;

			// get string by current locale
			$tags[$k]['name'] = json_decode($v['name'], true)[\App::getLocale()] ?? $v['name'];
		}

		if(!$search_check)
			$tags = array_merge(
				$tags,

				[
					[
						'active'     => 1,
						'created_at' => null,
						'id'         => "new_{$q}",
						'is_new'     => true,
						'name'       => $q,
						'updated_at' => null,
					],
				]
			);

		return json_encode(
			[
				'incomplete_results' => false,
				'items'              => $tags,
				'result'             => 'ok',
				'total_count'        => count($tags),
				'q'                  => (string) str_replace(['[', ']', '"'], '', json_encode([$q])),
				'aq'                 => (json_decode($v['name'] ?? '', true)[\App::getLocale()] ?? false),
			]
		);
	}

	/**
	 * Insert tags
	 *
	 * @param      $value
	 * @param      $name
	 * @param null $id
	 * @return string
	 */
	public function insertTags($value, $name, $id = null)
	{
		$res = [];

		if($value && is_string($value))
			$value = [$value];

		foreach($value ?? [] as $v) {
			$tag = explode('new_', $v)[1] ?? false;

			if($tag) {
				$id  = (new Tags())->insertGetId(['name' => $tag, 'created_at' => Carbon::now()]);
				$res = array_merge($res, [(string) $id]);
			} else
				$res = array_merge($res, [(string) $v]);
		}

		return json_encode($res, JSON_UNESCAPED_UNICODE);
	}

	// --------------------------------------------- booking_calendar------------------------------------------------ //

	/**
	 * Load view fullCalendar
	 *
	 * @param        $field
	 * @param string $table_params
	 * @param array  $params
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function booking_calendar($field, $table_params = '', $params = [])
	{
		return Base::view(
			"admin::plugins.booking_calendar.index",

			[
				'field'  => $field['body']['text'],
				'plugin' => $field,
				'id'     => $params['id'],
				'lang'   => \App::getLocale(),
			]
		);
	}

	/**
	 * Get calendar row list
	 *
	 * @return string
	 */
	public function getCalendarList()
	{
		$tags = $this
			->dynamic
			->t('booking_calendar')
			->where('booking_calendar.villas_id', $this->request['villas_id'] ?? 0)
			->get()
			->toArray();

		return json_encode(['items' => $tags, 'lang' => \App::getLocale()]);
	}

	/**
	 * Select calendar row
	 *
	 * @return string
	 */
	public function setCalendarRow()
	{
		if($this->request['id'] ?? false) {
			$data              = (new Booking_calendar())->where(['id' => $this->request['id']])->first();
			$data->description = $this->request['description'];
			$data->end         = $this->request['end'];
			$data->id          = $this->request['id'];
			$data->start       = $this->request['start'];
			$data->title       = $this->request['title'];
			$data->save();
		} else {
			$data = [
				'created_at'  => Carbon::now(),
				'description' => $this->request['description'],
				'end'         => $this->request['end'],
				'start'       => $this->request['start'],
				'title'       => $this->request['title'],
				'villas_id'   => $this->request['villas_id'],
			];

			$id   = (new Booking_calendar())->insertGetId($data);
			$data = array_merge($data, ['id' => $id]);
		}

		return json_encode(['items' => $data, 'lang' => \App::getLocale()]);
	}

	/**
	 * Remove calendar row
	 *
	 * @return mixed
	 */
	public function removeCalendarRow()
	{
		return (new Booking_calendar())->where(['id' => $this->request['id']])->delete();
	}
	// --------------------------------------------- booking_calendar------------------------------------------------ //

	public function location($field, $table_params = '', $params = [])
	{
		return Base::view(
			"admin::plugins.location",

			[
				'field'  => ModuleController::_input($field),
				'plugin' => $field,
				'id'     => $params['id'],
				'lang'   => \App::getLocale(),
			]
		);
	}

	/**
	 * Load view Distances.
	 *
	 * @param        $field
	 * @param string $table_params
	 * @param array  $params
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function distances($field, $table_params = '', $params = [])
	{
		return Base::view(
			"admin::plugins.distances",

			[
				'field'  => ModuleController::_body($field, ['class' => 'distances-cont']),
				'plugin' => $field,
				'id'     => $params['id'],
				'lang'   => \App::getLocale(),
			]
		);
	}

	public function insertDistances($val){
		return json_encode($val, JSON_UNESCAPED_UNICODE);
	}

	/**
	 * Booking is easy.
	 *
	 * @param        $field
	 * @param string $table_params
	 * @param array  $params
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function booking_is_easy($field, $table_params = '', $params = [])
	{
		return Base::view(
			"admin::plugins.booking_is_easy",

			[
				'field'  => ModuleController::_body($field, ['class' => 'booking_is_easy']),
				'plugin' => $field,
				'id'     => $params['id'],
				'lang'   => \App::getLocale(),
			]
		);
	}

	/**
	 * @param $val
	 * @return string
	 */
	public function insertBooking_is_easy($val) {
		return json_encode($val, JSON_UNESCAPED_UNICODE);
	}

	/**
	 * Function generation field files
	 *
	 * @param        $field
	 * @param string $table_params - table load params
	 * @param array  $params
	 * @return string
	 */
	public function files($field, $table_params = '', $params = [])
	{
		$id_album   = $params['id'];
		$name_table = $table_params;

		$files = ($this->files)
			->where(['name_table' => $params['table'] . $field['name'], 'id_album' => $id_album])
			->get();

		$limit = $params['modules']['params'][$field['name']]['limit'] ?? -1;

		return Base::view(
			"admin::plugins.files.index",

			[
				'name'       => $field['name'],
				'plugin'     => $field,
				'id_album'   => $id_album,
				'name_table' => $params['table'],
				'files'      => $files,
				'limit'      => $limit,
			]
		);
	}

	public function translation($field, $table_params = '', $params = [])
	{
		$id_album   = $params['id'];

		$files = ($this->files)
			->where(['name_table' => $params['table'] . $field['name'], 'id_album' => $id_album])
			->get();

		$limit = $params['modules']['params'][$field['name']]['limit'] ?? -1;

		return Base::view(
			"admin::plugins.translation",

			[
				'name'       => $field['name'],
				'plugin'     => $field,
				'id_album'   => $id_album,
				'name_table' => $params['table'],
				'files'      => $files,
				'limit'      => $limit,
			]
		);
	}

	/**
	 * Functions render tag filed.
	 *
	 * @param        $field
	 * @param string $table_params
	 * @param array  $params
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function services($field, $table_params = '', $params = [])
	{
		return Base::view(
			"admin::plugins.tagers",

			[
				'class'  => 'services',
				'field'  => ModuleController::_cat($field, $table_params),
				'plugin' => $field,
				'lang'   => \App::getLocale(),
			]
		);
	}

	/**
	 * Insert tags
	 *
	 * @param      $value
	 * @param      $name
	 * @param null $id
	 * @return string
	 */
	public function insertTagers($value, $name, $id = null)
	{
		$res = [];

		foreach($value as $key => $v)
			$res[key($v)][] = array_shift($v);

		return json_encode($res, JSON_UNESCAPED_UNICODE);
	}

	/**
	 * Functions render tag filed.
	 *
	 * @param        $field
	 * @param string $table_params
	 * @param array  $params
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function convenience($field, $table_params = '', $params = [])
	{
		return Base::view(
			"admin::plugins.tagers",

			[
				'class'  => 'convenience',
				'field'  => ModuleController::_cat($field, $table_params),
				'plugin' => $field,
				'lang'   => \App::getLocale(),
			]
		);
	}

	/**
	 * Insert tags
	 *
	 * @param      $value
	 * @param      $name
	 * @param null $id
	 * @return string
	 */
	public function insertConvenience($value, $name, $id = null)
	{
		$res = [];

		foreach($value as $key => $v)
			$res[key($v)][] = array_shift($v);

		return json_encode($res, JSON_UNESCAPED_UNICODE);
	}

	/**
	 * Checkbox Check.
	 *
	 * @param      $value
	 * @param      $name
	 * @param null $id
	 * @return bool
	 */
	public function checkboxCheck($value, $name, $id = null)
	{
		return $value === 'on' ? 1 : 0;
	}
}