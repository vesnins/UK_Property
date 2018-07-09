<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Modules\Admin\Classes\Base;
use App\Modules\Admin\Models\Modules;
use App\Modules\Admin\Models\Plugins;
use Illuminate\Http\Request;
use Schema;

class EngineerController extends ModuleController
{
  /**
   * @var Request
   */
  public static $requests_self;

  /**
   * @var \Illuminate\Config\Repository|mixed
   */
  public $admin_plugins;

  /**
   * @var \Illuminate\Config\Repository|mixed
   */
  public $admin_modules;

  /**
   * EngineerController constructor.
   * @param Request $request
   */
  public function __construct(Request $request)
  {
    parent::__construct($request);

    $this->request       = $request->all();
    $this->modules       = new Modules();
    $this->admin_plugins = config('admin.plugins');
    $this->admin_modules = config('admin.module');
    self::$requests_self = $this->requests = $request;
  }

  public function main()
  {
    return Base::view("admin::engineer.index", ['modules' => $this->admin_modules]);
  }

  /**
   * @param        $page
   * @param string $id
   * @param null   $apply
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|mixed
   */
  public function update($page, $id = '', $apply = null)
  {
    $url = (isset($_SESSION['url'])) ? '?' . $_SESSION['url'] : '';

    if($this->requests->isMethod('post')) {
      $page = $this->request['link_module'] ?? '';
    //  print_r($this->request);
     // print_r(Base::getModule("id", $this->request['id'])[0]);

      if($this->request['id'])
        $current_module = Base::getModule("id", $this->request['id'])[0] ?? [];
      else
        $current_module = [];

      if(empty($current_module)) {
        $arr = $this->request;
        unset($arr['q']);


        //print_r($arr);
       // exit;

        $this->admin_modules[count($this->admin_modules)] = $arr;
      } else {
        foreach($current_module as $k => $v)
          // Заменяем значения
          $current_module[$k] = $this->request[$k] ?? $v;

        // Заменяем модуль
        foreach($this->admin_modules as $k => $v)
          if($current_module['id'] === $v['id'])
            $this->admin_modules[$k] = $current_module;
      }

      $fd = fopen(config_path() . "/admin/module_test.json", 'w') or die("не удалось создать файл");
      fwrite($fd, (string) json_encode($this->admin_modules, JSON_UNESCAPED_UNICODE)); // запишем строку в начало
      fseek($fd, 0);
      fclose($fd);

      if($apply && $page) {
        return redirect('/admin/engineer/update/' . $page . '/' . $id);
      } else {
        return redirect('/admin/engineer/');
      }
    } else {
      if($page)
        $data['module'] = Base::getModule("link_module", $page)[0] ?? [];
      else
        $data['module'] = [];

      $data['modules'] = $this->admin_modules;
      $data['plugins'] = $this->admin_plugins;
    }

    return Base::view("admin::engineer.update", $data);
  }

  public function postIndex()
  {
    $Modules = $this->modules;
    $modules = $this->modules->where('link_module', $this->request['link_module'])->first();

    if(!empty($modules)) {
      $Modules = $modules;
    }

    if($this->request['name_module']) {
      $Modules->name_module = $this->request['name_module'];
    }
    if($this->request['link_module']) {
      $Modules->link_module = $this->request['link_module'];
    }
    if($this->request['count_module']) {
      $Modules->count_module = $this->request['count_module'];
    }
    if($this->request['count_module']) {
      $Modules->count_module = $this->request['count_module'];
    }
    if($this->request['big_width']) {
      $Modules->big_width = $this->request['big_width'];
    }
    if($this->request['big_height']) {
      $Modules->big_height = $this->request['big_height'];
    }
    if($this->request['small_width']) {
      $Modules->small_width = $this->request['small_width'];
    }
    if($this->request['small_height']) {
      $Modules->small_height = $this->request['small_height'];
    }
    if($this->request['class_module']) {
      $Modules->class_module = $this->request['class_module'];
    }
    if(isset($this->request['plugins'])) {
      $Modules->plugins = json_encode($this->request['plugins']);
//      $plugins          = $this->plugins->whereIn('id', $this->request['plugins'])->get();
    } else {
      $plugins = [];
    }

    $Modules->save();

    if(!Schema::hasTable($this->request['link_module'])) {
      Schema::create(
        $this->request['link_module'],

        function($table) {
          $table->increments('id');
        }
      );
    }

    Schema::table(
      $this->request['link_module'], function($table) use ($plugins) {
      foreach($plugins as $val) {
        $type   = $val['sql_type'];
        $column = $val['sql_column'];

        if(!Schema::hasColumn($this->request['link_module'], $column)) {
          $table->$type($column);
        }
      }

      if(!Schema::hasColumn($this->request['link_module'], 'created_at')) {
        $table->dateTime('created_at');
      }

      if(!Schema::hasColumn($this->request['link_module'], 'updated_at')) {
        $table->dateTime('updated_at');
      }
    }
    );

    return redirect('/admin');
  }

  public function getmodele()
  {
    if($this->request['id']) {
      $res['mass']   = $this->admin_plugins[$this->request['id']] ?? [];

      $res['mass']['body'] = ModuleController::_switcher(
        $res['mass'],
        'menu',
        ['id' => '', 'table' => 'menu', 'modules' => Base::getModule("link_module", 'str')[0]]
      );

      $res['result'] = 'ok';
    } else {
      $res['result'] = 'error';
    }

    return json_encode($res);
  }
}
