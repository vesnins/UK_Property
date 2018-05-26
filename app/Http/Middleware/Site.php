<?php
namespace App\Http\Middleware;

use Closure;
use Session;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class Site
{
	/**
	 * SiteMiddleware constructor.
	 *
	 * @param Guard   $auth
	 * @param Request $request
	 */
	public function __construct(Guard $auth, Request $request)
	{
	}

	/**
	 * @param         $request
	 * @param Closure $next
	 * @return \Illuminate\Http\RedirectResponse
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

		return $next($request);
	}
}