<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommunityContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('community_content', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('community_id')->unsigned();
            $table->bigInteger('content_id')->unsigned();
            $table->foreign('content_id')
                ->references('id')->on('contents')
                ->onDelete('cascade');

            $table->foreign('community_id')
                ->references('id')->on('communities')
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
        Schema::dropIfExists('community_content');
    }
}
