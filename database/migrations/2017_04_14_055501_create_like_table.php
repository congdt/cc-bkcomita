<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLikeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if(!Schema::hasTable('likes')){
			Schema::create('likes', function (Blueprint $table) {
				$table->increments('id');
				$table->integer("picture_id")->unsigned();
				$table->integer("user_id")->unsigned();
				$table->foreign("picture_id")->references("id")->on("pictures");
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
        Schema::dropIfExists('likes');
    }
}
