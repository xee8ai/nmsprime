<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContractTable extends BaseMigration {

	// name of the table to create
	protected $tablename = "contract";


	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create($this->tablename, function(Blueprint $table)
		{
			$this->up_table_generic($table);

			$table->integer('number')->unsigned();
			$table->string('customer_number', 60);
			$table->string('customer_external_id', 60)->nullable()->default(NULL);
			$table->string('contract_number', 60);
			$table->string('contract_external_id', 60)->nullable()->default(NULL);
			$table->dateTime('contract_ext_creation_date')->nullable()->default(NULL);
			$table->dateTime('contract_ext_termination_date')->nullable()->default(NULL);
			$table->string('contract_ext_order_id')->default(NULL);
			$table->string('number2', 32);
			$table->string('company');
			$table->enum('salutation', ['Herrn', 'Frau', 'Firma', 'Behörde']);
			$table->enum('academic_degree', ['', 'Dr.', 'Prof. Dr.']);
			$table->string('firstname');
			$table->string('lastname');
			$table->string('street');
			$table->string('house_number', 8);
			$table->string('zip', 16);
			$table->string('city');
			$table->integer('country_id')->unsigned();
			$table->float('x');
			$table->float('y');
			$table->string('phone', 100);
			$table->string('fax', 100);
			$table->string('email');
			$table->date('birthday');
			$table->date('contract_start')->nullable()->default(NULL);
			$table->date('contract_end')->nullable()->default(NULL);
			$table->boolean('internet_access');
			$table->boolean('phonebook_entry');
			$table->integer('qos_id')->unsigned();
			$table->integer('next_qos_id')->unsigned();
			$table->integer('voip_id')->unsigned();
			$table->integer('next_voip_id')->unsigned();
			$table->string('sepa_iban', 34);
			$table->string('sepa_bic', 11);
			$table->string('sepa_holder');
			$table->string('sepa_institute');
			$table->boolean('create_invoice');
			$table->string('login', 32);
			$table->string('password', 32);
			$table->integer('net');
			$table->integer('cluster');
			$table->text('description');
		});

		$this->set_fim_fields(['number2', 'company', 'firstname', 'lastname', 'street', 'zip', 'city', 'phone', 'fax', 'email', 'description', 'sepa_iban']);
		$this->set_auto_increment(500000);
		
		return parent::up();
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop($this->tablename);
	}

}
