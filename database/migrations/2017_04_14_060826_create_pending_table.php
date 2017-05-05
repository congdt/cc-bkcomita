<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePendingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if(!Schema::hasTable('pendings')){
			Schema::create('pendings', function (Blueprint $table) {
				//$table->increments('id');
				$table->string("name", 50);
				$table->string("email", 256);
				$table->string("password", 255);
				$table->string("token")->index();
				$table->boolean("activated")->default(false);
				$table->dateTime("expires");
				$table->timestamps();
			});
			
		}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pendings');
    }
}
