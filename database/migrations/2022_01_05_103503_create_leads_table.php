<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            // $table->bigInteger('entity_id')->unsigned()->nullable(false)->index();
            $table->bigInteger('entity_id')->unsigned()->nullable(false);
            // $table->string('lead_type', 200)->collation('utf8mb4_unicode_ci')->nullable(false)->default('Party');
            // $table->string('legal_name', 200)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable(false);
            $table->string('lead_name', 200)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('lead_mobile', 45)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable()->default(null);
            $table->string('lead_alt_mobile', 45)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable()->default('NULL');
            $table->string('lead_landline', 45)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable()->default('NULL');
            $table->string('lead_email', 150)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable();
            $table->text('description')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable();
            $table->decimal('lead_value', 19, 4)->nullable(true)->default(0.0000);
            $table->integer('assigned_to')->unsigned()->nullable();
            $table->string('source', 250)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable();
            $table->dateTime('closed_at')->nullable();
            $table->integer('lead_type_id')->unsigned()->nullable(false)->index();
            $table->integer('lead_pipeline_stage_id')->unsigned()->nullable(false)->index()->default('1');
            $table->dateTime('expected_close_date')->nullable();
            $table->dateTime('created')->nullable(false);
            $table->unsignedBigInteger('created_by')->nullable(false);
            $table->dateTime('modified')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->unsignedTinyInteger('status')->nullable(false)->default('1');
            $table->unsignedTinyInteger('displayed')->nullable(false)->default('1');
            $table->unsignedTinyInteger('deleted')->nullable(false)->default('0');
            // $table->softDeletes();

            $table->foreign('entity_id', 'epid')->references('id')->on('entities')->onDelete('cascade');
            // $table->foreign('lead_type_id', 'lltid')->references('id')->on('lead_types')->onDelete('cascade');
            // $table->foreign('lead_pipeline_stage_id', 'llpsid')->references('id')->on('lead_pipeline_stages')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leads');
    }
}
