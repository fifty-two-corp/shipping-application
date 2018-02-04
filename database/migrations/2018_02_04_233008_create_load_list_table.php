<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLoadListTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('load_list', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('shipping_id');
			$table->string('item')->nullable();
			$table->string('quantity', 20)->nullable();
			$table->string('dimension', 100)->nullable();
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
		Schema::drop('load_list');
	}

}
