<?php namespace Modules\Provbase\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Log;

use Modules\ProvBase\Entities\Contract;
use Modules\ProvBase\Entities\Modem;
use Modules\ProvBase\Entities\Qos;
use Modules\ProvBase\Entities\Configfile;

use Modules\BillingBase\Entities\Item;
use Modules\BillingBase\Entities\Product;
use Modules\BillingBase\Entities\SepaMandate;

use Modules\ProvVoip\Entities\Mta;
use Modules\ProvVoip\Entities\Phonenumber;

use Modules\Mail\Entities\Email;

class importOrder extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'nms:import-order';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Extract last number from street (and encode dependent of andre schuberts encoding mechanism)
	 */
	public static function split_street_housenr($string, $utf8_encode = false)
	{
		preg_match('/(\d+)(?!.*\d)/', $string, $matches);
		$matches = $matches ? $matches[0] : '';

		if (!$matches)
		{
			$street = $utf8_encode ? utf8_encode($string) : $string;
			return [$street, null];
		}

		$x 		 = strpos($string, $matches);
		$housenr = substr($string, $x);

		if (strlen($housenr) > 6) {
			$street  = str_replace($matches, '', $string);
			$housenr = $matches;
		}
		else
			$street = trim(substr($string, 0, $x));

		$street = $utf8_encode ? utf8_encode($street) : $street;
		// $street = mb_convert_encoding(trim(substr($string, 0, $x)), 'iso-8859-1', 'ascii');
		// var_dump(mb_detect_encoding ($street), $street);

		return [$street, $housenr];
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$dir = 'import-mails';
		$files = glob($dir.'/*.{eml,txt,html}', GLOB_BRACE);;

		foreach($files as $file)
		{
			$htmlContent = file_get_contents($file);
			$this->line ('FILE: '.$dir.'/'.$file);

			$DOM = new \DOMDocument();
			$DOM->recover = true;
			$DOM->strictErrorChecking = false;
			libxml_use_internal_errors(true);
			$DOM->loadHTML($htmlContent);

			$Detail = $DOM->getElementsByTagName('td');

			$a = null;
			foreach($Detail as $NodeDetail)
			{
				$a[] = trim($NodeDetail->textContent);
			}
			// print_r($a); die();


		// PARSE
			$name = explode(' ', $a[5]);
			$firstname = $name[0];
			$lastname = $name[1];
			$zip  = explode (' - ', $a[7])[0];
			$city  = explode (' - ', $a[7])[1];
			$street  = $a[9];
			$birthday  = date('Y-m-d', strtotime($a[11]));
			$email = $a[13];
			$tel  = $a[15];
			$start = $a[17];
			$modem = $a[19];
			$tarif = $a[21];
			$tariftel   = $a[23];
			$sepa  = $a[25];
			$sepa_name = $a[27];
			$desc = '';


		// CONTRACT
			$c = new Contract;

			$c->firstname 		= $firstname;
			$c->lastname 		= $lastname;

			$ret = self::split_street_housenr($street);
			$c->street 			= $ret[0];
			$c->house_number 	= $ret[1];

			$c->zip 			= $zip;
			$c->city 			= $city;
			$c->phone 			= $tel;
			$c->email 			= $email;
			$c->birthday 		= $birthday;

			$c->network_access 	= 1;
			$c->contract_start 	= ($start == 'schnellstmöglich' ? date('Y-m-d') : $start);

			$c->costcenter_id   = 3; // ERZNET
			$c->number = \Modules\BillingBase\Entities\NumberRange::get_new_number('contract', $c->costcenter_id);

			$c->save();
			$this->line ("\nADD CONTRACT: $c->id, $c->firstname $c->lastname, $c->street, $c->zip, $c->city");


		// SEPA
			SepaMandate::create([
				'contract_id' 		=> $c->id,
				'sepa_holder' 		=> $sepa_name,
				'sepa_iban'			=> $sepa,
			]);
			$this->line ("\nADD SEPA: $sepa");


		// ITEM INTERNET
			$product = null;
			if (strpos($tarif, '6') !== false)
				$product = 2;
			if (strpos($tarif, '25') !== false)
				$product = 4;
			if (strpos($tarif, '100') !== false)
				$product = 5;

			if ($product)
			{
				Item::create([
					'contract_id' 		=> $c->id,
					'product_id' 		=> $product,
					'count' 			=> 1,
					'valid_from' 		=> date('Y-m-d'),
					'valid_from_fixed' 	=> 1
				]);
				$this->line ("\nADD ITEM: $tarif");
			}

		// ITEM TEL
			$producttel = null;
			if (strpos($tariftel, 'Basic') !== false)
				$producttel = 6;
			if (strpos($tariftel, 'Flat') !== false)
				$producttel = 7;

			if ($producttel)
			{
				Item::create([
					'contract_id' 		=> $c->id,
					'product_id' 		=> $producttel,
					'count' 			=> 1,
					'valid_from' 		=> date('Y-m-d'),
					'valid_from_fixed' 	=> 1
				]);
				$this->line ("\nADD ITEM: $tariftel");
			}
	}

}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			// ['example', InputArgument::REQUIRED, 'An example argument.'],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			// ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
		];
	}

}
