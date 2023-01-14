<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_lists', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->index('fk_schedule_lists_user_id_users_id');
            $table->date('schedule_date');
            $table->integer('doctor')->unsigned();
            $table->integer('service')->unsigned();
            $table->enum('status',[0,1,2]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedule_lists');
    }
}
