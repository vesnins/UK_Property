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
    $whereBlog[] = ['blog.active', 1];
    $whereBlog[] = ['blog.tags', '!=', '\'\''];

    $data['blog'] = $this->helper->_blog(
      null,
      [
        'count_box' => 3,
        'order_by'  => [['blog.usefull', 'DESC'], ['blog.id', 'DESC']],
      ]
    );

    foreach($this->helper->_services() as $k => $serv)
      $data['services'][str_replace('services/', '', $serv['translation']) ?? $k] = $serv;

    $data['preview'] = $this
      ->dynamic
      ->t('files')
      ->where('name_table', 'mainalbum')
      ->orderBy('sort', 'ASC')
      ->get()
      ->toArray();

    $data['collections'] = $this
      ->dynamic
      ->t('files')
      ->where('name_table', 'maincollections')
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

    $data['main_page_video'] = $this
      ->dynamic
      ->t('files')
      ->where('files.name_table', '=', 'mainfiles')
      ->get()
      ->toArray();

    $data['about'] = $this
      ->dynamic
      ->t('about_company')
      ->where('about_company.active', '=', 1)
      ->first()
      ->toArray();

    // print_r($data['about']);
    // exit;


    $data['meta_c'] = $this->base->getMeta($data['main_page']);

    return $this->base->view_s("site.main.index", $data);
  }

  /**
   * Услуги.
   *
   * @param null $id
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function services($id = null)
  {
    $data['services'] = $this->helper->_services();
    return $this->helper->_page("services/$id", 'site.main.service_id', 'services', $data);
  }

  /**
   * About Company.
   *
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function about_company()
  {
    $data['reviews'] = $this
      ->dynamic
      ->t('reviews')
      ->where('reviews.active', '=', 1)
      ->get()
      ->toArray();

    $data['services'] = $this->helper->_services();

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
        ->where(
          array_merge(
            $where,

            [
              'bedroom'  => $data['villa']['bedroom'],
              'bathroom' => $data['villa']['bathroom'],
            ]
          )
        )
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
    return $this->helper->_page('contact-us', 'site.main.contact_us');
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
			 ' . ($count ? 'COUNT(str.id) AS count' : ('str.id COLLATE utf8_general_ci as id,
			 str.name COLLATE utf8_general_ci as name,
			 str.name_table COLLATE utf8_general_ci as name_table,
			 str.text COLLATE utf8_general_ci as text')) . '
			FROM str
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

  /**
   * Страницы.
   *
   * @param null   $id
   * @param string $view
   * @param string $name_table
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function page($id = null, $view = 'page_id', $name_table = 'str')
  {
    return $this->helper->_page($id, $view, $name_table);
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

  /**
   * @param      $name
   * @param null $id
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function catalog($name, $id = null)
  {
    $data    = [];
    $filters = $this->_catalog_array($name);

    if(empty($filters))
      return $this->helper->_errors_404();

    $data['services'] = $this->helper->_services();
    $data['service']  = [];
    $data['filters']  = $filters;

    foreach($data['filters']['filters'] as $key => $filter) {
      if($filter['type'] === 'multi_checkbox') {
        $data['filters']['filters'][$key]['data'] = $this->dynamic
          ->t($filter['table'])
          ->where([['active', '=', 1]])
          ->get()
          ->toArray();
      }

      if($filter['type'] === 'slider_select' || $filter['type'] === 'slider_select_area') {
        foreach($filter['fields'] as $key_field => $field) {
          $data['filters']['filters'][$key]['fields'][$key_field]['data'] = $this->dynamic
            ->t($data['filters']['table'])
            ->{$field['mode']}(
              "{$field['name']}"
            );
        }
      }
    }

    foreach($data['services'] as $service)
      if($service['translation']["services/$name"])
        $data['service'] = $service;

    $data['meta_c'] = $this->base->getMeta($data, 'service');
    $data['name']   = $name;

    return $this->base->view_s("site.main.{$filters['name']}", $data);
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
      'invest-in-development-projects' => [
        'name'  => 'invest_in_development_projects',
        'table' => 'catalog_development',

        'group' => [
          'group_1_ASC'  => 'price_money_from',
          'group_1_DESC' => 'price_money_to',

          'group_4_ASC'  => 'area_from',
          'group_4_DESC' => 'area_to',
        ],

        'filters' => [
          // Район(Расположение)
          'cat_location'           => [
            'type'  => 'multi_checkbox',
            'table' => 'params_cat_location',

            'fields' => [
              'cat_location' => [
                'name'  => 'cat_location',
                'title' => __('main.cat_location'),
              ],
            ],

            'class' => 'active',
          ],

          // Стоимость, млн евро(Стоимость)
          'price'                  => [
            'type' => 'slider_select',
            'step' => 500,

            'fields' => [
              'price_money_from' => [
                'mode'  => 'min',
                'name'  => 'price_money_from',
                'title' => __('main.cost_€_million'),
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
              'area_from' => [
                'mode'  => 'min',
                'name'  => 'bedrooms_from',
                'title' => __('main.bedrooms'),
              ],

              'price_to' => [
                'mode'  => 'max',
                'name'  => 'bedrooms_to',
                'title' => '',
              ],
            ],
          ],

          // Тип объекта
          'type_object'            => [
            'type'  => 'multi_checkbox',
            'table' => 'params_type_object',

            'fields' => [
              'type_object' => [
                'name'  => 'type_object',
                'title' => __('main.type_object'),
              ],
            ],
          ],

          // Инфраструктура
          'development_facilities' => [
            'type'  => 'multi_checkbox',
            'table' => 'params_development_facilities',

            'fields' => [
              'development_facilities' => [
                'name'  => 'development_facilities',
                'title' => __('main.development_facilities'),
              ],
            ],
          ],

          // Ожидаемый срок
          'estimated_completion'   => [
            'type'  => 'multi_checkbox',
            'table' => 'params_estimated_completion',

            'fields' => [
              'estimated_completion' => [
                'name'  => 'estimated_completion',
                'title' => __('main.estimated_completion'),
              ],
            ],
          ],
        ],
      ],
    ];

    return $filters[$name] ?? [];
  }

  public function search_render_catalog()
  {
    $form = $this->base->decode_serialize($this->request);
    $data = [];

    if($form['table']) {
      $filters = $this->_catalog_array($form['table']);

      $data['catalog'] = $this->dynamic->t($filters['table'])
        ->groupBy($filters['table'] . '.id')
        ->orderBy(
          $filters['table'] . '.' . $filters['group']["group_{$form['group']}_{$form['sort_by']}"],
          $form['sort_by']
        )
        ->get()
        ->toArray();
    }

    return $this->base->view_s("site.block.catalog_list", $data);
  }
}
