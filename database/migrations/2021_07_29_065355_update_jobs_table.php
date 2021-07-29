<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->unsignedbigInteger('from_salary')->nullable()->change();
            $table->unsignedbigInteger('to_salary')->nullable()->change();
            $table->string('experience')->nullable()->change();
            $table->string('expire')->nullable()->change();
            $table->string('description')->nullable()->change();
            $table->string('type_of_job')->nullable()->change();
            $table->string('position')->nullable()->change();
            $table->unsignedbigInteger('view')->nullable()->change();
            $table->unsignedbigInteger('upto')->nullable()->change();
            $table->unsignedBigInteger('city_id')->nullable()->change();
            $table->unsignedBigInteger('category_id')->nullable()->change();



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jobs', function (Blueprint $table) {
            //
        });
    }
}
