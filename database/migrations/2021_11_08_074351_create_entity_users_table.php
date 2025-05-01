<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntityUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entity_users', function (Blueprint $table) {

            $table->bigInteger('user_id')->unsigned()->nullable(false);
            $table->bigInteger('entity_id')->unsigned()->nullable(false);
            $table->string('entity_access', 200)->collation('utf8mb4_unicode_ci')->nullable(false);
            $table->foreign('entity_id', 'eeuid')->references('id')->on('entities')->onDelete('cascade');;
            $table->foreign('user_id', 'uid')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entity_users');
    }
}
