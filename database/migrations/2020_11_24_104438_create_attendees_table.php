<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->string('token', 10);
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('misc')->nullable();
            $table->string('misc1')->nullable();
            $table->string('misc2')->nullable();
            $table->string('misc3')->nullable();
            $table->string('misc4')->nullable();
            $table->string('misc5')->nullable();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->softDeletes('deleted_at', 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendees');
    }
}
