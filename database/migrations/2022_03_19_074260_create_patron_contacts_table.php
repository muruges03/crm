<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatronContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patron_contacts', function (Blueprint $table) {

            $table->bigInteger('patron_id')->unsigned()->nullable(false);
            $table->bigInteger('contact_id')->unsigned()->nullable(false);
            $table->foreign('patron_id', 'patron_pcid')->references('id')->on('patrons')->onDelete('cascade');   
            $table->foreign('contact_id', 'contact_pcid')->references('id')->on('contacts')->onDelete('cascade');   

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patron_contacts');
    }
}
