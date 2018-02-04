<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIndonesiaCitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('indonesia_cities', function(Blueprint $table)
		{
			$table->char('id', 4)->primary();
			$table->char('province_id', 2)->index('indonesia_cities_province_id_foreign');
			$table->string('name');
			$table->string('unit_price', 100)->nullable()->default('0');
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
		Schema::drop('indonesia_cities');
	}

}
