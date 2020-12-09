<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uid')->unique();
            $table->string('title', 100);
            $table->string('short_title', 20);
            $table->tinyInteger('status');
            $table->tinyInteger('type');
            $table->tinyInteger('max_candidate')->nullable();
            $table->foreignId('candidate_id')->constrained()->nullable();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->string('misc')->nullable();
            $table->string('misc1')->nullable();
            $table->string('misc2')->nullable();
            $table->string('misc3')->nullable();
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
        Schema::dropIfExists('polls');
    }
}
