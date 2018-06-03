<?php

namespace App\Http\Controllers;

use App\Classes\DynamicModel;
use App\Modules\Admin\Classes\Base;
use App\Modules\Admin\Http\Controllers\FilesController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HelperController extends Controller
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
	 * Get Array or single Blog.
	 *
	 * @param null  $id
	 * @param array $options
	 * @param array $where
	 * @return DynamicModel|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Model
	 */
	public function _blog($id = null, $options = [], $where = [['blog.active', 1]])
	{
		if($id) {
			if(!is_numeric($id))
				$where_id = ['blog.translation' => $id];
			else
				$where_id = ['blog.id' => $id];

			$result = $this->dynamic->t('blog')
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

				->join(
					'users',

					function($join) {
						$join->type = 'LEFT OUTER';
						$join->on('users.id', '=', 'blog.author_id');
					}
				)

				->join(
					'files AS files_users',

					function($join) {
						$join->type = 'LEFT OUTER';
						$join->on('blog.author_id', '=', 'files_users.id_album')
							->where('files_users.name_table', '=', 'usersalbum')
							->where('files_users.main', '=', 1);
					}
				)

				->select(
					'blog.*',
					'files.file',
					'files.crop',
					'files_users.file AS users_file',
					'files_users.crop AS users_crop',
					'users.name AS author_name'
				)

				->first();
		} else {
			$query = $this->dynamic->t('blog')
				->where($where)

				// TODO скорее отвалится когда теги будут с id больше 10
				->where(
					function($query) use ($options) {
						for($i = 0; $i < count($options['tags'] ?? []); $i++) {
							$query->orwhere('blog.tags', 'like', '%' . ($options['tags'] ?? [])[$i] . '%');
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

				->join(
					'users',

					function($join) {
						$join->type = 'LEFT OUTER';
						$join->on('users.id', '=', 'blog.author_id');
					}
				)

				->select('blog.*', 'files.file', 'files.crop', 'users.name AS author_name');

			foreach($options['order_by'] ?? [] as $order_by) {
				$query = $query->orderBy($order_by[0], $order_by[1]);
			}

			if(!isset($options['order_by']))
				$query = $query->orderBy('blog.' . ($options['group'] ?? 'id'), 'DESC');

			$result = $query
				->groupBy('blog.id')
				->paginate($options['count_box'] ?? 1);
		}

		return $result;
	}
}
