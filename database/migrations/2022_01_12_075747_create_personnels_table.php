<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonnelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personnels', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned()->nullable(false)->index();
            $table->bigInteger('entity_id')->unsigned()->nullable(false);
            $table->string('first_name', 200)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('last_name',200)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable();
            $table->enum('personnel_type', ['Employee', 'Customer'])->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable()->default('Employee');
            $table->enum('gender', ['Male', 'Female'])->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable();
            $table->dateTime('date_of_birth')->nullable()->default(null);
            $table->mediumtext('params', 250)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable();
            $table->dateTime('joining_date')->nullable(false);
            $table->text('notes', 250)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('aadharcard', 100)->nullable();
            $table->string('proof_document', 100)->nullable();
            $table->dateTime('created')->nullable(false);
            $table->unsignedBigInteger('created_by')->nullable(false);
            $table->dateTime('modified')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->unsignedTinyInteger('status')->nullable(false)->default('0');
            $table->unsignedTinyInteger('displayed')->nullable(false)->default('1');
            $table->unsignedTinyInteger('deleted')->nullable(false)->default('0');

            $table->foreign('entity_id', 'peid')->references('id')->on('entities')->onDelete('cascade');
            // $table->bigInteger('contact_id')->unsigned()->nullable(false);
            // $table->foreign('contact_id', 'pcid')->references('id')->on('contacts')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personnels');
    }
}
