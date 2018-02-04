<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShippingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shipping', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('transaction_number')->default('');
			$table->string('default_type')->nullable();
			$table->decimal('default_cost', 10, 0)->nullable();
			$table->string('vendor_type')->nullable();
			$table->decimal('vendor_cost', 10, 0)->nullable();
			$table->string('tax_value', 100)->nullable();
			$table->decimal('tax_cost', 65, 0)->nullable();
			$table->string('shipping_method', 100)->default('')->comment('default, vendor');
			$table->decimal('operational_cost', 10, 0)->nullable()->default(0);
			$table->decimal('cost', 65, 0);
			$table->decimal('down_payment', 10, 0)->nullable();
			$table->decimal('time_period', 11, 0)->nullable();
			$table->string('status')->default('Pending');
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
		Schema::drop('shipping');
	}

}
