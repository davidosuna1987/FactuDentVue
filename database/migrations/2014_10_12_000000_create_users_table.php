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
            $table->increments('id');
            $table->string('name');
            $table->string('surnames');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('nif')->nullable();
            $table->string('nickname')->unique()->nullable();
            $table->string('address')->nullable();
            $table->string('locality')->nullable();
            $table->string('province')->nullable();
            $table->string('country')->nullable();
            $table->string('post_code')->nullable();
            $table->string('password');
            $table->integer('default_percentage')->default(50);
            $table->integer('default_retention')->default(15);
            $table->boolean('login_provider')->nullable();
            $table->string('pdf_color')->nullable()->default('#00d1b2');
            $table->boolean('show_logo')->default(true);
            $table->boolean('show_advertising')->default(true);
            $table->string('custom_logo')->nullable();
            $table->string('custom_logo_filename')->nullable();
            $table->string('api_key', 60)->unique();
            $table->integer('role_id')->unsigned();
            $table->boolean('active')->default(false);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            // $table->foreign('role_id')->references('id')->on('roles');

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
