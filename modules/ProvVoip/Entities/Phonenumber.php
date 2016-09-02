<?php

namespace Modules\ProvVoip\Entities;

use Illuminate\Support\Collection;

// Model not found? execute composer dump-autoload in lara root dir
class Phonenumber extends \BaseModel {

    // The associated SQL table for this Model
    public $table = 'phonenumber';

	// Add your validation rules here
	public static function rules($id=null)
	{
		$ret = array(
			'country_code' => 'required|numeric',
			'prefix_number' => 'required|numeric',
			'number' => 'required|numeric',
			'mta_id' => 'required|exists:mta,id|min:1',
			'port' => 'required|numeric|min:1',
			/* 'active' => 'required|boolean', */
			// TODO: check if password is secure and matches needs of external APIs (e.g. Envia)
		);

		// inject id to rules (so it is passed to prepare_rules)
		$ret['id'] = $id;

		return $ret;
	}


	// Name of View
	public static function view_headline()
	{
		return 'Phonenumbers';
	}


	// link title in index view
    public function view_index_label(){

		$management = $this->phonenumbermanagement;

		if (is_null($management)) {
			$state = 'No PhonenumberManagement existing!';
			$bsclass = 'danger';
			$act = 'n/a';
			$deact = 'n/a';
			$is_active = False;
		}
		else {
			$act = $management->activation_date;
			$deact = $management->deactivation_date;

			// deal with legacy problem of zero dates
			if ($act == '0000-00-00') {
				$act = null;
			}
			if ($deact == '0000-00-00') {
				$deact = null;
			}

			if (!boolval($act)) {
				$state = 'No activation date set!';
				$bsclass = 'danger';
				$is_active = False;
			}
			elseif ($act > date('c')) {
				$state = 'Waiting for activation';
				$bsclass = 'warning';
				$is_active = False;
			}
			else {
				if (!boolval($deact)) {
					$state = 'Active';
					$bsclass = 'success';
					$is_active = True;
				}
				else {
					if ($deact > date('c')) {
						$state = 'Active. Deactivation date set but not reached yet.';
						$bsclass = 'warning';
						$is_active = True;
					}
					else {
						$state = 'Deactivated.';
						$bsclass = 'info';
						$is_active = False;
					}
				}
			}
		}

		// reuse dates for view
		if (is_null($act)) $act = '-';
		if (is_null($deact)) $deact = '-';

		// TODO: Delete this overwriting of the state calculated from PhonenumberManagement when
		// auto (de)activition by cron and PhonenumberManagementObserver is activated!
        if ($this->active) {
			$state = 'Phonenumber state: Active.<br><i>PhonenumberManagement state: '.$state.'</i>';
			if ($bsclass == 'danger') {
				// error missing or poorly filled management
				// set explicitely again to clarify my intention
				$bsclass = 'danger';
			}
			else {
				if ($is_active) {
					$bsclass = 'success';
				}
				else {
					// something needs attention!
					$bsclass = 'warning';
				}
			}
		}
		else {
			$state = 'Phonenumber state: Inactive.<br><i>PhonenumberManagement state: '.$state.'</i>';
			if ($bsclass == 'danger') {
				// error missing or poorly filled management
				// set explicitely again to clarify my intention
				$bsclass = 'danger';
			}
			else {
				if ($is_active) {
					// something needs attention
					$bsclass = 'warning';
				}
				else {
					$bsclass = 'info';
				}
			}
		}

        // TODO: use mta states.
        //       Maybe use fast ping to test if online in this function?

        return ['index' => [$this->prefix_number.'/'.$this->number, $act, $deact, $state],
                'index_header' => ['Number', 'Activation date', 'Deactivation date', 'State'],
                'bsclass' => $bsclass,
                'header' => 'Port '.$this->port.': '.$this->prefix_number."/".$this->number];
    }

	/**
	 * ALL RELATIONS
	 * link with mtas
	 */
	public function mta()
	{
		return $this->belongsTo('Modules\ProvVoip\Entities\Mta', 'mta_id');
	}

	// belongs to an mta
	public function view_belongs_to ()
	{
		return $this->mta;
	}

