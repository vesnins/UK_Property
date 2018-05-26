<?php namespace App\Http\Middleware;

use App\Modules\Admin\Classes\Base;
use Auth;
use Closure;
use DB;
use Illuminate\Contracts\Auth\Guard;
use Session;
use Illuminate\Http\Request;
use Requests;

class Authenticate
{

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Authenticate constructor.
	 *
	 * @param Guard $auth
	 * @param       $request
	 */
	public function __construct(Guard $auth, Request $request)
	{
		$right = Base::init($request);
		Session::put('right', $right);
		$this->auth = $auth;
		$this->base = new Base($request);
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure                 $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$setLocale = \Request::input('setLang');

		if($setLocale) {
			Session::put('lang', $setLocale);

			return redirect()->back();
		}

		if(Session::get('lang') === null) {
			Session::put('lang', env('LOCALE'));
		}

		\App::setLocale(Session::get('lang'));

		if(Auth::check()) {
			return $next($request);
		} else {
			if($request->ajax()) {
				return response('Авторизируйтесь пожалуйста', 401);
			} else {
				if(strrpos(url()->current(), '/admin/login') === false)
					return redirect()->guest('/admin/login');
				else
					return true;
			}
		}
	}
}
