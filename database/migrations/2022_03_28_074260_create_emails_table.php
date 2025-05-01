<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {            
            $table->bigIncrements('id')->unsigned()->nullable(false)->index();
            $table->bigInteger('entity_id')->unsigned()->nullable(false);
            $table->enum('type',['Yearly','Monthly'])->default('Monthly')->nullable(false);
            $table->text('name')->nullable(false);
            $table->string('subject', 150)->nullable(false);
            $table->text('notes')->nullable(false);
            $table->text('team_condition')->nullable(false);
            $table->dateTime('created')->nullable(false);
            $table->unsignedBigInteger('created_by')->nullable(false);
            $table->dateTime('modified')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            
            $table->foreign('entity_id', 'eneid')->references('id')->on('entities')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emails');
    }
}
