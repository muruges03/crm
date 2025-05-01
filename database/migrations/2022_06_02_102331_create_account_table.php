<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('invoice_id')->unsigned();           
            $table->bigInteger('patron_id')->unsigned(); 
            $table->bigInteger('entity_id')->unsigned();
            $table->decimal('untaxed_amount', 17, 2)->default(0.00);
            $table->decimal('total_amount', 17, 2)->default(0.00); 
            $table->datetime('paid_date');
            $table->dateTime('created');
            $table->unsignedBigInteger('created_by');
            $table->unsignedTinyInteger('status')->default('1');
            $table->dateTime('modified')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->unsignedTinyInteger('deleted')->default('0');           
            
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            $table->foreign('patron_id')->references('id')->on('patrons')->onDelete('cascade');
            $table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account');
    }
}
