<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Modules\Admin\Classes\Base;
use App\Modules\Admin\Models\Modules;
use App\Modules\Admin\Models\Plugins;
use Illuminate\Http\Request;
use Schema;

class EngineerController extends Controller
{
	/**
	 * EngineerController constructor.
	 * @param Request $request
	 */
	public function __construct(Request $request)
	{
		parent::__construct();

		$this->request = $request->all();
		$this->modules = new Modules();
		$this->plugins = new Plugins();
	}

	/**
	 * @return mixed
	 */
	public function getIndex()
	{
		$plugins = $this->plugins->all();

		return Base::view("admin::engineer.index", ['plugins' => $plugins]);
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
			$plugins          = $this->plugins->whereIn('id', $this->request['plugins'])->get();
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

	public function postGetmodele()
	{
		if($this->request['id']) {
			$res['mass']   = $this->plugins->find($this->request['id']);
			$res['result'] = 'ok';
		} else {
			$res['result'] = 'error';
		}

		return json_encode($res);
	}
}
