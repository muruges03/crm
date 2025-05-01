<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPersonnelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_personnels', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->nullable(false);
            $table->bigInteger('personnel_id')->unsigned()->nullable(false);
            // $table->string('entity_access', 200)->collation('utf8mb4_unicode_ci')->nullable(false);
            $table->foreign('personnel_id', 'pupid')->references('id')->on('personnels')->onDelete('cascade');;
            $table->foreign('user_id', 'upid')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_personnels');
    }
}
