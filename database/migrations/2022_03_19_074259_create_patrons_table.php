<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatronsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patrons', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned()->nullable(false)->index();
            $table->bigInteger('entity_id')->unsigned()->nullable(false);
            $table->string('patron_type', 200)->collation('utf8mb4_unicode_ci')->nullable(false)->default('Party');
            $table->string('legal_name', 200)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable(false);
            $table->string('poc_name', 200)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('poc_mobile', 45)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable()->default(null);
            $table->string('poc_alt_mobile', 45)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable()->default('NULL');
            $table->string('poc_landline', 45)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable()->default('NULL');
            $table->string('poc_email', 150)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable();
            $table->text('gstin',150)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable();
            $table->dateTime('created')->nullable(false);
            $table->unsignedBigInteger('created_by')->nullable(false);
            $table->dateTime('modified')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->unsignedTinyInteger('status')->nullable(false)->default('1');
            $table->unsignedTinyInteger('displayed')->nullable(false)->default('1');
            $table->unsignedTinyInteger('deleted')->nullable(false)->default('0');
            // $table->softDeletes();

            $table->foreign('entity_id', 'enpid')->references('id')->on('entities')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patrons');
    }
}
