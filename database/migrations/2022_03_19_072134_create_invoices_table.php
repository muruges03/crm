<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id('id');
            $table->bigInteger('entity_id')->unsigned()->nullable(false);
            $table->string('type', 100)->nullable(true);
            $table->string('start_date', 100)->nullable(true);
            $table->string('end_date', 100)->nullable(true);
            $table->string('prefix', 150)->nullable(true);
            $table->integer('invoice_number');
            $table->integer('order_number')->nullable(true);
            $table->boolean('paid_status')->default(false);
            $table->dateTime('invoiced_at')->nullable(false);
            $table->dateTime('due_at')->nullable(false);
            $table->decimal('untaxed_amount', 17, 2)->default(0.0000);
            $table->decimal('tax_amount', 17, 2)->default(0.0000);
            $table->decimal('total_amount', 17, 2)->default(0.0000);
            $table->decimal('discount_amount', 17, 2)->default(0.0000);
            $table->integer('category_id')->default('1');
            $table->integer('patron_id');
            $table->string('notes', 250);
            $table->integer('is_sent')->default('0');
            $table->dateTime('created')->nullable(false);
            $table->unsignedBigInteger('created_by')->nullable(false);
            $table->unsignedTinyInteger('status')->nullable(false)->default('1');
            $table->dateTime('modified')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->unsignedTinyInteger('deleted')->nullable(false)->default('0');

            $table->foreign('entity_id', 'einid')->references('id')->on('entities')->onDelete('cascade');
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
