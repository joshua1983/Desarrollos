<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Oraciones extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('oraciones', function($table){
			$table->bigIncrements("id");
			$table->string("categoria");
			$table->string("titulo");
			$table->string("oracion");
		});

		Schema::table('oraciones', function(Blueprint $table)
		{
			//
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('oraciones', function(Blueprint $table)
		{
			//
		});
	}

}
