<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    /* 
    status
    event_id
    user_id
    rate
    confirm_status
    interest_status
     */
     public function up()
    {
        Schema::create('participations', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            $table->boolean('status')->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('event_id')->unsigned();
            $table->integer('rate')->nullable();
            $table->boolean('confirm_status')->nullable();
            $table->boolean('interest_status')->nullable();

            // Relações 
            $table->foreign('event_id')
                ->references('id')->on('events')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participations');
    }
}
