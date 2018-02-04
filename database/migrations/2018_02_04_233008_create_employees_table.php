<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmployeesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('employees', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('employees_number', 50)->nullable()->unique('employess_number');
			$table->string('name', 100)->default('');
			$table->string('address')->nullable();
			$table->integer('province_id')->nullable();
			$table->integer('city_id')->nullable();
			$table->integer('districts_id')->nullable();
			$table->string('phone', 50)->nullable();
			$table->integer('identity_method_id')->nullable();
			$table->string('identity_number', 50)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->string('created_by')->nullable();
			$table->string('updated_by')->nullable();
			$table->integer('deleted_by')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('employees');
	}

}
