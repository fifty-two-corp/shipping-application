<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCustomerCostTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('customer_cost', function(Blueprint $table)
		{
			$table->foreign('customer_id', 'customer_cost_ibfk_1')->references('id')->on('customer')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('customer_cost', function(Blueprint $table)
		{
			$table->dropForeign('customer_cost_ibfk_1');
		});
	}

}
