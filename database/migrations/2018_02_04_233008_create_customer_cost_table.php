<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerCostTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customer_cost', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('customer_id')->nullable()->index('customer_id');
			$table->integer('origin_provinces_id')->nullable();
			$table->integer('origin_city_id');
			$table->integer('destination_provinces_id')->nullable();
			$table->integer('destination_city_id');
			$table->decimal('cost', 10, 0)->default(0);
			$table->string('type', 200)->nullable();
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
		Schema::drop('customer_cost');
	}

}
