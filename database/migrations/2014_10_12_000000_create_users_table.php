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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->date('birthday')->nullable();
            $table->year('admission')->nullable();
            $table->string('position')->nullable();
            $table->string('sector')->nullable();
            $table->string('education')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->string('university')->nullable();
            $table->string('profile_picture')->nullable();
            $table->double('wallet')->default(0)->nullable();
            $table->boolean('first_access')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
