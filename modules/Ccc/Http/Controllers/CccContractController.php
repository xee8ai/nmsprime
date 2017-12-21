<?php

namespace Modules\Ccc\Http\Controllers;

use View;

use App\Http\Controllers\BaseViewController;

use Modules\ProvBase\Http\Controllers\ContractController;

class CccContractController extends ContractController {

	/**
	 * Show the editing form of the calling Object
	 *
	 * @param  int  $id
	 * @return View
	 */
	public function edit($id)
	{
		$model    = static::get_model_obj();
		$view_var = $model->findOrFail($id);
		$view_header 	= BaseViewController::translate_view($model->view_headline(),'Header');
		$headline       = BaseViewController::compute_headline(\NamespaceController::get_route_name(), $view_header, $view_var);

		$fields 		= BaseViewController::prepare_form_fields(static::get_controller_obj()->view_form_fields($view_var), $view_var);
		$form_fields	= BaseViewController::add_html_string ($fields, 'edit');

		$view_path = 'ccc::Generic.edit';
		$form_path = 'Generic.form';

		// proof if there are special views for the calling model
		if (View::exists(\NamespaceController::get_view_name().'.edit'))
			$view_path = \NamespaceController::get_view_name().'.edit';
		if (View::exists(\NamespaceController::get_view_name().'.form'))
			$form_path = \NamespaceController::get_view_name().'.form';

		return View::make ($view_path, $this->compact_prep_view(compact('model_name', 'view_var', 'view_header', 'form_path', 'form_fields', 'headline')));
	}


}
