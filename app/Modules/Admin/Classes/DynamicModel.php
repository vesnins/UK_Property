<?php

namespace App\Classes;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Request;
use Schema;

class DynamicModel extends Model
{
	/**
	 * @var
	 */
	protected static $_table;

	/**
	 * @param       $table
	 * @param array $parms
	 * @return null|static|\Illuminate\Database\Query\Builder as QueryBuilder
	 */
	public static function t($table, $parms = [])
	{
		$ret = null;

		if(class_exists($table)) {
			$ret = new $table($parms);
		} else {
			$ret = new static($parms);
			$ret->setTable($table);
		}
		return $ret;
	}

	/**
	 * @param $table
	 */
	public function setTable($table)
	{
		static::$_table = $table;
	}

	/**
	 * @return mixed
	 */
	public function getTable()
	{
		return static::$_table;
	}

	/**
	 * @return mixed
	 */
	public function getAllTableName()
	{
		$table = DB::select('SHOW TABLES');

		foreach($table as $key => $val) {
			$val   = (array) $val;
			$arr[] = array_shift($val);
		}

		return $arr;
	}

	/**
	 * @param null $name
	 * @return array
	 */
	public function getAllColumnTableName($name = null)
	{
		if($name) {
			$table = DB::select('SHOW FIELDS FROM ' . $name);

			foreach($table as $key => $val) {
				$val   = (array) $val;
				$arr[] = array_shift($val);
			}

			return $arr;
		} else {
			return [];
		}
	}
}