<?php namespace Modules\Ccc\Http\Middleware;

use Closure;
use App\Exceptions\AuthExceptions;


class CccBaseMiddleware {

	/**
	 * Check for valid login
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return true for valid login, false otherwise
	 */
	private function __auth_check($request)
	{
		// parse user from auth guard
		$user = \Auth::guard('ccc')->user();
		$user_id = $user->contract_id;

		// check if valid user
		if (is_null($user))
			return false; // access denied

		// parse the requested id
		$request_id = $request->route(\NamespaceController::module_get_pure_model_name());

		// parse requested (or related) contract id
		switch (\NamespaceController::module_get_pure_model_name())
		{
			case 'CccContract':
				$contract_id = $request_id;
				break;

			case 'CccItem':
			case 'CccSepaMandate':
				$model = \BaseController::get_model_obj();
				$item  = $model->findOrFail($request_id);
				$contract_id = $item->contract_id;
				break;

			default:
				return false; // access denied
				break;
		}


		// user does not match contract
		if ($user_id == $contract_id)
			return false; // access denied


		// valid access
		// all checks passed successfully
		return true;
	}


	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		try {

			// no user logged in
			if ($this->__auth_check($request))
				throw new AuthExceptions('Login Required');
		}
		catch (PermissionDeniedError $ex) {
			return View::make('auth.denied', array('error_msg' => $ex->getMessage()));
		}


		return $next($request);
	}

}
