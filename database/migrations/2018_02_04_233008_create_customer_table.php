<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customer', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('customer_number', 50)->nullable();
			$table->string('name')->nullable();
			$table->text('address', 65535)->nullable();
			$table->integer('province_id')->nullable();
			$table->integer('city_id')->nullable();
			$table->integer('districts_id')->nullable();
			$table->string('phone', 50)->nullable();
			$table->string('npwp', 50)->nullable();
			$table->decimal('discount', 10, 0)->default(0);
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
		Schema::drop('customer');
	}

}
