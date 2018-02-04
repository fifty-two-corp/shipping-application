<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShippingVehicleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shipping_vehicle', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('shipping_id')->nullable();
			$table->integer('vehicle_id')->nullable();
			$table->string('vehicle_plat_number', 10)->nullable();
			$table->string('vehicle_name')->nullable();
			$table->string('vehicle_driver')->nullable();
			$table->string('vehicle_type')->nullable();
			$table->string('vehicle_merk')->nullable();
			$table->string('vehicle_color')->nullable();
			$table->date('vehicle_production_year')->nullable();
			$table->date('vehicle_tax')->nullable();
			$table->string('vehicle_status')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->string('created_by')->nullable();
			$table->string('updated_by')->nullable();
			$table->string('deleted_by')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('shipping_vehicle');
	}

}
