<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceTaxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_tax', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tax_id')->unsigned()->nullable();
            $table->bigInteger('invoice_id')->unsigned();
            $table->bigInteger('account_id')->unsigned()->nullable(); 
            $table->bigInteger('entity_id')->unsigned();
            $table->string('name')->nullable();       
            $table->decimal('amount', 17, 2)->default(0.00);

            $table->dateTime('created');
            $table->unsignedBigInteger('created_by');
            $table->dateTime('modified')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->unsignedTinyInteger('status')->default('1');
            $table->unsignedTinyInteger('displayed')->default('1');
            $table->unsignedTinyInteger('deleted')->default('0');

            $table->foreign('tax_id')->references('id')->on('taxes')->onDelete('cascade');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
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
        Schema::dropIfExists('invoice_tax');
    }
}
