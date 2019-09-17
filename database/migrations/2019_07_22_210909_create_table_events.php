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
            $table->string('code')->unique();
            $table->datetime('start_time');
            $table->datetime('end_time');
            $table->string('location');
            $table->text('description');
            $table->string('img')->nullable();
            $table->double('value')->default(10);
            $table->bigInteger('user_id')->unsigned();
            
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
