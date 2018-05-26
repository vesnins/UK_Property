<?php

namespace App\Http\Controllers;

use App\Classes\DynamicModel;
use App\Modules\Admin\Classes\Base;
use App\Modules\Admin\Http\Controllers\FilesController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MainController extends Controller
{
	/**
	 * @var Base
	 */
	protected $base;

	/**
	 * @var DynamicModel
	 */
	private $dynamic;

	/**
	 * @var array
	 */
	private $request;

	/**
	 * @var Request
	 */
	private $requests;

	public function __construct(Request $request)
	{
		$this->base     = new Base($request);
		$this->dynamic  = new DynamicModel();
		$this->request  = $request->all();
		$this->requests = $request;
	}

	/**
	 * Main page.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function main()
	{
		$whereBlog[]   = ['blog.active', 1];
		$whereBlog[]   = ['blog.tags', '!=', '\'\''];
		$whereVillas[] = ['villas.active', 1];

		$data['blog'] = $this->dynamic->t('blog')
			->where($whereBlog)

			->join(
				'files',

				function($join) {
					$join->type = 'LEFT OUTER';
					$join->on('blog.id', '=', 'files.id_album')
						->where('files.name_table', '=', 'blogalbum')
						->where('files.main', '=', 1);
				}
			)

			->select('blog.*', 'files.file', 'files.crop')
			->groupBy('blog.id')
			->orderBy('blog.id', 'DESC')
			->paginate(4);

		$data['villas'] = $this->dynamic->t('villas')
			->where($whereVillas)

			->join(
				'files',

				function($join) {
					$join->type = 'LEFT OUTER';
					$join->on('villas.id', '=', 'files.id_album')
						->where('files.name_table', '=', 'villasalbum')
						->where('files.main', '=', 1);
				}
			)

			->select('villas.*', 'files.file', 'files.crop')
			->groupBy('villas.id')
			->orderBy('villas.id', 'DESC')
			->orderBy('villas.is_best', 'ASC')
			->paginate(10);

		$data['preview'] = $this
			->dynamic
			->t('files')
			->where('name_table', 'mainalbum')
			->orderBy('order', 'ASC')
			->get()
			->toArray();

		$data['collections'] = $this
			->dynamic
			->t('files')
			->where('name_table', 'maincollections')
			->orderBy('order', 'ASC')
			->get()
			->toArray();

		$data['img_mobile'] = $this
			->dynamic
			->t('files')
			->where('name_table', 'mainmain_img_small')
			->orderBy('order', 'ASC')
			->first()
			->toArray();

		$data['locations'] = $this->dynamic
			->t('locations')
			->where([['locations.active','=', 1]])

			->join(
				'villas',

				function($join) {
					$join->type = 'LEFT';
					$join->on('villas.cat_location', '=', 'locations.cat');
				}
			)

			->join(
				'files',

				function($join) {
					$join->type = 'LEFT OUTER';
					$join->on('locations.id', '=', 'files.id_album')
						->where('files.name_table', '=', 'locationsalbum')
						->where('files.main', '=', 1);
				}
			)

			->select('locations.*', 'files.file', 'files.crop')
			->groupBy('villas.cat_location')
			->get()
			->toArray();

		$data['locations_main'] = $this->dynamic
			->t('locations')
			->where([['locations.active','=', 1], ['locations.to_main','=', 1]])

			->join(
				'files',

				function($join) {
					$join->type = 'LEFT OUTER';
					$join->on('locations.id', '=', 'files.id_album')
						->where('files.name_table', '=', 'locationsalbum')
						->where('files.main', '=', 1);
				}
			)

			->select('locations.*', 'files.file', 'files.crop')
			->limit(2)
			->get()
			->toArray();

		$data['main_page'] = $this
			->dynamic
			->t('main')
			->where('main.active', 1)

			->join(
				'files',

				function($join) {
					$join->type = 'LEFT OUTER';
					$join->on('main.id', '=', 'files.id_album')
						->where('files.name_table', '=', 'mainalbum')
						->where('files.main', '=', 1);
				}
			)

			->select('main.*', 'files.file', 'files.crop')
			->first()
			->toArray();

		$data['main_page_video'] = $this
			->dynamic
			->t('files')
			->where('files.name_table', '=', 'mainfiles')
			->get()
			->toArray();

		$data['meta_c']    = $this->base->getMeta($data['main_page']);

		return $this->base->view_s("site.main.index", $data);
	}

	/**
	 * errors_404.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function errors_404()
	{
		return $this->base->view_s("errors.404", []);
	}

	/**
	 * Selection request.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function selection_request()
	{
		$data['locations'] = $this->dynamic->t('locations')->where('locations.active', 1)->get()->toArray();

		return $this->base->view_s("site.main.selection_request", $data);
	}

	/**
	 * Request for accommodation.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function request_for_accommodation()
	{
		$data['benefits_accommodation'] = $this->dynamic->t('files')
			->where('files.name_table', '=', 'mainbenefits_accommodation')
			->select('files.*', 'files.file', 'files.crop')
			->get()
			->toArray();

		return $this->base->view_s("site.main.request_for_accommodation", $data);
	}

	/**
	 * Favorite.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function favorite()
	{
		$id_segment = $this->requests->segment(1);

		if(!is_numeric($id_segment))
			$where_id = ['menu.translation' => $id_segment];
		else
			$where_id = ['menu.id' => $id_segment];

		$data['menu_segment'] = $this->dynamic->t('menu')
			->where($where_id)

			->join(
				'files',

				function($join) {
					$join->type = 'LEFT OUTER';
					$join->on('menu.id', '=', 'files.id_album')
						->where('files.name_table', '=', 'menualbum')
						->where('files.main', '=', 1);
				}
			)

			->select('menu.*', 'files.file', 'files.crop')
			->first();

		$data['locations'] = $this->dynamic->t('locations')->where('locations.active', 1)->get()->toArray();

		return $this->base->view_s("site.main.favorite", $data);
	}

	/**
	 * Villas.
	 *
	 * @param null $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function villas($id = null)
	{
		$data      = [];
		$cart      = array_values($this->requests->session()->get('cart') ?? []);
		$where[]   = ['villas.active', 1];
		$count_box = 4;
		$group     = 'id';
		$session   = $this->request['session'] ?? true;

		if(!isset($params['id']) && $session) {
			for($i = 0; count($cart ?? []) > $i; $i++)
				$data['favorites_id'][] = $cart[$i]['id'] ?? 0;
		}

		if($id) {
			$data['villa'] = $this->dynamic->t('villas')
				->where(array_merge($where, [['villas.id', $id]]))
				->join(
					'files', function($join) {
					$join->type = 'LEFT OUTER';
					$join->on('villas.id', '=', 'files.id_album')
						->where('files.name_table', '=', 'villasalbum')
						->where('files.main', '=', 1);
				}
				)
				->join(
					'menu', function($join) {
					$join->type = 'LEFT OUTER';
					$join->on('villas.cat_location', '=', 'menu.id');
				}
				)
				->select('villas.*', 'files.file', 'files.crop', 'menu.name AS place')
				->groupBy('villas.id')
				->orderBy('villas.' . $group, 'DESC')
				->first();

			if($data['villa']['specialist'])
				$data['villa']['specialist'] = $this->dynamic->t('users')

					->join(
						'files',

						function($join) {
							$join->type = 'LEFT OUTER';

							$join->on('users.id', '=', 'files.id_album')
								->where('files.name_table', '=', 'usersalbum')
								->where('files.main', '=', 1);
						}
					)

					->where('users.id', '=', (int) $data['villa']['specialist'])
					->select('users.*', 'files.file', 'files.crop')
					->first();

			$data['villa']['document'] = $this->dynamic->t('files')
				->where('files.name_table', '=', 'villasfiles')
				->where('files.id_album', '=', $id)
				->first();

			$data['recommended_villas'] = $this->dynamic->t('villas')
				->where(array_merge(
									$where,

									[
										'bedroom' => $data['villa']['bedroom'],
										'bathroom' => $data['villa']['bathroom'],
									]
								))
				//				->whereIn('villas.id', json_decode($data['villa']['recommendedVillas'], true) ?? [])
								->whereNotIn('villas.id', [$data['villa']['id']])
				->join(
					'files',

					function($join) use ($data) {
						$join->type = 'LEFT OUTER';
						$join->on('villas.id', '=', 'files.id_album')
							->where('files.name_table', '=', 'villasalbum')
							->where('files.main', '=', 1);
					}
				)

				->join(
					'menu',

					function($join) {
						$join->type = 'LEFT OUTER';
						$join->on('villas.cat_location', '=', 'menu.id');
					}
				)

				->select('villas.*', 'files.file', 'files.crop', 'menu.name AS place')
				->groupBy('villas.id')
				->orderBy('villas.' . $group, 'DESC')
				->limit(6)
				->get()
				->toArray();

			$data['album'] = $this->dynamic->t('files')
				->where('files.name_table', '=', 'villasalbum')
				->where('files.main', '=', 0)
				->where('files.active', '=', 1)
				->where('files.id_album', '=', $id)
				->get()
				->toArray();

			$data['album_what_is_next'] = $this->dynamic->t('files')
				->where('files.name_table', '=', 'villaswhat_is_next')
				->where('files.active', '=', 1)
				->where('files.id_album', '=', $id)
				->get()
				->toArray();


			$dates = $this->base->getDatesFromRange(
				Carbon::yesterday(),
				Carbon::yesterday()->month(Carbon::yesterday()->month + 6)
			);

			$order_days = $this
				->dynamic
				->t('booking_calendar')
				->whereIn('start', $dates)
				->orWhereIn('end', $dates)
				->get()
				->toArray();

			$data['order_days'] = [];

			foreach($order_days as $val)
				$data['order_days'] = array_merge(
					$data['order_days'],

					$this->base->getDatesFromRange(
						$val['start'],
						$val['end']
					)
				);

			$data['meta_c']   = $this->base->getMeta($data, 'villa');
			$data['full_url'] = $this->getUrlVilla();

			$data['meta_c']['og_image'] = $data['villa']['file']
				? $data['villa']['crop']
					? "http://{$_SERVER['SERVER_NAME']}/images/files/small/{$data['villa']['crop']}"
					: "http://{$_SERVER['SERVER_NAME']}/images/files/small/{$data['villa']['file']}"
				: '';

			return $this->base->view_s("site.main.villas_id", $data);
		} else {
			$data['villas'] = $this->dynamic->t('villas')
				->where($where)
				->join(
					'files', function($join) {
					$join->type = 'LEFT OUTER';
					$join->on('villas.id', '=', 'files.id_album')
						->where('files.name_table', '=', 'villasalbum')
						->where('files.main', '=', 1);
				}
				)
				->join(
					'menu', function($join) {
					$join->type = 'LEFT OUTER';
					$join->on('villas.cat_location', '=', 'menu.id');
				}
				)
				->select('villas.*', 'files.file', 'files.crop', 'menu.name AS place')
				->groupBy('villas.id')
				->orderBy('villas.' . $group, 'DESC')
				->paginate($count_box);

			$data['locations'] = $this
				->dynamic
				->t('locations')
				->where('locations.active', 1)

				->join(
					'villas',

					function($join) {
						$join->type = 'LEFT';
						$join->on('villas.cat_location', '=', 'locations.cat');
					}
				)

				->select('locations.*')
				->groupBy('villas.cat_location')
				->get()
				->toArray();

			$villas_by_the_sea           = (int) ($this->request['villas_by_the_sea'] ?? false);
			$villas_with_private_service = (int) ($this->request['villas_with_private_service'] ?? false);
			$vacation_together           = (int) ($this->request['vacation_together'] ?? false);

			if($villas_by_the_sea)
				$data['meta_d']['title'] = ' :: ' . __('main.villas_by_the_sea');

			if($villas_with_private_service)
				$data['meta_d']['title'] = ' :: ' . __('main.villas_with_private_service');

			if($vacation_together)
				$data['meta_d']['title'] = ' :: ' . __('main.vacation_together');

			$data['title'] = $data['meta_d']['title'] ?? '';

			return $this->base->view_s("site.main.villas", $data);
		}
	}

	/**
	 * Blog.
	 *
	 * @param null $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function blog($id = null)
	{
		$blog    = $this->dynamic->t('blog')->select('tags')->get()->toArray();
		$tags_id = [];

		foreach($blog as $v)
			$tags_id = array_merge($tags_id, json_decode($v['tags'], true));

		$data['tags'] = $this->dynamic->t('tags')->whereIn('id', $tags_id)->limit(100)->get()->toArray();
		$where[]      = ['blog.active', 1];
		$count_box    = 4;
		$group        = 'id';

		if($id) {
			if(!is_numeric($id))
				$where_id = ['blog.translation' => $id];
			else
				$where_id = ['blog.id' => $id];

			$data['blog'] = $this->dynamic->t('blog')
				->where(array_merge($where, $where_id))

				->join(
					'files',

					function($join) {
						$join->type = 'LEFT OUTER';
						$join->on('blog.id', '=', 'files.id_album')
							->where('files.name_table', '=', 'blogalbum')
							->where('files.main', '=', 1);
					}
				)

				->select('blog.*', 'files.file', 'files.crop')
				->first();

			if(empty($data['blog']))
				return $this->errors_404();

			$views_ip = $this
				->dynamic
				->t('views_ip')
				->where(
					[
						['ip', $this->requests->ip()], ['parent_id', $data['blog']['id']],
					]
				)
				->count();

			if(!$views_ip) {
				$this
					->dynamic
					->t('views_ip')

					->insert(
						[
							'ip'         => $this->requests->ip(),
							'parent_id'  => $data['blog']['id'],
							'created_at' => Carbon::now(),
						]
					);

				$blog        = $this->dynamic->t('blog')->where(array_merge($where, $where_id))->first();
				$blog->views = $blog['views'] + 1;
				$blog->save();
			}

			$data['meta_c'] = $this->base->getMeta($data, 'blog');

			$data['blogs'] = $this->dynamic->t('blog')
				->whereNotIn('blog.id', [$data['blog']['id']])

				// TODO скорее отвалится когда теги будут с id больше 10
				->where(
					function($query) use ($data) {
						$tags = explode(',', $data['blog']['tags']);

						for($i = 0; $i < count($tags); $i++) {
							$query->orwhere('blog.tags', 'like', '%' . $tags[$i] . '%');
						}
					}
				)

				->join(
					'files',

					function($join) {
						$join->type = 'LEFT OUTER';
						$join->on('blog.id', '=', 'files.id_album')
							->where('files.name_table', '=', 'blogalbum')
							->where('files.main', '=', 1);
					}
				)

				->select('blog.*', 'files.file', 'files.crop')
				->orderBy('blog.' . $group, 'DESC')
				->limit(20)
				->get()
				->toArray();

			return $this->base->view_s("site.main.blog_id", $data);
		} else {
			$tags                 = explode(',', str_replace(']', '', str_replace('[', '', $this->request['tag'] ?? '')));
			$data['current_tags'] = $tags;
			$where[]              = ['blog.tags', '!=', '\'\''];

			$data['blog'] = $this->dynamic->t('blog')
				->where($where)

				// TODO скорее отвалится когда теги будут с id больше 10
				->where(
					function($query) use ($tags) {
						for($i = 0; $i < count($tags); $i++) {
							$query->orwhere('blog.tags', 'like', '%' . $tags[$i] . '%');
						}
					}
				)

				->join(
					'files',

					function($join) {
						$join->type = 'LEFT OUTER';
						$join->on('blog.id', '=', 'files.id_album')
							->where('files.name_table', '=', 'blogalbum')
							->where('files.main', '=', 1);
					}
				)

				->select('blog.*', 'files.file', 'files.crop')
				->groupBy('blog.id')
				->orderBy('blog.' . $group, 'DESC')
				->paginate($count_box);

			return $this->base->view_s("site.main.blog", $data);
		}
	}

	/**
	 * About Us.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function about_us()
	{
		$id_segment = $this->requests->segment(1);

		if(!is_numeric($id_segment))
			$where_id = ['menu.translation' => $id_segment];
		else
			$where_id = ['menu.id' => $id_segment];

		$data['menu_segment'] = $this->dynamic->t('menu')
			->where($where_id)

			->join(
				'files',

				function($join) {
					$join->type = 'LEFT OUTER';
					$join->on('menu.id', '=', 'files.id_album')
						->where('files.name_table', '=', 'menualbum')
						->where('files.main', '=', 1);
				}
			)

			->select('menu.*', 'files.file', 'files.crop')
			->first();

		$where[] = ['str.active', 1];

		if((int) $id_segment == 0 || strlen($id_segment) > 5) {
			$data['field'] = 'translation';
			$where[]       = ['str.translation', $id_segment];
		} else {
			$where['str.id'] = $id_segment;
		}

		$data['page'] = $this->dynamic->t('str')
			->where($where)

			->join(
				'files',

				function($join) {
					$join->type = 'LEFT OUTER';
					$join->on('str.id', '=', 'files.id_album')
						->where('files.name_table', '=', 'stralbum');
				}
			)

			->select('str.*', 'files.file', 'files.crop')
			->first();

		if(empty($data['page'])) {
			return $this->errors_404();
		}

		$data['meta_c'] = $this->base->getMeta($data, 'page');

		$data['users'] = $this->dynamic->t('users')
			->where([['users.is_about_us', 1]])

			->join(
				'files',

				function($join) {
					$join->type = 'LEFT OUTER';
					$join->on('users.id', '=', 'files.id_album')
						->where('files.name_table', '=', 'usersalbum');
				}
			)

			->select('users.*', 'files.file', 'files.crop')
			->get()
			->toArray();

		return $this->base->view_s("site.main.about_us", $data);
	}

	/**
	 * Contact Us.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function contact_us()
	{
		$data = [];

		return $this->base->view_s("site.main.contact_us", $data);
	}

	/**
	 * Vacancies.
	 *
	 * @param null $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function vacancies($id = null)
	{
		$data = [];

		if($id) {
			$data['vacancy'] = $this
				->dynamic
				->t('vacancies')

				->join(
					'files',

					function($join) {
						$join->type = 'LEFT OUTER';
						$join->on('vacancies.id', '=', 'files.id_album')
							->where('files.name_table', '=', 'vacanciesalbum')
							->where('files.main', '=', 1);
					}
				)

				->select('vacancies.*', 'files.file', 'files.crop')
				->where([['vacancies.active', 1], ['vacancies.id', $id]])
				->first();

			$data['vacancies'] = $this->dynamic->t('vacancies')
				->where('vacancies.active', 1)
				->whereNotIn('vacancies.id', [$id])
				->select('vacancies.*')
				->groupBy('vacancies.id')
				->orderBy('vacancies.id', 'DESC')
				->get()
				->toArray();

			$data['meta_c'] = $this->base->getMeta($data, 'vacancy');

			return $this->base->view_s("site.main.vacancies_id", $data);
		} else {
			$data['vacancies'] = $this->dynamic->t('vacancies')
				->where('vacancies.active', 1)
				->select('vacancies.*')
				->groupBy('vacancies.id')
				->orderBy('vacancies.id', 'DESC')
				->get()
				->toArray();

			$data['main_page'] = $this->dynamic->t('main_page')->where('table', 'vacancies')->first()->toArray();
			$data['meta_c']    = $this->base->getMeta($data['main_page']);

			$data['working_conditions'] = $this->dynamic->t('files')
				->where('files.name_table', '=', 'vacanciesworking_conditions')
				->select('files.*', 'files.file', 'files.crop')
				->get()
				->toArray();

			$data['benefits'] = $this->dynamic->t('files')
				->where('files.name_table', '=', 'vacanciesbenefits')
				->select('files.*', 'files.file', 'files.crop')
				->get()
				->toArray();

			return $this->base->view_s("site.main.vacancies", $data);
		}
	}

	/**
	 * Location.
	 *
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function location($id)
	{
		$whereVillas[] = ['villas.active', 1];

		$data['location'] = $this
			->dynamic
			->t('locations')

			->join(
				'menu',
				function($join) use ($id) {
					$join->type = 'RIGHT OUTER';
					$join->on('menu.id', '=', 'locations.cat');
				}
			)

			->join(
				'files',

				function($join) {
					$join->type = 'LEFT OUTER';
					$join->on('locations.id', '=', 'files.id_album')
						->where('files.name_table', '=', 'locationsalbum')
						->where('files.main', '=', 1);
				}
			)

			->select('locations.*', 'files.file', 'files.crop')
			->where('locations.active', 1)
			->where('menu.translation', '=', $id)
			->orWhere('menu.id', '=', $id)
			->first();


		$data['locations'] = $this->dynamic
			->t('locations')
			->where([['locations.active','=', 1]])

			->join(
				'files',

				function($join) {
					$join->type = 'LEFT OUTER';
					$join->on('locations.id', '=', 'files.id_album')
						->where('files.name_table', '=', 'locationsalbum')
						->where('files.main', '=', 1);
				}
			)

			->select('locations.*', 'files.file', 'files.crop')
			->get()
			->toArray();

		$whereVillas['villas.cat_location'] = $data['location']['cat'];

		if(empty($data['location']))
			return $this->errors_404();

		$data['villas'] = $this->dynamic->t('villas')
			->where($whereVillas)

			->join(
				'files',

				function($join) {
					$join->type = 'LEFT OUTER';
					$join->on('villas.id', '=', 'files.id_album')
						->where('files.name_table', '=', 'villasalbum')
						->where('files.main', '=', 1);
				}
			)

			->select('villas.*', 'files.file', 'files.crop')
			->groupBy('villas.id')
			->orderBy('villas.id', 'DESC')
			->orderBy('villas.is_best', 'ASC')
			->paginate(4);

		$data['meta_c'] = $this->base->getMeta($data, 'location');

		return $this->base->view_s("site.main.location_id", $data);
	}

	/**
	 * Search.
	 *
	 * @param $page
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function search($page = 0)
	{
		$limit = 4;
		$page  = $page * $limit;
		$q     = $this->request['q'];
		$count = 0;

		$query = function($count) use ($q) {
			return '
			(SELECT
			 ' . ($count ? 'COUNT(villas.id) AS count' : ('villas.id COLLATE utf8_general_ci as id,
			 villas.name COLLATE utf8_general_ci as name,
			 villas.name_table COLLATE utf8_general_ci as name_table,
			 villas.text COLLATE utf8_general_ci as text')) . '
			FROM villas
			WHERE `text` LIKE \'%' . trim($q) . '%\' OR `name` LIKE \'%' . trim($q) . '%\')
			
			UNION ALL
			
			(SELECT
		 ' . ($count ? 'COUNT(blog.id) AS count' : ('blog.id COLLATE utf8_general_ci as id,
			 blog.name COLLATE utf8_general_ci as name,
			 blog.name_table COLLATE utf8_general_ci as name_table,
			 blog.text COLLATE utf8_general_ci as text')) . '
			FROM blog
			WHERE `text` LIKE \'%' . trim($q) . '%\' OR `name` LIKE \'%' . trim($q) . '%\')';
		};

		$data['search'] = \DB::select($query(false) . ' ORDER BY `id` DESC LIMIT ' . ($page) . ', ' . ($limit) . ';');
		$data['count']  = \DB::select($query(true));

		foreach($data['count'] as $v)
			$count = $count + $v->count;

		$data['count'] = $count;
		$data['page']  = $page ? $page / $limit : 1;
		$data['limit'] = $limit;
		$data['q']     = $q;

		return $this->base->view_s("site.main.search", $data);
	}

	/**
	 * добавление/удаление в избранное
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function add_favorite()
	{
		$idd      = false;
		$id       = $this->request['id'];
		$get_data = $this->request['get_data'];
		$type     = $this->request['type'];
		$cart     = array_values($this->requests->session()->get('cart') ?? []);

		if($type === 'add') {
			for($i = 0; count($cart) > $i; $i++)
				if($cart[$i]['id'] == $id) {
					$idd = true;
					break;
				}

			if(!$idd)
				$this->requests->session()->put(
					'cart',
					array_merge($cart, [$id => ['id' => $id]])
				);
		}

		if($type === 'remove') {
			for($i = 0; count($cart) > $i; $i++)
				if($cart[$i]['id'] == $id) {
					unset($cart[$i]);
					break;
				}

			$this->requests->session()->flush('cart');
			$this->requests->session()->put('cart', $cart);
		}

		if($get_data) {
			$where[]   = ['villas.active', 1];
			$group     = 'id';
			$count_box = 24;
			$cart_0    = array_values($this->requests->session()->get('cart') ?? []);

			for($i = 0; count($cart_0 ?? []) > $i; $i++)
				$cart_id[] = $cart_0[$i]['id'] ?? 0;

			$data['villas'] = $this->dynamic->t('villas')
				->where($where)
				->whereIn('villas.id', $cart_id ?? [])
				->where('villas.text', 'like', '%' . trim($this->requests['input_search'] ?? '') . '%')
				->join(
					'files', function($join) {
					$join->type = 'LEFT OUTER';
					$join->on('villas.id', '=', 'files.id_album')
						->where('files.name_table', '=', 'villas')
						->where('files.main', '=', 1);
				}
				)
				->join(
					'menu', function($join) {
					$join->type = 'LEFT OUTER';
					$join->on('villas.cat_location', '=', 'menu.id');
				}
				)
				->select('villas.*', 'files.file', 'files.crop', 'menu.name as cat_parent')
				->groupBy('villas.id')
				->orderBy('villas.' . $group, 'DESC')
				->paginate($count_box);
		}

		foreach($this->requests->session()->get('cart') ?? [] as $v)
			$data['cart'][$v['id']] = $v;

		$data['result'] = 'ok';
		$data['count']  = count(array_values($this->requests->session()->get('cart') ?? []));

		return json_encode($data);
	}

	public function search_render_villas($params = [])
	{
		$data      = [];
		$where[]   = ['villas.active', 1];
		$count_box = 10;
		$group     = 'id';
		$cart      = array_values($this->requests->session()->get('cart') ?? []);
		$cart_id   = [];
		$session   = $this->request['session'] ?? true;

		if(!isset($params['id']) && $session) {
			for($i = 0; count($cart ?? []) > $i; $i++)
				$cart_id[] = $cart[$i]['id'] ?? 0;

			$params['id'] = $cart_id;
		}

		$way                         = (int) ($this->request['way'] ?? -1);
		$date_to                     = $this->request['date_to'] ?? -1;
		$date_from                   = $this->request['date_from'] ?? -1;
		$guests_person               = (int) ($this->request['guests_person'] ?? -1);
		$hot                         = (int) ($this->request['hot'] ?? -1);
		$villas_by_the_sea           = (int) ($this->request['villas_by_the_sea'] ?? -1);
		$villas_with_private_service = (int) ($this->request['villas_with_private_service'] ?? -1);
		$vacation_together           = (int) ($this->request['vacation_together'] ?? -1);
		$dates                       = '';

		if($way !== -1 && !empty($way))
			$where[] = ['villas.cat_location', $way];

		if($guests_person !== -1)
			if($guests_person === 7)
				$where[] = ['villas.guests_person', '>=', $guests_person];
			else
				$where[] = ['villas.guests_person', $guests_person];

		if($hot !== -1)
			$where[] = ['villas.is_hot', 1];

		if($villas_by_the_sea !== -1)
			$where[] = ['villas.villas_by_the_sea', 1];

		if($villas_with_private_service !== -1)
			$where[] = ['villas.villas_with_private_service', 1];

		if($vacation_together !== -1)
			$where[] = ['villas.vacation_together', 1];

		if((int) $date_to !== -1) {
			$tomorrow    = Carbon::createFromFormat('Y-m-d', substr($date_from, 0, 10))->addDay(1)->toDateString();
			$dates       = $this->base->getDatesFromRange($tomorrow, $date_to);
		}

		if($dates)
			$order_villas = $this
				->dynamic
				->t('booking_calendar')
				->whereIn('start', $dates)
				->orWhereIn('end', $dates)
				->select('villas_id')
				->groupBy('villas_id')
				->get()
				->toArray();
		else
			$order_villas = $this
				->dynamic
				->t('booking_calendar')
				->select('villas_id')
				->groupBy('villas_id')
				->get()
				->toArray();

		// clear where params for Favorite query
		if(!$dates && !$this->requests['return'])
			$where = [['villas.active', 1]];

		$villas_query = $this->dynamic->t('villas')
			->where($where)
			->join(
				'files',
				function($join) {
					$join->type = 'LEFT OUTER';
					$join->on('villas.id', '=', 'files.id_album')
						->where('files.name_table', '=', 'villasalbum')
						->where('files.main', '=', 1);
				}
			)
			->join(
				'menu',

				function($join) {
					$join->type = 'LEFT OUTER';
					$join->on('villas.cat_location', '=', 'menu.id');
				}
			);

		if(isset($params['id']))
			$villas_query = $villas_query->whereIn('villas.id', $params['id']);

		$villas_query = $villas_query
//			->whereNotIn('villas.id', $id_ignoring)
			->select('villas.*', 'files.file', 'files.crop', 'menu.name AS place')
			->groupBy('villas.id')
			->orderBy('villas.order', 'DESC')
			->orderBy('villas.' . $group, 'DESC')
			->paginate($count_box);

		$cart         = array_values($this->requests->session()->get('cart') ?? []);
		$favorites_id = [];

		for($i = 0; count($cart ?? []) > $i; $i++)
			$favorites_id[] = $cart[$i]['id'] ?? 0;

		$data['full_url']     = $this->getUrlVilla();
		$data['villas']       = $villas_query;
		$data['favorites_id'] = $favorites_id;
		$data['paginate']     = true;

		return $this->base->view_s("site.block.villas_main_list", $data);
	}

	/**
	 * getUrlVilla.
	 *
	 * @return string
	 */
	function getUrlVilla()
	{
		$url = '?';

		if(($this->request['way'] ?? -1) !== -1)
			$url .= '&way=' . $this->request['way'];

		if(($this->request['date_to'] ?? -1) !== -1)
			$url .= '&date_to=' . $this->request['date_to'];

		if(($this->request['date_from'] ?? -1) !== -1)
			$url .= '&date_from=' . $this->request['date_from'];

		if(($this->request['rooms'] ?? -1) !== -1)
			$url .= '&rooms=' . $this->request['rooms'];

		if(($this->request['hot'] ?? -1) !== -1)
			$url .= '&hot=1';

		if(($this->request['villas_by_the_sea'] ?? -1) !== -1)
			$url .= '&villas_by_the_sea=' . $this->request['villas_by_the_sea'];

		if(($this->request['villas_with_private_service'] ?? -1) !== -1)
			$url .= '&villas_with_private_service=1';

		if(($this->request['vacation_together'] ?? -1) !== -1)
			$url .= '&vacation_together=1';

		if(($this->request['return'] ?? -1) !== -1)
			$url .= '&return=1';

		return str_replace('?&', '?', $url);
	}

	/**
	 * Страницы.
	 *
	 * @param null $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function page($id = null)
	{
		if(!$id)
			return $this->errors_404();

		$Mod     = $this->dynamic;
		$data    = [];
		$where[] = ['str.active', 1];

		if((int) $id == 0 || strlen($id) > 5) {
			$data['field'] = 'translation';
			$where[]       = ['str.translation', $id];
		} else {
			$where['str.id'] = $id;
		}

		$data['page'] = $Mod->t('str')
			->where($where)

			->join(
				'files',

				function($join) {
					$join->type = 'LEFT OUTER';
					$join->on('str.id', '=', 'files.id_album')
						->where('files.name_table', '=', 'stralbum');
				}
			)

			->select('str.*', 'files.file', 'files.crop')
			->first();

		if(empty($data['page'])) {
			return $this->errors_404();
		}

		$data['meta_c'] = $this->base->getMeta($data, 'page');

		if(!empty($data['page'][0])) {
			$data['files'] = $Mod->t('files')
				->where(['files.active' => 1])
				->where(['id_album' => $data['page'][0]['id'], 'name_table' => 'str'])->get();
		} else {
			$data['files'] = [];
		}

		return $this->base->view_s("site.main.page_id", $data);
	}

	/**
	 * Tools Send mail.
	 */
	public function submit_required()
	{
		$param  = $this->dynamic->t('params')->select('params.*', 'little_description as key')->get();
		$params = [];
		$params['params'] = [];

		$params['langSt'] = function($t, $l = '') {
			return $this->base->lang($t, $l);
		};

		foreach($param as $key => $p)
			$params['params'][$p->name] = $p->toArray();

		if(isset($this->request['data2']))
			$form = $this->base->decode_serialize($this->request['data2']);
		else
			$form = $this->base->decode_serialize($this->request['data']);

		$form_data = [];
		$type      = $this->request['type'];
		$title     = '';
		$from      = 'no-realy@greecobooking.niws.ru';

		$param = $this
			->dynamic
			->t('params')
			->select('params.*', 'little_description as key')
			->where('name', 'email_alerts')
			->first();

		foreach($form as $k => $v)
			$form_data[$k] = (int) $v == -1 ? '' : $v;

		if($type === 'selection_request') {
			if($form['way'] != -1) {
				$way         = $this->dynamic->t('menu')->select('menu.name')->where('id', $form['way'])->first();
				$form['way'] = $this->base->lang($way['name']);
			} else
				$form['way'] = __('main.all_destinations');

			Mail::send(
				'emails.' . $type,
				array_merge($form_data, $params),

				function($m) use ($param, $title, $from, $form_data) {
				$m->from($from, __('main.selection_request_mess_user'));
				$m->to($form_data['mail'], 'no-realy')->subject(__('main.selection_request_mess_user'));
			}
			);

			$title = __('main.selection_request_mess_admin');

//			/* subscription */
//			if($form_data['subscription'] === 'on') {
//				// Insert Subscribe email
//				$subscribe_mail = $this->dynamic->t('params_subscribe')
//					->where('subscribe_mail', '=', trim($form_data['mail']))
//					->first();
//
//				if(!$subscribe_mail)
//					$this->dynamic->t('params_subscribe')->insertGetId(
//						[
//							'created_at'     => Carbon::now(),
//							'subscribe_mail' => $form_data['mail'],
//						]
//					);
//			}
//			/* subscription */
		}

		if($type == 'request_for_accommodation') {
			Mail::send(
				'emails.' . $type,
				array_merge($form_data, $params),

				function($m) use ($param, $title, $from, $form_data) {
					$m->from($from, __('main.request_for_accommodation_user'));
					$m->to($form_data['mail'], 'no-realy')->subject(__('main.request_for_accommodation_user'));
				}
			);

			$title = __('main.request_for_accommodation_admin');
		}

		if($type == 'contact_us')
			$title = __('main.contact_us_admin');

		if($type == 'subscription') {
			$title = __('main.subscription_admin');

			// Insert Subscribe email
			$subscribe_mail = $this->dynamic->t('params_subscribe')
				->where('subscribe_mail', '=', trim($form_data['subscribe_mail']))
				->first();

			if(!$subscribe_mail)
				$this->dynamic->t('params_subscribe')->insertGetId(
					[
						'created_at'     => Carbon::now(),
						'subscribe_mail' => $form_data['subscribe_mail'],
					]
				);
		}

		if($type == 'friend_form') {
			$cart                   = array_values($this->requests->session()->get('cart') ?? []);
			$title                  = __('main.send_compilation_friend_user');
			$form_data['message_s'] = $form_data['message'];

			for($i = 0; count($cart ?? []) > $i; $i++)
				$form_data['selected_villas'][] = $cart[$i]['id'] ?? 0;

			$form_data['selected_villas'] = $this->dynamic->t('villas')
				->join(
					'files', function($join) {
					$join->type = 'LEFT OUTER';
					$join->on('villas.id', '=', 'files.id_album')
						->where('files.name_table', '=', 'villasalbum')
						->where('files.main', '=', 1);
				}
				)
				->join(
					'menu', function($join) {
					$join->type = 'LEFT OUTER';
					$join->on('villas.cat_location', '=', 'menu.id');
				}
				)
				->whereIn('villas.id', $form_data['selected_villas'])
				->select('villas.*', 'files.file', 'files.crop', 'menu.name AS place')
				->groupBy('villas.id')
				->orderBy('villas.id', 'DESC')
				->get()
				->toArray();

			$form_data['langSt'] = function($t, $l = '') {
				return Base::langSt($t, $l);
			};

			if(isset($form['send-me']))
				Mail::send(
					'emails.' . $type,
					array_merge($form_data, $params),

					function($m) use ($param, $title, $from, $form_data) {
					$m->from($from, __('main.send_compilation_friend_user'));
					$m->to($form_data['yourEmail'], 'no-realy')->subject(__('main.send_compilation_friend_user'));
				}
				);

			foreach($form_data['friendMail'] ?? [] as $mail) {
				Mail::send(
					'emails.' . $type . '_friend',
					array_merge($form_data, $params),

					function($m) use ($param, $title, $from, $form_data, $mail) {
						$m->from($from, $form_data['yourName'] ?? __('main.send_compilation_friend_user'));
						$m->to($mail, 'no-realy')->subject(__('main.send_compilation_friend_user'));
					}
				);
			}

			$title = __('main.send_compilation_friend_admin');
		}

		if($type == 'resume_form') {
			$form_data              = $this->request['data'];
			$title                  = __('main.job_request_from_admin');
			$form_data['file']      = '';
			$form_data['message_s'] = $form_data['message'];

			if(!empty($this->request['file_cv'])) {
				$form_data['file'] = (new FilesController($this->requests))->upload_files(
					[
						'file'       => [$this->request['file_cv']],
						'name_table' => 'resume_form',
						'id_album'   => 0,
						'limit'      => 0,
						'path'       => '/images/resume_form/',
					]
				);

				$form_data['file'] = "http://greecobooking.niws.ru/images/resume_form/{$form_data['file']['name']}";
			}
		}

		if($type == 'villa_request') {
			$title                  = __('main.villa_request_user');
			$form_data['message_s'] = $form_data['message'];

			$form_data['selected_villa'] = $this->dynamic->t('villas')
				->join(
					'files',

					function($join) {
						$join->type = 'LEFT OUTER';
						$join->on('villas.id', '=', 'files.id_album')
							->where('files.name_table', '=', 'villasalbum')
							->where('files.main', '=', 1);
					}
				)
				->join(
					'menu',

					function($join) {
						$join->type = 'LEFT OUTER';
						$join->on('villas.cat_location', '=', 'menu.id');
					}
				)
				->where('villas.id', $this->request['id'])
				->select('villas.*', 'files.file', 'files.crop', 'menu.name AS place')
				->groupBy('villas.id')
				->orderBy('villas.id', 'DESC')
				->first();

			$form_data['langSt'] = function($t, $l = '') {
				return Base::langSt($t, $l);
			};

			Mail::send(
				'emails.' . $type,
				array_merge($form_data, $params),

				function($m) use ($param, $title, $from, $form_data) {
					$m->from($from, $title);
					$m->to($form_data['mail'], 'no-realy')->subject($title);
				}
			);

			$title = __('main.villa_request_admin');
		}

		//		print_r($form);
		//		print_r($type);
		//		print_r($this->request);
		//		exit;

		foreach(explode(',', $this->base->lang($param->key)) as $mail)
			Mail::send(
				'emails.' . $type,
				array_merge($form_data, $params),

				function($m) use ($param, $title, $from, $mail) {
					$m->from($from, $title);
					$m->to(trim($mail), 'no-realy')->subject($title);
				}
			);

		$ret['result'] = 'ok';
		echo json_encode($ret);

		exit;
	}
}
