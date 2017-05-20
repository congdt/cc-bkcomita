<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if(!Schema::hasTable("users") ){

			Schema::create('users', function (Blueprint $table) {
           //
				$table->increments("id");
				$table->string("name", 50);
				$table->string("password", 255);
				$table->string("email", 256);
				$table->string("avatar", 255);
				$table->string("wallpaper", 255);
				//$table->string("phone", 15);
				//$table->string("address", 100);
				$table->rememberToken();
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
        //Schema::table('users', function (Blueprint $table) {
            //
        //});
		Schema::dropIfExists("users");
    }
}
