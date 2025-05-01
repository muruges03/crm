<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxes', function (Blueprint $table) {
            $table->id();
            $table->text('tax_name', 100)->nullable();
            $table->enum('tax_type',['Sales', 'Purchase'])->nullable(false);
            $table->decimal('tax_amount', 17, 2)->default(0.00);
            $table->bigInteger('account_id')->unsigned()->nullable(true);
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->enum('tax_group',['GST','CGST','SGST','CST','TCS','CESS'])->nullable(false);
            $table->bigInteger('entity_id')->unsigned()->nullable(false);

            $table->dateTime('created')->nullable(false);
            $table->integer('created_by')->unsigned();
            $table->dateTime('modified')->nullable();
            $table->integer('modified_by')->unsigned()->nullable();
            $table->tinyInteger('status')->nullable(false)->default(0);
            $table->tinyInteger('visibility')->nullable(false)->default(1);
            $table->tinyInteger('deleted')->nullable(false)->default(0);

            $table->foreign('entity_id', 'tte_id')->references('id')->on('entities')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taxes');
    }
}
