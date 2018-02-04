<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVehicleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vehicle', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('plat_number', 50);
			$table->string('name')->nullable();
			$table->integer('employees_id')->nullable();
			$table->string('type')->nullable();
			$table->string('merk', 100)->default('');
			$table->string('color', 50)->nullable();
			$table->date('production_year')->nullable();
			$table->date('vehicle_tax')->nullable();
			$table->string('status', 50)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('created_by')->nullable();
			$table->integer('updated_by')->nullable();
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
		Schema::drop('vehicle');
	}

}
