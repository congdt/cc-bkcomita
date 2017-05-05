<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActiveUserTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
		DB::unprepared("
			CREATE EVENT IF NOT EXISTS checkActivation
			ON SCHEDULE 
				EVERY 2 MINUTE
			DO 
				BEGIN
					DELETE FROM epic.pendings WHERE expires < NOW();
				END
		");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
		DB::unprepared("DROP EVENT IF EXISTS checkActivation");
    }
}
