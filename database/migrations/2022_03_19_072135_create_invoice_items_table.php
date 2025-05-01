<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id('id');
            $table->bigInteger('entity_id')->unsigned()->nullable(false);
            $table->bigInteger('invoice_id')->unsigned()->nullable(false);
            $table->bigInteger('product_id')->unsigned()->nullable(false);
            $table->decimal('quantity', 17, 2)->default(0.0000);
            $table->decimal('price', 17, 2)->default(0.0000);
            $table->bigInteger('tax_id')->unsigned()->nullable(true);
            $table->string('discount_type', 100);
            $table->text('description')->nullable(true);
            $table->decimal('tax_amount', 17, 2)->default(0.0000);
            $table->decimal('discount_amount', 17, 2)->default(0.0000);
            $table->decimal('total_amount', 17, 2)->default(0.0000);
            $table->dateTime('created')->nullable(false);
            $table->unsignedBigInteger('created_by')->nullable(false);
            $table->dateTime('modified')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->unsignedTinyInteger('deleted')->nullable(false)->default('0');

            $table->foreign('entity_id', 'einitid')->references('id')->on('entities')->onDelete('cascade');
            $table->foreign('tax_id', 'tinitid')->references('id')->on('taxes')->onDelete('cascade');
            $table->foreign('invoice_id', 'iinitid')->references('id')->on('invoices')->onDelete('cascade');
            $table->foreign('product_id', 'pinitid')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_items');
    }
}
