<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if(!Schema::hasTable("comments")){
			Schema::create('comments', function (Blueprint $table) {
				$table->increments('id');
				$table->integer("picture_id")->unsigned();
				$table->integer("user_id")->unsigned();
				//$table->string("user_name");
				$table->string("content", 1024);
				$table->timestamps();
				$table->foreign("picture_id")->references("id")->on("pictures");
				$table->foreign("user_id")->references("id")->on("users");
				
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
        Schema::dropIfExists('comments');
    }
}
