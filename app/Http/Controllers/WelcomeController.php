<?php namespace App\Http\Controllers;

class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	*/


	/**
	 * Show the application welcome screen to the user.
	 *
	 * Show link to Admin and CCC panel login
	 *
	 * NOTE: this will only be called when middleware,
	 *       does not redirect to Admin or CCC login
	 *       -> See RedirectStartPage.php
	 *
	 * @return Response
	 */
	public function index()
	{
		$g = \GlobalConfig::first();
		$head1 = $g->headline1;
		$head2 = $g->headline2;

		if (\App::isLocal())
			return view('welcome')->with(compact('head1', 'head2'));

		abort(404);
	}

}
