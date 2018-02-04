<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIndonesiaDistrictsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('indonesia_districts', function(Blueprint $table)
		{
			$table->char('id', 7)->primary();
			$table->char('city_id', 4)->index('indonesia_districts_city_id_foreign');
			$table->string('name');
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
		Schema::drop('indonesia_districts');
	}

}
