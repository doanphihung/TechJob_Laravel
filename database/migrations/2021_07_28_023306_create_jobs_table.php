<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedbigInteger('from_salary');
            $table->unsignedbigInteger('to_salary');
            $table->string('experience');
            $table->string('expire');
            $table->string('description');
            $table->string('type_of_job');
            $table->string('position');
            $table->unsignedbigInteger('view');
            $table->unsignedbigInteger('upto');
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
        Schema::dropIfExists('jobs');
    }
}
