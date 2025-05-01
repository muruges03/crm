<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('id');
            $table->bigInteger('entity_id')->unsigned()->nullable(false);
            $table->string('name', 240);
            $table->string('code', 150)->nullable(true);
            $table->text('description')->nullable(true);
            $table->decimal('sale_price', 17, 2)->default(0.0000)->nullable(true);
            $table->decimal('purchase_price', 17, 2)->default(0.0000)->nullable(true);
            $table->integer('quantity')->default('1')->nullable();
            $table->integer('category_id')->nullable(true);
            $table->bigInteger('tax_id')->unsigned()->nullable(true);
            $table->dateTime('created')->nullable(false);
            $table->unsignedBigInteger('created_by')->nullable(false);
            $table->dateTime('modified')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->unsignedTinyInteger('deleted')->nullable(false)->default('0');

            $table->foreign('entity_id', 'eprid')->references('id')->on('entities')->onDelete('cascade');
            $table->foreign('tax_id', 'tprid')->references('id')->on('taxes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
