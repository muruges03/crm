<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadPipelineStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_pipeline_stages', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned()->nullable(false)->index();
            $table->bigInteger('entity_id')->unsigned()->nullable(false);
            $table->string('code', 250)->nullable(false);
            $table->string('lead_stage', 200)->nullable(false);
            $table->tinyInteger('probability')->nullable(false)->default(0);
            $table->tinyInteger('sort_order')->nullable(false)->default(0);
            $table->dateTime('created')->nullable(false);
            $table->unsignedBigInteger('created_by')->nullable(false);
            $table->dateTime('modified')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->unsignedTinyInteger('status')->nullable(false)->default('1');
            $table->unsignedTinyInteger('displayed')->nullable(false)->default('1');
            $table->unsignedTinyInteger('deleted')->nullable(false)->default('0');


            $table->foreign('entity_id', 'lpseid')->references('id')->on('entities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lead_pipeline_stages');
    }
}
