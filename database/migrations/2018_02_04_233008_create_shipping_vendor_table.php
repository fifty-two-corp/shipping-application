<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShippingVendorTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shipping_vendor', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('shipping_id');
			$table->integer('vendor_id');
			$table->string('vendor_number', 50)->nullable();
			$table->string('vendor_name')->nullable();
			$table->text('vendor_address', 65535)->nullable();
			$table->string('vendor_province', 200)->nullable();
			$table->string('vendor_city', 200)->nullable();
			$table->string('vendor_district', 200)->nullable();
			$table->string('vendor_phone', 20)->nullable();
			$table->string('vendor_email', 200)->nullable();
			$table->string('vendor_type')->nullable();
			$table->decimal('vendor_cost', 10, 0)->nullable();
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
		Schema::drop('shipping_vendor');
	}

}
