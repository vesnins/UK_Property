<?php

namespace App\Http\Controllers;

use App\Classes\DynamicModel;
use App\Modules\Admin\Classes\Base;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
   * @var HelperController
   */
  private $helper;

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
    $this->helper   = new HelperController($request);
  }

  /**
   * Main page.
   *
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function main()
  {
    $whereBlog[]      = ['blog.active', 1];
    $whereBlog[]      = ['blog.tags', '!=', '\'\''];
    $data             = $this->helper->duplicate_data();
    $data['services'] = [];
    $data['cart']     = array_values($this->requests->session()->get('cart') ?? []);
    $data['blog']     = $this->helper->_blog(
      null,
      [
        'count_box' => 3,
        'order_by'  => [['blog.useful', 'DESC'], ['blog.id', 'DESC']],
      ],

      [['blog.active', 1], ['blog.to_main', 1]]
    );

    foreach($this->helper->_services() as $k => $serv)
      $data['services'][$serv['translation'] ?? $k] = $serv;

    $services_key = array_keys($data['services']);

    for($i = 0; 3 > $i; $i++) {
      $filters = $this->_catalog_array($services_key[$i]);

      if($filters) {
        $query = $this->dynamic->t($filters['table']);

        $data['services'][$services_key[$i]]['data'] = $query
          ->where(
            [
              ["{$filters['table']}.to_main", '=', 1],
              ["{$filters['table']}.in_portfolio", '=', 0],
            ]
          )
          ->join(
            'files',

            function($join) use ($filters) {
              $join->type = 'LEFT OUTER';
              $join->on("{$filters['table']}.id", '=', 'files.id_album')
                ->where('files.name_table', '=', "{$filters['table']}album")
                ->where('files.main', '=', 1);
            }
          )
          ->select("{$filters['table']}.*", 'files.file', 'files.crop')
          ->get(4)
          ->toArray();
      }
    }

    $data['preview'] = $this
      ->dynamic
      ->t('files')
      ->where('name_table', 'mainalbum')
      ->orderBy('sort', 'ASC')
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

    $data['img_to_main'] = $this
      ->dynamic
      ->t('about_company')
      ->where('about_company.active', 1)
      ->join(
        'files',

        function($join) {
          $join->type = 'LEFT OUTER';
          $join->on('about_company.id', '=', 'files.id_album')
            ->where('files.name_table', '=', 'about_companyimg_to_main')
            ->where('files.main', '=', 1);
        }
      )
      ->select('files.file', 'files.crop')
      ->first();

    $data['photo_to_main'] = $this
      ->dynamic
      ->t('about_company')
      ->where('about_company.active', 1)
      ->join(
        'files',

        function($join) {
          $join->type = 'LEFT OUTER';
          $join->on('about_company.id', '=', 'files.id_album')
            ->where('files.name_table', '=', 'about_companyphoto_to_main')
            ->where('files.main', '=', 1);
        }
      )
      ->select('files.file', 'files.crop')
      ->first();

    $data['main_page_video'] = $this
      ->dynamic
      ->t('files')
      ->where('files.name_table', '=', 'mainfiles')
      ->orderBy('files.sort', 'ASC')
      ->get()
      ->toArray();

    $data['about'] = $this
      ->dynamic
      ->t('about_company')
      ->where('about_company.active', '=', 1)
      ->first()
      ->toArray();

    $data['meta_c'] = $this->base->getMeta($data['main_page']);

    return $this->base->view_s("site.main.index", $data);
  }

  /**
   * Array Catalog filters.
   *
   * @param $name
   * @return array|mixed
   */
  private function _catalog_array($name)
  {
    $filters = [
      'invest-in-a-new-building' => [
        'name'       => 'invest_in_a_new_building',
        'table'      => 'catalog_new_building',
        'top_filter' => [1, 3, 5],

        'group' => [
          'group_1_ASC'  => 'price_money_from',
          'group_1_DESC' => 'price_money_to',

          'group_2_ASC'  => 'popularity',
          'group_2_DESC' => 'popularity',

          'group_3_ASC'  => 'distance_from_the_center',
          'group_3_DESC' => 'distance_from_the_center',

          'group_4_ASC'  => 'area_from',
          'group_4_DESC' => 'area_to',

          'group_5_ASC'  => 'id',
          'group_5_DESC' => 'id',
        ],

        'filters' => [
          // Район(Расположение)
          'cat_location'           => [
            'type'   => 'multi_checkbox',
            'table'  => 'params_cat_location',
            'column' => 'cat_location',

            'fields' => [
              'cat_location' => [
                'name'  => 'cat_location',
                'title' => __('main.cat_location'),
              ],
            ],

            'class' => 'active',
          ],

          // Стоимость
          'price'                  => [
            'type' => 'slider_select',
            'step' => 500,

            'fields' => [
              'price_money_from' => [
                'mode'  => 'min',
                'name'  => 'price_money_from',
                'title' => __('main.cost_$_million'),
              ],

              'price_money_to' => [
                'mode'  => 'max',
                'name'  => 'price_money_to',
                'title' => '',
              ],
            ],

            'class' => 'active',
          ],

          // Площадь
          'area'                   => [
            'type' => 'slider_select_area',
            'step' => 5,

            'fields' => [
              'area_from' => [
                'mode'  => 'min',
                'name'  => 'area_from',
                'title' => __('main.area'),
              ],

              'area_to' => [
                'mode'  => 'max',
                'name'  => 'area_to',
                'title' => '',
              ],
            ],

            'class' => 'active',
          ],

          // Спальни
          'bedrooms'               => [
            'type' => 'slider_select',
            'step' => 1,

            'fields' => [
              'bedrooms_from' => [
                'mode'  => 'min',
                'name'  => 'bedrooms_from',
                'title' => __('main.bedrooms'),
              ],

              'bedrooms_to' => [
                'mode'  => 'max',
                'name'  => 'bedrooms_to',
                'title' => '',
              ],
            ],
          ],

          // Тип объекта
          'type_object'            => [
            'type'   => 'multi_checkbox',
            'table'  => 'params_type_object',
            'column' => 'type_object',

            'fields' => [
              'type_object' => [
                'name'  => 'type_object',
                'title' => __('main.type_object'),
              ],
            ],
          ],

          // Инфраструктура
          'development_facilities' => [
            'type'   => 'multi_checkbox',
            'table'  => 'params_development_facilities',
            'column' => 'development_facilities',

            'fields' => [
              'development_facilities' => [
                'name'  => 'development_facilities',
                'title' => __('main.development_facilities'),
              ],
            ],
          ],

          // Ожидаемый срок
          'estimated_completion'   => [
            'type'   => 'multi_checkbox',
            'table'  => 'params_estimated_completion',
            'column' => 'estimated_completion',

            'fields' => [
              'estimated_completion' => [
                'name'  => 'estimated_completion',
                'title' => __('main.estimated_completion'),
              ],
            ],
          ],
        ],
      ],

      'invest-in-development-projects' => [
        'name'       => 'invest_in_development_projects',
        'table'      => 'catalog_development_projects',
        'top_filter' => [5],

        'group' => [
          'group_1_ASC'  => 'price_money_from',
          'group_1_DESC' => 'price_money_to',

          'group_2_ASC'  => 'popularity',
          'group_2_DESC' => 'popularity',

          'group_3_ASC'  => 'distance_from_the_center',
          'group_3_DESC' => 'distance_from_the_center',

          'group_4_ASC'  => 'area_from',
          'group_4_DESC' => 'area_to',

          'group_5_ASC'  => 'id',
          'group_5_DESC' => 'id',
        ],

        'filters' => [
          // Район(Расположение)
          'cat_location'         => [
            'type'   => 'multi_checkbox',
            'table'  => 'params_cat_location_dp',
            'column' => 'cat_location',

            'fields' => [
              'cat_location' => [
                'name'  => 'cat_location',
                'title' => __('main.cat_location'),
              ],
            ],

            'class' => 'active',
          ],

          // Тип объекта
          'type_object'          => [
            'type'   => 'multi_checkbox',
            'table'  => 'params_type_object_dp',
            'column' => 'type_object',

            'fields' => [
              'type_object' => [
                'name'  => 'type_object',
                'title' => __('main.type_object'),
              ],
            ],

            'class' => 'active',
          ],

          // Ожидаемый срок
          'estimated_completion' => [
            'type'   => 'multi_checkbox',
            'table'  => 'params_estimated_completion',
            'column' => 'estimated_completion',

            'fields' => [
              'estimated_completion' => [
                'name'  => 'estimated_completion',
                'title' => __('main.estimated_completion'),
              ],
            ],

            'class' => 'active',
          ],
        ],
      ],

      'buy' => [
        'name'       => 'buy',
        'table'      => 'catalog_buy',
        'top_filter' => [1, 3, 5],

        'group' => [
          'group_1_ASC'  => 'price_money_from',
          'group_1_DESC' => 'price_money_to',

          'group_2_ASC'  => 'popularity',
          'group_2_DESC' => 'popularity',

          'group_3_ASC'  => 'distance_from_the_center',
          'group_3_DESC' => 'distance_from_the_center',

          'group_4_ASC'  => 'area_from',
          'group_4_DESC' => 'area_to',

          'group_5_ASC'  => 'id',
          'group_5_DESC' => 'id',
        ],

        'filters' => [
          // Район(Расположение)
          'cat_location'           => [
            'type'   => 'multi_checkbox',
            'table'  => 'params_cat_location',
            'column' => 'cat_location',

            'fields' => [
              'cat_location' => [
                'name'  => 'cat_location',
                'title' => __('main.cat_location'),
              ],
            ],

            'class' => 'active',
          ],

          // Стоимость
          'price'                  => [
            'type' => 'slider_select',
            'step' => 500,

            'fields' => [
              'price_money_from' => [
                'mode'      => 'min',
                'real_name' => 'price_money',
                'name'      => 'price_money_from_fixed',
                'title'     => __('main.cost_$_million'),
              ],

              'price_money_to' => [
                'mode'      => 'max',
                'real_name' => 'price_money',
                'name'      => 'price_money_to_fixed',
                'title'     => '',
              ],
            ],

            'class' => 'active',
          ],

          // Площадь
          'area'                   => [
            'type' => 'slider_select_area',
            'step' => 5,

            'fields' => [
              'area_from' => [
                'mode'      => 'min',
                'real_name' => 'area',
                'name'      => 'area_from_fixed',
                'title'     => __('main.area'),
              ],

              'area_to' => [
                'mode'      => 'max',
                'real_name' => 'area',
                'name'      => 'area_to_fixed',
                'title'     => '',
              ],
            ],

            'class' => 'active',
          ],

          // Спальни
          'bedrooms'               => [
            'type' => 'slider_select',
            'step' => 1,

            'fields' => [
              'bedrooms_from' => [
                'mode'      => 'min',
                'real_name' => 'bedrooms',
                'name'      => 'bedrooms_from_fixed',
                'title'     => __('main.bedrooms'),
              ],

              'bedrooms_to' => [
                'mode'      => 'max',
                'real_name' => 'bedrooms',
                'name'      => 'bedrooms_to_fixed',
                'title'     => '',
              ],
            ],
          ],

          // Тип объекта
          'type_object'            => [
            'type'   => 'multi_checkbox',
            'table'  => 'params_type_object',
            'column' => 'type_object',

            'fields' => [
              'type_object' => [
                'name'  => 'type_object',
                'title' => __('main.type_object'),
              ],
            ],
          ],

          // Инфраструктура
          'development_facilities' => [
            'type'   => 'multi_checkbox',
            'table'  => 'params_development_facilities',
            'column' => 'development_facilities',

            'fields' => [
              'development_facilities' => [
                'name'  => 'development_facilities',
                'title' => __('main.development_facilities'),
              ],
            ],
          ],
        ],
      ],

      'rent' => [
        'name'       => 'rent',
        'table'      => 'catalog_rent',
        'top_filter' => [1, 3, 5, 6],

        'group' => [
          'group_1_ASC'  => 'price_money_from',
          'group_1_DESC' => 'price_money_to',

          'group_2_ASC'  => 'popularity',
          'group_2_DESC' => 'popularity',

          'group_3_ASC'  => 'distance_from_the_center',
          'group_3_DESC' => 'distance_from_the_center',

          'group_4_ASC'  => 'area_from',
          'group_4_DESC' => 'area_to',

          'group_5_ASC'  => 'id',
          'group_5_DESC' => 'id',

          'group_6_ASC'  => [
            'name' => 'availability_date',
            'mode' => 'DATE',
          ],
          'group_6_DESC' => [
            'name' => 'availability_date',
            'mode' => 'DATE',
          ],
        ],

        'filters' => [
          // Район(Расположение)
          'cat_location'           => [
            'type'   => 'multi_checkbox',
            'table'  => 'params_cat_location',
            'column' => 'cat_location',

            'fields' => [
              'cat_location' => [
                'name'  => 'cat_location',
                'title' => __('main.cat_location'),
              ],
            ],

            'class' => 'active',
          ],

          // Стоимость
          'price'                  => [
            'type' => 'slider_select',
            'step' => 500,

            'fields' => [
              'price_money_from' => [
                'mode'      => 'min',
                'real_name' => 'price_money',
                'name'      => 'price_money_from_fixed',
                'title'     => __('main.cost_per_month'),
              ],

              'price_money_to' => [
                'mode'      => 'max',
                'real_name' => 'price_money',
                'name'      => 'price_money_to_fixed',
                'title'     => '',
              ],
            ],

            'class' => 'active',
          ],

          // Площадь
          'area'                   => [
            'type' => 'slider_select_area',
            'step' => 5,

            'fields' => [
              'area_from' => [
                'mode'      => 'min',
                'real_name' => 'area',
                'name'      => 'area_from_fixed',
                'title'     => __('main.area'),
              ],

              'area_to' => [
                'mode'      => 'max',
                'real_name' => 'area',
                'name'      => 'area_to_fixed',
                'title'     => '',
              ],
            ],

            'class' => 'active',
          ],

          // Спальни
          'bedrooms'               => [
            'type' => 'slider_select',
            'step' => 1,

            'fields' => [
              'bedrooms_from' => [
                'mode'      => 'min',
                'real_name' => 'bedrooms',
                'name'      => 'bedrooms_from_fixed',
                'title'     => __('main.bedrooms'),
              ],

              'bedrooms_to' => [
                'mode'      => 'max',
                'real_name' => 'bedrooms',
                'name'      => 'bedrooms_to_fixed',
                'title'     => '',
              ],
            ],
          ],

          // Тип объекта
          'type_object'            => [
            'type'   => 'multi_checkbox',
            'table'  => 'params_type_object',
            'column' => 'type_object',

            'fields' => [
              'type_object' => [
                'name'  => 'type_object',
                'title' => __('main.type_object'),
              ],
            ],
          ],

          // Инфраструктура
          'development_facilities' => [
            'type'   => 'multi_checkbox',
            'table'  => 'params_development_facilities',
            'column' => 'development_facilities',

            'fields' => [
              'development_facilities' => [
                'name'  => 'development_facilities',
                'title' => __('main.development_facilities'),
              ],
            ],
          ],
        ],
      ],
    ];

    return $filters[$name] ?? [];
  }

  /**
   * Услуги.
   *
   * @param null $id
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function services($id = null)
  {
    $data = $this->helper->duplicate_data();

    return $this->helper->_page($id, 'site.main.service_id', 'services', $data);
  }

  /**
   * About Company.
   *
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function about_company()
  {
    $data            = $this->helper->duplicate_data();
    $data['reviews'] = $this
      ->dynamic
      ->t('reviews')
      ->where('reviews.active', '=', 1)
      ->get()
      ->toArray();

    $data['about'] = $this
      ->dynamic
      ->t('about_company')
      ->where('about_company.active', '=', 1)
      ->first()
      ->toArray();

    $data['images'] = $this
      ->dynamic
      ->t('files')
      ->where('name_table', 'about_companyalbum')
      ->orderBy('sort', 'ASC')
      ->get()
      ->toArray();

    $data['slider_1'] = $this
      ->dynamic
      ->t('files')
      ->where('name_table', 'about_companyslider_1')
      ->orderBy('sort', 'ASC')
      ->get()
      ->toArray();

    $data['slider_2'] = $this
      ->dynamic
      ->t('files')
      ->where('name_table', 'about_companyslider_2')
      ->orderBy('sort', 'ASC')
      ->get()
      ->toArray();

    $data['meta_c'] = $this->base->getMeta($data, 'about');

    return $this->base->view_s("site.main.about_company", $data);
  }

  /**
   * Selection request.
   *
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function selection_request()
  {
    $data['locations'] = [];

    return $this->base->view_s("site.main.selection_request", $data);
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

    return $this->base->view_s("site.main.favorite", $data);
  }

  /**
   * Blog.
   *
   * @param null $id
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function blog($id = null)
  {
    $data    = $this->helper->duplicate_data();
    $blog    = $this->dynamic->t('blog')->select('tags')->get()->toArray();
    $tags_id = [];

    foreach($blog as $v)
      $tags_id = array_merge($tags_id, json_decode($v['tags'], true));

    $data['tags'] = $this->dynamic->t('tags')->whereIn('id', $tags_id)->limit(100)->get()->toArray();
    $where[]      = ['blog.active', 1];
    $count_box    = 12;
    $group        = 'id';

    if($id) {
      if(!is_numeric($id))
        $where_id = ['blog.translation' => $id];
      else
        $where_id = ['blog.id' => $id];

      $data['blog'] = $this->helper->_blog($id);

      if(empty($data['blog']))
        return $this->helper->_errors_404();

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

      $data['blogs'] = $this->helper->_blog(
        null,

        [
          'count_box' => 4,
          'group'     => $group,
          'tags'      => explode(',', $data['blog']['tags']),
          'not_in'    => ['id', [$id]],
        ]
      );

      return $this->base->view_s("site.main.blog_id", $data);
    } else {
      $tags                 = explode(',', str_replace(']', '', str_replace('[', '', $this->request['tag'] ?? '')));
      $data['current_tags'] = $tags;
      $where[]              = ['blog.tags', '!=', '\'\''];

      $data['blog'] = $this->helper->_blog(
        $id,
        ['count_box' => $count_box, 'group' => $group, 'tags' => $tags]
      );

      return $this->base->view_s("site.main.blog", $data);
    }
  }

  /**
   * Contact Us.
   *
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function contact_us()
  {
    $data = $this->helper->duplicate_data();

    return $this->helper->_page('contact-us', 'site.main.contact_us', 'str', $data);
  }

  /**
   * Search.
   *
   * @param $page
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function search($page = 0)
  {
    $data  = $this->helper->duplicate_data();
    $limit = 12;
    $page  = $page * $limit;
    $q     = $this->request['q'];
    $count = 0;

    $query = function($count) use ($q) {
      return '
			(SELECT
			 ' . ($count ? 'COUNT(str.id) AS count' : ('str.id COLLATE utf8_general_ci as id,
			 str.name COLLATE utf8_general_ci as name,
			 str.name_table COLLATE utf8_general_ci as name_table,
			 str.translation COLLATE utf8_general_ci as translation,
			 str.text COLLATE utf8_general_ci as text')) . '
			FROM str
			WHERE `text` LIKE \'%' . trim($q) . '%\' OR `name` LIKE \'%' . trim($q) . '%\')

			UNION ALL

			(SELECT
			 ' . ($count ? 'COUNT(catalog_buy.id) AS count' : ('catalog_buy.id COLLATE utf8_general_ci as id,
			 catalog_buy.name COLLATE utf8_general_ci as name,
			 catalog_buy.name_table COLLATE utf8_general_ci as name_table,
			 catalog_buy.translation COLLATE utf8_general_ci as translation,
			 catalog_buy.text COLLATE utf8_general_ci as text')) . '
			FROM catalog_buy
			WHERE `text` LIKE \'%' . trim($q) . '%\' OR `name` LIKE \'%' . trim($q) . '%\')

			UNION ALL

			(SELECT
			 ' . ($count ? 'COUNT(catalog_development_projects.id) AS count' : ('catalog_development_projects.id COLLATE utf8_general_ci as id,
			 catalog_development_projects.name COLLATE utf8_general_ci as name,
			 catalog_development_projects.name_table COLLATE utf8_general_ci as name_table,
			 catalog_development_projects.translation COLLATE utf8_general_ci as translation,
			 catalog_development_projects.text COLLATE utf8_general_ci as text')) . '
			FROM catalog_development_projects
			WHERE `text` LIKE \'%' . trim($q) . '%\' OR `name` LIKE \'%' . trim($q) . '%\')
			
			UNION ALL

			(SELECT
			 ' . ($count ? 'COUNT(catalog_new_building.id) AS count' : ('catalog_new_building.id COLLATE utf8_general_ci as id,
			 catalog_new_building.name COLLATE utf8_general_ci as name,
			 catalog_new_building.name_table COLLATE utf8_general_ci as name_table,
			 catalog_new_building.translation COLLATE utf8_general_ci as translation,
			 catalog_new_building.text COLLATE utf8_general_ci as text')) . '
			FROM catalog_new_building
			WHERE `text` LIKE \'%' . trim($q) . '%\' OR `name` LIKE \'%' . trim($q) . '%\')

			UNION ALL

			(SELECT
			 ' . ($count ? 'COUNT(catalog_rent.id) AS count' : ('catalog_rent.id COLLATE utf8_general_ci as id,
			 catalog_rent.name COLLATE utf8_general_ci as name,
			 catalog_rent.name_table COLLATE utf8_general_ci as name_table,
			 catalog_rent.translation COLLATE utf8_general_ci as translation,
			 catalog_rent.text COLLATE utf8_general_ci as text')) . '
			FROM catalog_rent
			WHERE `text` LIKE \'%' . trim($q) . '%\' OR `name` LIKE \'%' . trim($q) . '%\')

			UNION ALL

			(SELECT
			 ' . ($count ? 'COUNT(services.id) AS count' : ('services.id COLLATE utf8_general_ci as id,
			 services.name COLLATE utf8_general_ci as name,
			 services.name_table COLLATE utf8_general_ci as name_table,
			 services.translation COLLATE utf8_general_ci as translation,
			 services.text COLLATE utf8_general_ci as text')) . '
			FROM services
			WHERE `text` LIKE \'%' . trim($q) . '%\' OR `name` LIKE \'%' . trim($q) . '%\')

			UNION ALL

			(SELECT
			 ' . ($count ? 'COUNT(main.id) AS count' : ('main.id COLLATE utf8_general_ci as id,
			 main.name COLLATE utf8_general_ci as name,
			 main.name_table COLLATE utf8_general_ci as name_table,
			 main.translation COLLATE utf8_general_ci as translation,
			 main.text COLLATE utf8_general_ci as text')) . '
			FROM main
			WHERE `text` LIKE \'%' . trim($q) . '%\' OR `name` LIKE \'%' . trim($q) . '%\')

			UNION ALL

			(SELECT
		 ' . ($count ? 'COUNT(blog.id) AS count' : ('blog.id COLLATE utf8_general_ci as id,
			 blog.name COLLATE utf8_general_ci as name,
			 blog.name_table COLLATE utf8_general_ci as name_table,
			 blog.translation COLLATE utf8_general_ci as translation,
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
    $type     = $this->request['type'];
    $name_url = $this->request['name_url'];
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
          array_merge($cart, [$id => ['id' => $id, 'name_url' => $name_url]])
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

    foreach($this->requests->session()->get('cart') ?? [] as $v)
      $data['cart'][$v['id']] = $v;

    $data['result'] = 'ok';
    $data['count']  = count(array_values($this->requests->session()->get('cart') ?? []));

    return json_encode($data);
  }

  /**
   * Страницы.
   *
   * @param null   $id
   * @param string $view
   * @param string $name_table
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function page($id = null, $view = 'site.main.page_id', $name_table = 'str')
  {
    $data = $this->helper->duplicate_data();

    return $this->helper->_page($id, $view, $name_table, $data);
  }

  /**
   * Портфолио.
   *
   * @param null $page
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function portfolio($page = null)
  {
    $data         = $this->helper->duplicate_data();
    $data['page'] = $page;

    return $this->base->view_s('site.main.portfolio', $data);
  }

  /**invest-in-development-projects
   * Tools Send mail.
   */
  public function submit_required()
  {
    $param            = $this->dynamic->t('params')->select('params.*', 'little_description as key')->get();
    $params           = [];
    $params['params'] = [];

    $params['langSt'] = function($t, $l = '') {
      return $this->base->lang($t, $l);
    };

    foreach($param as $key => $p)
      $params['params'][$p->name] = $p->toArray();

    $form                  = $this->base->decode_serialize($this->request);
    $params['current_url'] = $form['current_url'];
    $form_data             = [];
    $type                  = $this->request['type'];
    $title                 = '';
    $from                  = 'no-realy@' . env('APP_URL_DOMIN');

    foreach($form as $k => $v)
      $form_data[$k] = (int) $v == -1 ? '' : $v;

    if($type == 'subscription_form') {
      $title = __('main.subscription_admin');

      // Insert Subscribe email
      $subscribe_mail = $this->dynamic->t('params_subscribe')
        ->where('subscribe_mail', '=', trim($form_data['email']))
        ->first();

      if(!$subscribe_mail)
        $this->dynamic->t('params_subscribe')->insertGetId(
          [
            'created_at'     => Carbon::now(),
            'subscribe_mail' => $form_data['email'],
            'periodicity'    => $form_data['periodicity'],
            'type_subscribe' => $form_data['type_subscribe'],
          ]
        );

      // Отправка уведомления
      Mail::send(
        'emails.' . $type,
        array_merge($form_data, $params),

        function($m) use ($params, $param, $from, $form_data) {
          $m->from($from, __('main.uk_property_advisors'));
          $m->to(trim($form_data['email']), 'no-realy')->subject(__('main.uk_property_advisors'));
        }
      );
    }

    if($type == 'request_form') {
      $title = __('main.selection_request_mess_admin');

      // Отправка уведомления
      Mail::send(
        'emails.' . $type,
        array_merge($form_data, $params),

        function($m) use ($params, $param, $from, $form_data) {
          $m->from($from, __('main.uk_property_advisors'));
          $m->to(trim($form_data['email']), 'no-realy')->subject(__('main.uk_property_advisors'));
        }
      );
    }

    if($type == 'consultation_form') {
      $title = __('main.consultation_form_admin');

      // Отправка уведомления
      Mail::send(
        'emails.' . $type,
        array_merge($form_data, $params),

        function($m) use ($params, $param, $from, $form_data) {
          $m->from($from, __('main.uk_property_advisors'));
          $m->to(trim($form_data['email']), 'no-realy')->subject(__('main.uk_property_advisors'));
        }
      );
    }

    if($type == 'contact_form') {
      $title = __('main.contact_form_admin');

      // Отправка уведомления
      Mail::send(
        'emails.' . $type,
        array_merge($form_data, $params),

        function($m) use ($params, $param, $from, $form_data) {
          $m->from($from, __('main.uk_property_advisors'));
          $m->to(trim($form_data['email']), 'no-realy')->subject(__('main.uk_property_advisors'));
        }
      );
    }

    if($type == 'friend_form') {
      $title     = __('main.send_compilation_friend_admin');
      $cart_data = [];
      $cart      = array_values($this->requests->session()->get('cart') ?? []);

      for($i = 0; count($cart ?? []) > $i; $i++)
        $cart_data[$cart[$i]['name_url']][] = $cart[$i]['id'] ?? 0;

      foreach($cart_data as $k => $ids) {
        $filters = $this->_catalog_array($k);

        if($filters) {
          $query = $this->dynamic->t($filters['table']);

          if(!empty($ids))
            $query = $query->whereIn("{$filters['table']}.id", $ids);

          $catalog = $query
            ->join(
              'files',

              function($join) use ($filters) {
                $join->type = 'LEFT OUTER';
                $join->on("{$filters['table']}.id", '=', 'files.id_album')
                  ->where('files.name_table', '=', "{$filters['table']}album")
                  ->where('files.main', '=', 1);
              }
            )
            ->select("{$filters['table']}.*", 'files.file', 'files.crop')
            ->get()
            ->toArray();

          $params['objects'] = ($data['catalog'] ?? []) +
            array_map(
              function($v) use ($k) {
                return array_merge($v, ['name_url' => $k]);
              }, $catalog
            );
        }
      }

      // Отправка уведомления
      foreach($form_data['friend_email'] as $em) {
        $form_data['email'] = $em;
        Mail::send(
          'emails.' . $type,
          array_merge($form_data, $params),

          function($m) use ($params, $param, $from, $form_data) {
            $m->from($from, __('main.uk_property_advisors'));
            $m->to(trim($form_data['email']), 'no-realy')->subject(__('main.uk_property_advisors'));
          }
        );
      }

      if(isset($form_data['send_agent'])) {
        $title                   = __('main.send_compilation_friend_admin');
        $params['is_agent_form'] = true;

        // Отправка уведомления
        foreach(explode(',', $params['langSt']($params['params']['email_notifications_agent']['key'])) as $mail)
          Mail::send(
            'emails.' . $type,
            array_merge($form_data, $params),

            function($m) use ($params, $param, $title, $from, $form_data, $mail) {
              $m->from($from, $title);
              $m->to(trim($mail), 'no-realy')->subject($title);
            }
          );
      }
    }

    $params['admin_text'] = __('main.' . $type);

    // Отправка уведомления администратору
    foreach(explode(',', $params['langSt']($params['params']['email_notifications']['key'])) as $mail)
      Mail::send(
        'emails.' . $type,
        array_merge($form_data, $params),

        function($m) use ($params, $param, $title, $from, $mail) {
          $m->from($from, $title);
          $m->to(trim($mail), 'no-realy')->subject($title);
        }
      );

    $ret['result'] = 'ok';
    echo json_encode($ret);

    exit;
  }

  /**
   * @param      $name
   * @param null $id
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function catalog($name, $id = null)
  {
    $data          = $this->helper->duplicate_data();
    $filters       = $this->_catalog_array($name);
    $where_similar = [["{$filters['table']}.active", '=', 1], ["{$filters['table']}.in_portfolio", '=', 0]];
    $cart          = array_values($this->requests->session()->get('cart') ?? []);
    $favorites_id  = [];

    if(empty($filters))
      return $this->helper->_errors_404();

    $data['service'] = [];
    $data['filters'] = $filters;

    if($id) {

      $data['page']   = $this->helper->_page($id, 'site.main.catalog_id', $filters['table'], $data, true);
      $data['name']   = $name;
      $data['meta_c'] = $this->base->getMeta($data, 'page');

      if($data['page']['area_from']) {
        $where_similar = array_merge(
          $where_similar,

          [
            ["{$filters['table']}.area_from", '>', (int) $data['page']['area_from'] - 20],
            ["{$filters['table']}.area_to", '<', (int) $data['page']['area_to'] + 20],
          ]
        );
      } else {
        $where_similar = array_merge(
          $where_similar,

          [
            ["{$filters['table']}.area", '>', (int) $data['page']['area'] - 20],
            ["{$filters['table']}.area", '<', (int) $data['page']['area'] + 20],
          ]
        );
      }

      if($data['page']['price_money_from']) {
        $where_similar = array_merge(
          $where_similar,

          [
            ["{$filters['table']}.price_money_from", '>', (int) $data['page']['price_money_from'] - 250000],
            ["{$filters['table']}.price_money_to", '<', (int) $data['page']['price_money_to'] + 250000],
          ]
        );
      } else {
        $where_similar = array_merge(
          $where_similar,

          [
            ["{$filters['table']}.price_money", '>', (int) $data['page']['price_money'] - 250000],
            ["{$filters['table']}.price_money", '<', (int) $data['page']['price_money'] + 250000],
          ]
        );
      }

      $where_similar = array_merge(
        $where_similar,

        [
          ["{$filters['table']}.cat_location", '=', $data['page']['cat_location']],
        ]
      );

      $data['similar_objects'] = $this->dynamic->t($filters['table'])
        ->where($where_similar)
        ->whereNotIn("{$filters['table']}.id", [$data['page']['id']])
        ->join(
          'files',

          function($join) use ($filters) {
            $join->type = 'LEFT OUTER';
            $join->on("{$filters['table']}.id", '=', 'files.id_album')
              ->where('files.name_table', '=', "{$filters['table']}album")
              ->where('files.main', '=', 1);
          }
        )
        ->select("{$filters['table']}.*", 'files.file', 'files.crop')
        ->inRandomOrder(4)
        ->get()
        ->toArray();

      $data['photos'] = $this
        ->dynamic
        ->t('files')
        ->where(
          [
            ['files.name_table', '=', "{$filters['table']}album"],
            ['files.id_album', '=', $data['page']['id']],
          ]
        )
        ->select('files.file', 'files.crop')
        ->get()
        ->toArray();

      $data['plan'] = $this
        ->dynamic
        ->t('files')
        ->where(
          [
            ['files.name_table', '=', "{$filters['table']}plan"],
            ['files.id_album', '=', $data['page']['id']],
          ]
        )
        ->select('files.file', 'files.crop')
        ->get()
        ->toArray();

      if($data['page']['cat_location'])
        $data['params_cat_location'] = $this
          ->dynamic
          ->t('params_cat_location')
          ->where(
            [
              ['active', '=', 1],
              ['id', '=', $data['page']['cat_location']],
            ]
          )
          ->first()
          ->toArray();
      else
        $data['params_cat_location'] = [];

      if($data['page']['type_object'] && is_array(json_decode($data['page']['type_object'], true)))
        $data['params_type_object'] = $this
          ->dynamic
          ->t('params_type_object')
          ->where([['active', '=', 1]])
          ->whereIn('id', json_decode($data['page']['type_object'], true) ?? [])
          ->get()
          ->toArray();
      else
        $data['params_type_object'] = [];

      if($data['page']['development_facilities'] && is_array(json_decode($data['page']['development_facilities'], true)))
        $data['development_facilities'] = $this
          ->dynamic
          ->t('params_development_facilities')
          ->where('active', '=', 1)
          ->whereIn('id', json_decode($data['page']['development_facilities'], true) ?? [])
          ->get()
          ->toArray();
      else
        $data['development_facilities'] = [];

      if($data['page']['estimated_completion'] && is_array(json_decode($data['page']['estimated_completion'], true)))
        $data['estimated_completion'] = $this
          ->dynamic
          ->t('params_estimated_completion')
          ->where('active', '=', 1)
          ->whereIn('id', json_decode($data['page']['estimated_completion'], true) ?? [])
          ->get()
          ->toArray();
      else
        $data['estimated_completion'] = [];

      for($i = 0; count($cart ?? []) > $i; $i++)
        $favorites_id[] = $cart[$i]['id'];

      $data['favorites_id'] = $favorites_id;

      return $this->base->view_s('site.main.catalog_id', $data);
    } else {
      $flt_res = [];

      $data['catalog_count'] = $this->dynamic
        ->t($data['filters']['table'])
        ->where([['active', '=', 1]])
        ->count();

      foreach($data['filters']['filters'] as $key => $filter) {
        if($filter['type'] === 'multi_checkbox') {
          $flt = $data['filters']['filters'][$key]['data'] = $this->dynamic
            ->t($filter['table'])
            ->where([['active', '=', 1]])
            ->get()
            ->toArray();


          // жопа что бы убрать чекбоксы в фильтрах для которых нету объектов
          foreach($flt as $f) {
            $flt_res[$key][] = $this->dynamic
              ->t($data['filters']['table'])
              ->where(
                [
                  ['active', '=', 1],

                  ["{$data['filters']['table']}.{$filter['column']}", '=', $f['id']],
                ]
              )
              ->orWhere(
                [
                  ['active', '=', 1],

                  [
                    "{$data['filters']['table']}.{$filter['column']}",
                    'like',
                    '%"' . $f['id'] . '"%',
                  ],
                ]
              )
              ->select("{$data['filters']['table']}.{$filter['column']}")
              ->first();
          }

          $tmp                                      = $data['filters']['filters'][$key]['data'];
          $data['filters']['filters'][$key]['data'] = [];

          if(is_numeric($flt_res[$key][$filter['column']]))
            $flt_res[$key][$filter['column']] = [$flt_res[$key][$filter['column']]];
          else
            $flt_res[$key][$filter['column']] = json_decode($flt_res[$key][$filter['column']], true);

          $ids = [];

          foreach($flt_res[$key] ?? [] as $f) {
            if($f[$key])
              if(is_numeric($f[$key]))
                $ids = array_merge($ids, [$f[$key]]);
              else
                $ids = array_merge($ids, json_decode($f[$key], true));
          }

          $ids = array_unique($ids);

          foreach($tmp as $k => $ff) {
            if(array_search($ff['id'], $ids) !== false)
              if(!isset($data['filters']['filters'][$key]['data'][$ff['id']]))
                $data['filters']['filters'][$key]['data'][$ff['id']] = $ff;
          }

          usort(
            $data['filters']['filters'][$key]['data'],

            function($a, $b) {
              if($a['id'] == $b['id'])
                return ($a['id'] < $b['id']) ? -1 : 1;

              return ($a['id'] < $b['id']) ? -1 : 1;
            }
          );

          for($i = 1, $j = 0, $n = count($data['filters']['filters'][$key]['data']); $i < $n; ++$i) {
            if($data['filters']['filters'][$key]['data'][$i]['id'] == $data['filters']['filters'][$key]['data'][$j]['id']) {
              unset($data['filters']['filters'][$key]['data'][$i]);
            } else {
              $j = $i;
            }
          }
          // конец жопы
        }

        if($filter['type'] === 'slider_select' || $filter['type'] === 'slider_select_area') {
          foreach($filter['fields'] as $key_field => $field) {
            $name_f                                                         = $field['real_name'] ?? $field['name'];
            $data['filters']['filters'][$key]['fields'][$key_field]['data'] = $this->dynamic
              ->t($data['filters']['table'])
              ->{$field['mode']}(
                "$name_f"
              );
          }
        }
      }

      foreach($data['services'] as $service)
        if($service['translation'] === $name)
          $data['service'] = $service;


      $data['meta_c'] = $this->base->getMeta($data, 'service');
      $data['name']   = $name;

      return $this->base->view_s('site.main.catalog', $data);
    }
  }

  public function search_render_catalog()
  {
    $form         = $this->base->decode_serialize($this->request);
    $data         = [];
    $cart         = array_values($this->requests->session()->get('cart') ?? []);
    $favorites_id = [];
    $session      = $form['session'] ?? false;
    $portfolio    = $form['is_portfolio'] ?? false;

    for($i = 0; count($cart ?? []) > $i; $i++)
      $favorites_id[] = $cart[$i]['id'];

    if($form['name_url'] && !$session) {
      $filters = $this->_catalog_array($form['name_url']);

      $where = [
        ["{$filters['table']}.active", '=', 1],
        ["{$filters['table']}.in_portfolio", '=', 0],
      ];

      $or_where = [
        ["{$filters['table']}.active", '=', 1],
        ["{$filters['table']}.in_portfolio", '=', 0],
      ];

      if(isset($form['price_money_from'])) {
        //        $where = array_merge($where, [["{$filters['table']}.price_money_from", '>=', $form['price_money_from']]]);
        $where = array_merge($where, [["{$filters['table']}.price_money_to", '>=', $form['price_money_from']]]);
        $where = array_merge($where, [["{$filters['table']}.price_money_to", '<=', $form['price_money_to']]]);

        $or_where = array_merge($or_where, [["{$filters['table']}.price_money_to", '=', null]]);
      }

      //  Для фиксированной цены
      if(isset($form['price_money_from_fixed'])) {
        $where = array_merge($where, [["{$filters['table']}.price_money", '>=', $form['price_money_from_fixed']]]);
        $where = array_merge($where, [["{$filters['table']}.price_money", '<=', $form['price_money_to_fixed']]]);

        $or_where = array_merge($or_where, [["{$filters['table']}.price_money", '=', null]]);
      }

      if(isset($form['bedrooms_from'])) {
        //        $where = array_merge($where, [["{$filters['table']}.bedrooms_from", '>=', $form['bedrooms_from']]]);
        //        $where = array_merge($where, [["{$filters['table']}.bedrooms_from", '<=', $form['bedrooms_to']]]);

        $where = array_merge($where, [["{$filters['table']}.bedrooms_to", '>=', $form['bedrooms_from']]]);
        $where = array_merge($where, [["{$filters['table']}.bedrooms_to", '<=', $form['bedrooms_to']]]);

        $or_where = array_merge($or_where, [["{$filters['table']}.bedrooms_to", '=', null]]);
      }

      //  Для фиксированного кол-ва комнат
      if(isset($form['bedrooms_from_fixed'])) {
        $where = array_merge($where, [["{$filters['table']}.bedrooms", '>=', $form['bedrooms_from_fixed']]]);
        $where = array_merge($where, [["{$filters['table']}.bedrooms", '<=', $form['bedrooms_to_fixed']]]);

        $or_where = array_merge($or_where, [["{$filters['table']}.bedrooms", '=', null]]);
      }

      if(isset($form['area_from'])) {
        if(($form['type_ft_m2'] ?? false) === 'ft') {
          $form['area_from'] = round($form['area_from'] / 10.7638673611111);
          $form['area_to']   = round($form['area_to'] / 10.7638673611111);
        }

        //        $where = array_merge($where, [["{$filters['table']}.area_from", '>=', $form['area_from']]]);
        $where = array_merge($where, [["{$filters['table']}.area_to", '>=', $form['area_from']]]);
        $where = array_merge($where, [["{$filters['table']}.area_to", '<=', $form['area_to']]]);

        $or_where = array_merge($or_where, [["{$filters['table']}.area_to", '=', null]]);
      }

      // Для фиксированной площади
      if(isset($form['area'])) {
        if(($form['type_ft_m2'] ?? false) === 'ft') {
          $form['area_from_fixed'] = round($form['area_from_fixed'] / 10.7638673611111) - 1;
          $form['area_to_fixed']   = round($form['area_to_fixed'] / 10.7638673611111) + 2;
        }

        $where = array_merge($where, [["{$filters['table']}.area", '>=', $form['area_from_fixed']]]);
        $where = array_merge($where, [["{$filters['table']}.area", '<=', $form['area_to_fixed']]]);

        $or_where = array_merge($or_where, [["{$filters['table']}.area", '=', null]]);
      }

      $catalog_sql = $this->dynamic->t($filters['table'])
        ->where($where);

      if(isset($form['cat_location']))
        $catalog_sql = $catalog_sql->whereIn("{$filters['table']}.cat_location", $form['cat_location']);

      if(isset($form['type_object']))
        $catalog_sql = $catalog_sql->where(

          function($query) use ($form, $filters) {
            for($i = 0; $i < count($form['type_object']); $i++) {
              $query->orwhere(
                "{$filters['table']}.type_object",
                'like',
                '%"' . $form['type_object'][$i] . '"%'
              );
            }
          }
        );

      if(isset($form['development_facilities']))
        $catalog_sql = $catalog_sql->where(
        // "{$filters['table']}.development_facilities",

          function($query) use ($form, $filters) {
            for($i = 0; $i < count($form['development_facilities']); $i++) {
              print_r('%"' . $form['development_facilities'][$i] . '"%');

              $query->orwhere(
                "{$filters['table']}.development_facilities",
                'like',
                '%"' . $form['development_facilities'][$i] . '"%'
              );
            }
          }
        );

      if(isset($form['estimated_completion']))
        $catalog_sql = $catalog_sql->where(
          function($query) use ($form, $filters) {
            for($i = 0; $i < count($form['estimated_completion']); $i++) {
              $query->orwhere(
                "{$filters['table']}.estimated_completion",
                'like',
                '%"' . $form['estimated_completion'][$i] . '"%'
              );
            }
          }
        );

      $catalog_sql = $catalog_sql->orWhere($or_where);
      $order_by    = $filters['group']["group_{$form['group']}_{$form['sort_by']}"];

      if(is_array($order_by))
        $order_by = DB::raw("{$order_by['mode']}({$filters['table']}.{$order_by['name']})");
      else
        $order_by = $filters['table'] . '.' . $order_by;

      $data['catalog'] = $catalog_sql->join(
        'files',

        function($join) use ($filters) {
          $join->type = 'LEFT OUTER';
          $join->on("{$filters['table']}.id", '=', 'files.id_album')
            ->where('files.name_table', '=', "{$filters['table']}album")
            ->where('files.main', '=', 1);
        }
      )
        ->groupBy($filters['table'] . '.id')
        ->orderBy($order_by, $form['sort_by'])
        ->select("{$filters['table']}.*", 'files.file', 'files.crop')
        ->paginate(40);
    }

    // For Favorite
    if($session) {
      $cart_data = [];

      for($i = 0; count($cart ?? []) > $i; $i++)
        $cart_data[$cart[$i]['name_url']][] = $cart[$i]['id'] ?? 0;

      foreach($cart_data as $k => $ids) {
        $filters = $this->_catalog_array($k);

        if($filters) {
          $query = $this->dynamic->t($filters['table']);

          if(!empty($ids))
            $query = $query->whereIn("{$filters['table']}.id", $ids);

          $catalog = $query
            ->join(
              'files',

              function($join) use ($filters) {
                $join->type = 'LEFT OUTER';
                $join->on("{$filters['table']}.id", '=', 'files.id_album')
                  ->where('files.name_table', '=', "{$filters['table']}album")
                  ->where('files.main', '=', 1);
              }
            )
            ->select("{$filters['table']}.*", 'files.file', 'files.crop')
            ->get()
            ->toArray();

          $data['catalog'] = ($data['catalog'] ?? []) +
            array_map(
              function($v) use ($k) {
                return array_merge($v, ['name_url' => $k]);
              }, $catalog
            );
        }
      }
    }

    if($portfolio) {
      $limit = 20;
      $page  = $form['pagination'];
      $count = 0;

      $query = function($count) {
        return '
      (SELECT
 ' . ($count ? 'COUNT(catalog_development_projects.id) AS count' : ('
       catalog_development_projects.id COLLATE utf8_general_ci as id,
       files.file COLLATE utf8_general_ci as file,
       files.crop COLLATE utf8_general_ci as crop,
       catalog_development_projects.price_money_from as price_money_from,
       catalog_development_projects.price_money_to as price_money_to,
       catalog_development_projects.price_money as price_money,
       catalog_development_projects.name COLLATE utf8_general_ci as name,
       catalog_development_projects.name_table COLLATE utf8_general_ci as name_table,
       catalog_development_projects.translation COLLATE utf8_general_ci as translation,
       catalog_development_projects.area_from COLLATE utf8_general_ci as area_from,
       catalog_development_projects.area_to COLLATE utf8_general_ci as area_to,
       catalog_development_projects.area COLLATE utf8_general_ci as area,
       catalog_development_projects.bedrooms_from COLLATE utf8_general_ci as bedrooms_from,
       catalog_development_projects.bedrooms_to COLLATE utf8_general_ci as bedrooms_to,
       catalog_development_projects.bedrooms COLLATE utf8_general_ci as bedrooms,
       catalog_development_projects.in_portfolio COLLATE utf8_general_ci as in_portfolio,
       catalog_development_projects.little_description COLLATE utf8_general_ci as little_description')) . '
      FROM catalog_development_projects
      LEFT OUTER join `files`
        on `catalog_development_projects`.`id` = `files`.`id_album` and `files`.`name_table` = \'catalog_development_projectsalbum\' and
       `files`.`main` = 1
      WHERE `in_portfolio` = 1)

      UNION ALL

      (SELECT
     ' . ($count ? 'COUNT(catalog_new_building.id) AS count' : ('
       catalog_new_building.id COLLATE utf8_general_ci as id,
       files.file COLLATE utf8_general_ci as file,
       files.crop COLLATE utf8_general_ci as crop,
       catalog_new_building.price_money_from as price_money_from,
       catalog_new_building.price_money_to as price_money_to,
       catalog_new_building.price_money as price_money,
       catalog_new_building.name COLLATE utf8_general_ci as name,
       catalog_new_building.name_table COLLATE utf8_general_ci as name_table,
       catalog_new_building.translation COLLATE utf8_general_ci as translation,
       catalog_new_building.area_from COLLATE utf8_general_ci as area_from,
       catalog_new_building.area_to COLLATE utf8_general_ci as area_to,
       catalog_new_building.area COLLATE utf8_general_ci as area,
       catalog_new_building.bedrooms_from COLLATE utf8_general_ci as bedrooms_from,
       catalog_new_building.bedrooms_to COLLATE utf8_general_ci as bedrooms_to,
       catalog_new_building.bedrooms COLLATE utf8_general_ci as bedrooms,
       catalog_new_building.in_portfolio COLLATE utf8_general_ci as in_portfolio,
       catalog_new_building.little_description COLLATE utf8_general_ci as little_description')) . '
      FROM catalog_new_building
      LEFT OUTER join `files`
        on `catalog_new_building`.`id` = `files`.`id_album` and `files`.`name_table` = \'catalog_new_buildingalbum\' and
       `files`.`main` = 1
      WHERE `in_portfolio` = 1)
      
      UNION ALL

      (SELECT
     ' . ($count ? 'COUNT(catalog_buy.id) AS count' : ('
       catalog_buy.id COLLATE utf8_general_ci as id,
       files.file COLLATE utf8_general_ci as file,
       files.crop COLLATE utf8_general_ci as crop,
       catalog_buy.price_money_from as price_money_from,
       catalog_buy.price_money_to as price_money_to,
       catalog_buy.price_money as price_money,
       catalog_buy.name COLLATE utf8_general_ci as name,
       catalog_buy.name_table COLLATE utf8_general_ci as name_table,
       catalog_buy.translation COLLATE utf8_general_ci as translation,
       catalog_buy.area_from COLLATE utf8_general_ci as area_from,
       catalog_buy.area_to COLLATE utf8_general_ci as area_to,
       catalog_buy.area COLLATE utf8_general_ci as area,
       catalog_buy.bedrooms_from COLLATE utf8_general_ci as bedrooms_from,
       catalog_buy.bedrooms_to COLLATE utf8_general_ci as bedrooms_to,
       catalog_buy.bedrooms COLLATE utf8_general_ci as bedrooms,
       catalog_buy.in_portfolio COLLATE utf8_general_ci as in_portfolio,
       catalog_buy.little_description COLLATE utf8_general_ci as little_description')) . '
      FROM catalog_buy
      LEFT OUTER join `files`
        on `catalog_buy`.`id` = `files`.`id_album` and `files`.`name_table` = \'catalog_buyalbum\' and
       `files`.`main` = 1
      WHERE `in_portfolio` = 1)
      
      UNION ALL

      (SELECT
     ' . ($count ? 'COUNT(catalog_rent.id) AS count' : ('
       catalog_rent.id COLLATE utf8_general_ci as id,
       files.file COLLATE utf8_general_ci as file,
       files.crop COLLATE utf8_general_ci as crop,
       catalog_rent.price_money_from as price_money_from,
       catalog_rent.price_money_to as price_money_to,
       catalog_rent.price_money as price_money,
       catalog_rent.name COLLATE utf8_general_ci as name,
       catalog_rent.name_table COLLATE utf8_general_ci as name_table,
       catalog_rent.translation COLLATE utf8_general_ci as translation,
       catalog_rent.area_from COLLATE utf8_general_ci as area_from,
       catalog_rent.area_to COLLATE utf8_general_ci as area_to,
       catalog_rent.area COLLATE utf8_general_ci as area,
       catalog_rent.bedrooms_from COLLATE utf8_general_ci as bedrooms_from,
       catalog_rent.bedrooms_to COLLATE utf8_general_ci as bedrooms_to,
       catalog_rent.bedrooms COLLATE utf8_general_ci as bedrooms,
       catalog_rent.in_portfolio COLLATE utf8_general_ci as in_portfolio,
       catalog_rent.little_description COLLATE utf8_general_ci as little_description')) . '
      FROM catalog_rent
      LEFT OUTER join `files`
        on `catalog_rent`.`id` = `files`.`id_album` and `files`.`name_table` = \'catalog_rentalbum\' and
       `files`.`main` = 1
      WHERE `in_portfolio` = 1) ';
      };

      $data['catalog'] = json_decode(
        json_encode(
          DB::select(
            $query(false) . ' ORDER BY `id` DESC LIMIT ' . ($page - 1) . ', ' . ($limit) . ' ;'
          )
        ), true
      );

      $data['count'] = DB::select($query(true));

      foreach($data['count'] as $v)
        $count = $count + $v->count;

      $data['count']      = $count;
      $data['page']       = $page ? $page / $limit : 1;
      $data['limit']      = $limit;
      $data['pagination'] = $form['pagination'];
      $data['paginate']   = true;
    }

    $data['type_ft_m2']   = $form['type_ft_m2'];
    $data['name_url']     = $form['name_url'];
    $data['show_like']    = $form['show_like'] ?? false;
    $data['favorites_id'] = $favorites_id;
    $data['cart']         = $cart;
    $data['paginate']     = true;

    return $this->base->view_s("site.block.catalog_list", $data);
  }
}
