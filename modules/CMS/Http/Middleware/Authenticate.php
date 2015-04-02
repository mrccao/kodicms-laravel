<?php namespace KodiCMS\CMS\Http\Middleware;

use Closure;
use KodiCMS\API\Exceptions\AuthenticateException;
use Illuminate\Contracts\Auth\Guard;

class Authenticate {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * TODO: добавить проверку прав доступа
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if ($this->auth->guest())
		{
			if ($request->ajax())
			{
				throw new AuthenticateException('Unauthorized.');
			}
			else
			{
				return redirect()->guest('auth/login');
			}
		}

		return $next($request);
	}

}
