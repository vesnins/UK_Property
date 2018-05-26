<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Modules\Admin\Classes\Base;
use App\Modules\Admin\Models\Modules;
use Illuminate\Http\Request;

class DocsController extends Controller
{
	/**
	 * @var Modules
	 */
	protected $modules;

	/**
	 * @var Base
	 */
	protected $base;

	public function __construct(Request $request)
	{
		parent::__construct();

		$this->modules = new Modules();
		$this->base    = new Base($request);
	}

	/**
	 * @return \Illuminate\View\View
	 */
	public function getIndex()
	{
		try {
			$data         = [];
			$data['file'] = '';
			$handle       = @fopen(__DIR__ . "/../../readme.md", "rw");

			if($handle) {
				while(($buffer = fgets($handle, 4096)) !== false)
					$data['file'] .= $buffer;

				if(!feof($handle))
					$data['file'] = "Error: unexpected fgets() fail\n";

				fclose($handle);
			}

			return Base::view("admin::docs.index", $data);
		} catch(\Exception $err) {
			return Base::errorPage($err);
		}
	}
}
