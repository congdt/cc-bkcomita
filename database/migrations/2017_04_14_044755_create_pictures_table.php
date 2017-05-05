<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePicturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if(!Schema::hasTable("pictures")){
			Schema::create('pictures', function (Blueprint $table) {
				//
				$table->increments("id");
				$table->string("description", 1024)->nullable();
				$table->integer("privilege");
				$table->string("filePath");
				$table->integer("album_id")->unsigned();
				$table->integer("user_id")->unsigned();
				$table->foreign("album_id")->references("id")->on("albums");
				$table->foreign("user_id")->references("id")->on("users");
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
        //Schema::table('pictures', function (Blueprint $table) {
            //
        //});
		Schema::dropIfExists("pictures");
    }
}
