<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntityContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entity_contacts', function (Blueprint $table) {

            $table->bigInteger('entity_id')->unsigned()->nullable(false);
            $table->bigInteger('contact_id')->unsigned()->nullable(false);
            $table->foreign('entity_id', 'entyid')->references('id')->on('entities')->onDelete('cascade');
            $table->foreign('contact_id', 'contid')->references('id')->on('contacts')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations. php artisan vendor:publish --tag=reliese-models

     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entity_contacts');
    }
}
