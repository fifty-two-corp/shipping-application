<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShippingCustomerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shipping_customer', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('shipping_id');
			$table->integer('customer_id');
			$table->string('customer_number', 200)->nullable();
			$table->string('customer_name')->default('');
			$table->text('customer_address', 65535)->nullable();
			$table->string('customer_province')->nullable();
			$table->string('customer_city')->nullable();
			$table->string('customer_district')->nullable();
			$table->string('customer_phone', 20)->nullable();
			$table->string('customer_email')->nullable();
			$table->string('customer_npwp')->nullable();
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
		Schema::drop('shipping_customer');
	}

}
