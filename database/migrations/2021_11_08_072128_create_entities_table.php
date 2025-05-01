<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entities', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned()->nullable(false)->index();
            $table->enum('entity_type',['Organization','Company'])->collation('utf8mb4_unicode_ci')->nullable(false)->default('Organization');
            $table->string('parent_id', 200)->collation('utf8mb4_unicode_ci')->nullable(false)->default(null);
            $table->string('legal_name', 50)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->unique()->nullable(false);
            $table->string('alias', 100)->collation('utf8mb4_unicode_ci')->nullable(false);
            $table->text('description')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->text('gstin',150)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('url', 150)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable()->default(null);
            $table->string('logo_file', 150)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable()->default(null);
            $table->string('time_zone', 100)->collation('utf8mb4_unicode_ci')->default('Asia/Kolkata');
            $table->string('api_key', 150)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable(false);
            $table->dateTime('created')->nullable(false);
            $table->unsignedBigInteger('created_by')->nullable(false);
            $table->dateTime('modified')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->unsignedTinyInteger('status')->nullable(false)->default('1');
            $table->unsignedTinyInteger('displayed')->nullable(false)->default('1');
            $table->unsignedTinyInteger('deleted')->nullable(false)->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entities');
    }
}
