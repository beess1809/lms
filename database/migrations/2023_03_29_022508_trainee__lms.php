<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TraineeLms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainee_modules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('employee_uuid');
            $table->bigInteger('module_id');
            $table->bigInteger('point')->nullable();
            $table->bigInteger('is_passed');

            $table->dateTime('finished_at');
            $table->dateTime('created_at');
            $table->uuid('created_by');
            $table->dateTime('updated_at')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->uuid('deleted_by')->nullable();
        });

        Schema::create('trainee_trainings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('training_id');
            $table->uuid('employee_uuid');
            $table->bigInteger('point')->nullable();
            $table->bigInteger('is_passed');

            $table->dateTime('finished_at');
            $table->dateTime('created_at');
            $table->uuid('created_by');
            $table->dateTime('updated_at')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->uuid('deleted_by')->nullable();
        });

        Schema::create('trainee_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('employee_uuid');
            $table->bigInteger('training_sub_id');
            $table->json('answer_id');
            $table->bigInteger('correct')->nullable();
            $table->bigInteger('wrong')->nullable();
            $table->bigInteger('score')->nullable();
            $table->bigInteger('point')->nullable();
            $table->bigInteger('is_passed');

            $table->dateTime('created_at');
            $table->uuid('created_by');
            $table->dateTime('updated_at')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->uuid('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trainee_modules');
        Schema::dropIfExists('trainee_trainings');
        Schema::dropIfExists('trainee_answers');
    }
}
