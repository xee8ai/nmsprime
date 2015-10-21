<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use Models\Phonenumber;

# don't forget to add Seeder in DatabaseSeeder.php
class PhonenumbersTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(3, 7) as $index)
		{
			Phonenumber::create([
				'prefix_number' => "03725",
				'number' => rand(100,999999),
				'mta_id' => $index,
				'port' => 1,
				'active' => 1,
			]);
		}
	}

}
