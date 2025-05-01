<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('person_name', 200)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('line_1', 200)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('line_2', 200)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable()->default(null);
            $table->string('city', 150)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('state_name', 150)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('zipcode', 150)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('landmark', 150)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable()->default(null);
            $table->enum('contact_type', ['Default','Office','Billing', 'Home'])->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable()->default('Default');
            $table->string('tag', 150)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable()->default(null);
            $table->string('email', 150)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable()->default(null);
            $table->string('mobile', 45)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('alt_mobile', 45)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable()->default('NULL');   // not required
            $table->string('land_line', 45)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable()->default('NULL');   //not required
            $table->string('relation_type', 200)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable()->default('NULL'); // not required
            $table->string('secondary_address', 255)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable()->default('NULL'); // not required
            $table->string('secondary_contact_name', 200)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable()->default('NULL'); // not required
            $table->string('secondary_email', 200)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable()->default('NULL'); // not required
            $table->string('secondary_phone', 45)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable()->default('NULL'); // not required
            $table->dateTime('created')->nullable(false);
            $table->unsignedBigInteger('created_by')->nullable(false);
            $table->dateTime('modified')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->unsignedTinyInteger('status')->nullable(false)->default('1');
            $table->unsignedTinyInteger('displayed')->nullable(false)->default('1');
            $table->unsignedTinyInteger('deleted')->nullable(false)->default('0');
            // $table->softDeletes();

            $table->bigInteger('entity_id')->unsigned()->nullable(false);
            $table->foreign('entity_id', 'eid')->references('id')->on('entities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
