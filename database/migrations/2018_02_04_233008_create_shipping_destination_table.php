<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShippingDestinationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shipping_destination', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('shipping_id');
			$table->string('consignee_name')->default('');
			$table->text('consignee_address', 65535)->nullable();
			$table->string('consignee_province')->default('');
			$table->string('consignee_city')->default('');
			$table->string('consignee_district')->nullable();
			$table->string('consignee_phone', 20)->nullable();
			$table->string('consignee_email')->nullable();
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
		Schema::drop('shipping_destination');
	}

}
