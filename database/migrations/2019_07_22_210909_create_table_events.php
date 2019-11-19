<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('type');
            $table->string('category')->default('teste');
            $table->string('title');
            $table->string('code');
            $table->datetime('start_time');
            $table->datetime('end_time');
            $table->string('location');
            $table->text('description');
            $table->string('recurrence')->default('none'); // daily/weekly/monthly/none
            $table->string('img')->nullable();
            $table->double('value')->default(10);
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('event_id')->unsigned()->nullable()->default(null);

            $table->foreign('event_id')
                ->references('id')->on('events')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

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
        Schema::dropIfExists('events');
    }
}
