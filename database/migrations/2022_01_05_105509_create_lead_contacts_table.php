<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_contacts', function (Blueprint $table) {
            $table->bigInteger('lead_id')->unsigned()->nullable(false);
            $table->bigInteger('contact_id')->unsigned()->nullable(false);
            $table->foreign('lead_id', 'lcid')->references('id')->on('leads')->onDelete('cascade');;
            $table->foreign('contact_id', 'lccid')->references('id')->on('contacts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lead_contacts');
    }
}
