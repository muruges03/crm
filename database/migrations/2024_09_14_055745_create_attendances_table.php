<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->time('clock_in')->nullable(); // Time when the user clocks in
            $table->time('clock_out')->nullable(); // Time when the user clocks out
            $table->dateTime('created');
            $table->unsignedBigInteger('created_by');
            $table->unsignedTinyInteger('status')->default('1');
            $table->dateTime('modified')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->dateTime('deleted')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->unsignedTinyInteger('deleted')->default('0');
            $table->unique(['user_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendances');
    }
}
