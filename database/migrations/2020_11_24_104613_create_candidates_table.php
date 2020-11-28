<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uid', 70)->unique();
            $table->string('name', 100);
            $table->tinyInteger('status');
            $table->string('photo')->nullable();
            $table->string('email', 90)->nullable();
            $table->string('mobile', 15)->nullable();
            $table->string('misc', 70)->nullable();
            $table->string('misc1', 70)->nullable();
            $table->string('misc2', 70)->nullable();
            $table->string('misc3', 70)->nullable();
            $table->string('misc4', 70)->nullable();
            $table->foreignId('poll_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('candidates');
    }
}
