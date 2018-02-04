<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTerminPaymentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('termin_payment', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('shipping_id')->nullable();
			$table->decimal('payment', 10, 0)->nullable();
			$table->date('payment_date')->nullable();
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
		Schema::drop('termin_payment');
	}

}
