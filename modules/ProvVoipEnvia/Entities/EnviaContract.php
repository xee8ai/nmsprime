<?php

namespace Modules\ProvVoipEnvia\Entities;

use Modules\ProvBase\Entities\Contract;
use Modules\ProvBase\Entities\Modem;
use Modules\ProvVoip\Entities\Phonenumber;
use Modules\ProvVoip\Entities\PhonenumberManagement;
use Modules\ProvVoipEnvia\Entities\EnviaOrder;

class EnviaContract extends \BaseModel {

	// The associated SQL table for this Model
	public $table = 'enviacontract';

    protected $fillable = [];


	// Name of View
	public static function view_headline()
	{
		return 'EnviaContract';
	}


	// link title in index view
	public function view_index_label()
	{

		$envia_contract_reference = is_null($this->envia_contract_reference) ? '–' : $this->envia_contract_reference;
		$state = is_null($this->state) ? '–' : $this->state;
		$start_date = is_null($this->start_date) ? '–' : $this->start_date;
		$end_date = is_null($this->end_date) ? '–' : $this->end_date;

		if (!$this->contract_id) {
			$contract_nr = '–';
		}
		else {
			$contract = Contract::withTrashed()->where('id', $this->contract_id)->first();
			if (!is_null($contract->deleted_at)) {
				$contract_nr = '<s>'.$contract->number.'</s>';
			}
			else {
				$contract_nr = '<a href="'.\URL::route('Contract.edit', array($this->contract_id)).'" target="_blank">'.$contract->number.'</a>';
			}
		}

		if (!$this->modem_id) {
			$modem_id = '–';
		}
		else {
			$modem = Modem::withTrashed()->where('id', $this->modem_id)->first();
			if (!is_null($modem->deleted_at)) {
				$modem_id = '<s>'.$this->modem_id.'</s>';
			}
			else {
				$modem_id = '<a href="'.\URL::route('Modem.edit', array($this->modem_id)).'" target="_blank">'.$this->modem_id.'</a>';
			}
		}

		if (in_array($state, ['Aktiv', ])) {
			$bsclass = 'success';
		}
		elseif (in_array($state, ['Gekündigt', ])) {
			$bsclass = 'danger';
		}
		elseif (in_array($state, ['In Realisierung', ])) {
			$bsclass = 'warning';
		}
		else {
			$bsclass = 'info';
		}

        return ['index' => [$envia_contract_reference, $state, $start_date, $end_date, $contract_nr, $modem_id],
                'index_header' => ['Envia contract reference', 'State', 'Start date', 'End date', 'Contract', 'Modem'],
                'bsclass' => $bsclass,
				'header' => $envia_contract_reference,
		];

	}


	/* // View Relation. */
	/* public function view_has_many() */
	/* { */
	/* 	$ret = array(); */
	/* 	$ret['Edit']['Contract'] = $this->contract; */
	/* 	/1* $ret['Edit']['Modem'] = $this->modem; *1/ */

	/* 	return $ret; */
	/* } */

	// the relations

	/**
	 * Link to contract
	 */
	public function contract() {
		return $this->belongsTo('Modules\ProvBase\Entities\Contract', 'contract_id');
	}

	/**
	 * Link to modem
	 */
	public function modem() {
		return $this->belongsTo('Modules\ProvBase\Entities\Modem', 'modem_id');
	}

	/**
	 * Link to enviaorders
	 */
	public function enviaorders() {
		return $this->hasMany('Modules\ProvVoipEnvia\Entities\EnviaOrder', 'enviacontract_id');
	}

	/**
	 * Link to phonenumbermanagements
	 */
	public function phonenumbermanagements() {
		return $this->hasMany('Modules\ProvVoip\Entities\PhonenumberManagement', 'enviacontract_id');
	}

	/**
	 * Link to phonenumbers
	 */
	public function phonenumbers() {
		$phonenumbers = [];
		foreach ($this->phonenumbermanagements as $mgmt) {
			array_push($phonenumbers, $mgmt->phonenumber);
		}
		return collect($phonenumbers);
		/* return $this->hasManyThrough('Modules\ProvVoip\Entities\Phonenumber', 'Modules\ProvVoip\Entities\PhonenumberManagement', 'enviacontract_id'); */
		/* return $this->hasManyThrough('Modules\ProvVoip\Entities\Phonenumber', 'Modules\ProvVoip\Entities\PhonenumberManagement'); */
	}

	/**
	 * Gets all phonenumbers with:
	 *		- existing phoneunmbermanagement
	 *		- activation date less or equal than today
	 *		- deactivation date null or bigger than today
	 *
	 * @author Patrick Reichel
	 */
	public function phonenumbers_active_through_phonenumbermanagent() {

		$phonenumbers = $this->phonenumbers();

		$isodate = substr(date('c'), 0, 10);

		$ret = [];
		foreach ($phonenumbers as $phonenumber) {

			$mgmt = $phonenumber->phonenumbermanagement;

			// activation date not set
			if (is_null($mgmt->activation_date)) {
				continue;
			}

			// not yet activated
			if ($mgmt->activation_date > $isodate) {
				continue;
			}

			// deactivation date set and today or in the past
			if (
				(!is_null($mgmt->deactivation_date))
				&&
				($mgmt->deactivation_date <= $isodate)
			) {
				continue;
			}

			// number seems to be active
			array_push($ret, $phonenumber);
		}

		return $ret;
	}


	/**
	 * Build an array containing all relations of this contract for edit view
	 *
	 * @author Patrick Reichel
	 */
	public function get_relation_information() {

		$relations = array();
		$relations['head'] = "";
		$relations['hints'] = array();
		$relations['links'] = array();

		if ($this->contract) {
			$relations['hints']['Contract'] = ProvVoipEnviaHelpers::get_user_action_information_contract($this->contract);
		}

		if ($this->modem) {
			$relations['hints']['Modem'] = ProvVoipEnviaHelpers::get_user_action_information_modem($this->modem);
		}

		$mgmts = $this->phonenumbermanagements;
		if ($mgmts) {
			$phonenumbers = [];
			foreach ($mgmts as $mgmt) {
				array_push($phonenumbers, $mgmt->phonenumber);
			}
			$this->phonenumbers = collect($phonenumbers);
			$relations['hints']['Phonenumbers'] = ProvVoipEnviaHelpers::get_user_action_information_phonenumbers($this, $this->phonenumbers);
		}

		if ($this->enviaorders) {
			$relations['hints']['Envia orders'] = ProvVoipEnviaHelpers::get_user_action_information_enviaorders($this->enviaorders->sortBy('orderdate'));
		}

		return $relations;

	}

}
