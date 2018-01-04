<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('clinic_id')->unsigned();
            $table->string('invoice_no');
            $table->date('invoice_date')->nullable();
            $table->date('payment_date')->nullable();
            $table->integer('retention')->default(15);
            $table->decimal('sub_total', 10, 2);
            $table->decimal('total', 10, 2);

            $table->foreign('clinic_id')->references('id')->on('clinics');

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
        Schema::dropIfExists('invoices');
    }
}
