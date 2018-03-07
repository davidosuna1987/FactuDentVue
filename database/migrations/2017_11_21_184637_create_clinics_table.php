<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClinicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinics', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->string('name');
            $table->string('contact');
            $table->string('email');
            $table->string('nif');
            $table->string('address');
            $table->string('locality');
            $table->string('province');
            $table->string('country');
            $table->string('post_code');
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->integer('percentage')->unsigned()->default(50);
            $table->boolean('active')->default(true); //Campo que se usará para mostrar o no la clínica en los listados

            // $table->foreign('user_id')->references('id')->on('users');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clinics');
    }
}
