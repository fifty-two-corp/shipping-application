<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIndonesiaProvincesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('indonesia_provinces', function(Blueprint $table)
		{
			$table->char('id', 2)->primary();
			$table->string('name');
			$table->string('default_price', 50)->nullable()->default('0');
			$table->timestamps();
			$table->string('created_by')->nullable();
			$table->string('updated_by')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('indonesia_provinces');
	}

}