	// View Relation.
	public function view_has_many()
	{
		$ret = array();
		if (\PPModule::is_active('provvoip')) {

			$relation = $this->phonenumbermanagement;

			// can be created if no one exists, can be deleted if one exists
			if (is_null($relation)) {
				$ret['Main']['PhonenumberManagement']['relation'] = new Collection();
				$ret['Main']['PhonenumberManagement']['options']['hide_delete_button'] = 1;
			}
			else {
				$ret['Main']['PhonenumberManagement']['relation'] = [$relation];
				$ret['Main']['PhonenumberManagement']['options']['hide_create_button'] = 1;
			}

			$ret['Main']['PhonenumberManagement']['class'] = 'PhonenumberManagement';
		}

		if (\PPModule::is_active('provvoipenvia')) {

			// TODO: auth - loading controller from model could be a security issue ?
			$ret['Main']['Envia API']['html'] = '<h4>Available Envia API jobs</h4>';
			$ret['Main']['Envia API']['view']['view'] = 'provvoipenvia::ProvVoipEnvia.actions';
			$ret['Main']['Envia API']['view']['vars']['extra_data'] = \Modules\ProvVoip\Http\Controllers\PhonenumberController::_get_envia_management_jobs($this);
		}

		if (\PPModule::is_active('voipmon')) {
			$ret['Monitoring']['Cdr'] = $this->cdrs;
		}

		return $ret;
	}

	/**
	 * return all mta objects
	 */
	public function mtas()
	{
		$dummies = Mta::withTrashed()->where('is_dummy', True)->get();
		$mtas = Mta::get();
		return array('dummies' => $dummies, 'mtas' => $mtas);
	}

	/**
	 * return a list [id => hostname] of all mtas
	 */
	public function mtas_list()
	{
		$ret = array();
		foreach ($this->mtas()['mtas'] as $mta)
		{
			$ret[$mta->id] = $mta->hostname;
		}

		return $ret;
	}

	/**
	 * return a list [id => hostname] of all mtas
	 */
	public function mtas_list_with_dummies()
	{
		$ret = array();
		foreach ($this->mtas() as $mta_tmp)
		{
			foreach ($mta_tmp as $mta)
			{
				$ret[$mta->id] = $mta->hostname;
			}
		}

		return $ret;
	}

	/**
	 * link to management
	 */
	public function phonenumbermanagement() {
		return $this->hasOne('Modules\ProvVoip\Entities\PhonenumberManagement');
	}


	/**
	 * link to monitoring
	 *
	 * @author Ole Ernst
	 */
	public function cdrs()
	{
		if (\PPModule::is_active('voipmon')) {
			return $this->hasMany('Modules\VoipMon\Entities\Cdr');
		}

		return null;
	}

	/**
	 * BOOT:
	 * - init phone observer
	 */
	public static function boot()
	{
		parent::boot();

		Phonenumber::observe(new PhonenumberObserver);
	}
}


/**
 * Phonenumber Observer Class
 * Handles changes on Phonenumbers
 *
 * can handle   'creating', 'created', 'updating', 'updated',
 *              'deleting', 'deleted', 'saving', 'saved',
 *              'restoring', 'restored',
 *
 * @author Patrick Reichel
 */
class PhonenumberObserver
{

	/**
	 * For Envia API we create username and login if not given.
	 * Otherwise Envia will do this – so we would have to ask for this data…
	 *
	 * @author Patrick Reichel
	 */
	protected function _create_login_data($phonenumber) {

		if (\PPModule::is_active('provvoipenvia') && ($phonenumber->mta->type == 'sip')) {

			if (!boolval($phonenumber->password)) {
				$phonenumber->password = \Acme\php\Password::generate_password(15, 'envia');
			}

			// username at Envia defaults to prefixnumber + number – we also do so
			if (!boolval($phonenumber->username)) {
				$phonenumber->username = $phonenumber->prefix_number.$phonenumber->number;
			}

		}
	}


	public function creating($phonenumber) {

		$this->_create_login_data($phonenumber);
	}


	public function created($phonenumber)
	{
		$phonenumber->mta->make_configfile();
		$phonenumber->mta->modem->restart_modem();

	}


	public function updating($phonenumber) {

		$this->_create_login_data($phonenumber);
	}


	public function updated($phonenumber)
	{
		$this->_create_login_data($phonenumber);

		$phonenumber->mta->make_configfile();
		$phonenumber->mta->modem->restart_modem();
	}


	public function deleted($phonenumber)
	{
		$phonenumber->mta->make_configfile();
		$phonenumber->mta->modem->restart_modem();
	}
}