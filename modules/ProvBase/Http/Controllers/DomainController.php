<?php namespace Modules\ProvBase\Http\Controllers;

use Pingpong\Modules\Routing\Controller;

class DomainController extends \BaseController {
	
	public function view_form_fields($model = null)
	{
		return array(
			array('form_type' => 'text', 'name' => 'name', 'description' => 'URL'),
			array('form_type' => 'text', 'name' => 'alias', 'description' => 'Aliases', 'help' => 'aliases seperated by ":"'),
			array('form_type' => 'select', 'name' => 'type', 'description' => 'Type', 'value' => ['sip' => 'SIP', 'email' => 'Email', 'dhcp' => 'DHCP']),
		);
	}
	
}