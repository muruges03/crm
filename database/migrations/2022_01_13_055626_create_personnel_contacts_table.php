<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonnelContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personnel_contacts', function (Blueprint $table) {
            $table->bigInteger('contact_id')->unsigned()->nullable(false);
            $table->bigInteger('personnel_id')->unsigned()->nullable(false);
       
            $table->foreign('personnel_id', 'pcpid')->references('id')->on('personnels')->onDelete('cascade');;
            $table->foreign('contact_id', 'pcid')->references('id')->on('contacts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personnel_contacts');
    }
}
