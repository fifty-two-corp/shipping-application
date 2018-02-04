<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToVendorCostTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('vendor_cost', function(Blueprint $table)
		{
			$table->foreign('vendor_id', 'vendor_cost_ibfk_1')->references('id')->on('vendor')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('customer_id', 'vendor_cost_ibfk_2')->references('id')->on('customer')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('vendor_cost', function(Blueprint $table)
		{
			$table->dropForeign('vendor_cost_ibfk_1');
			$table->dropForeign('vendor_cost_ibfk_2');
		});
	}

}
