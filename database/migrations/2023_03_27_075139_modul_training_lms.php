<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModulTrainingLms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('category_id');
            $table->bigInteger('module_type_id');
            $table->string('title');
            $table->text('description');
            $table->integer('is_active');
            $table->date('expired_at')->nullable();
            $table->dateTime('created_at');
            $table->uuid('created_by');
            $table->dateTime('updated_at')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->uuid('deleted_by')->nullable();
        });

        Schema::create('trainings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('module_id');
            $table->bigInteger('parent_training')->nullable();
            $table->string('title');
            $table->text('description');
            $table->integer('is_active');
            $table->bigInteger('passing_grade')->nullable();
            $table->bigInteger('score')->nullable();
            $table->date('expired_at')->nullable();

            $table->dateTime('created_at');
            $table->uuid('created_by');
            $table->dateTime('updated_at')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->uuid('deleted_by')->nullable();
        });

        Schema::create('training_subs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('training_id');
            $table->bigInteger('training_type_id');
            $table->bigInteger('order_no')->nullable();
            $table->string('title');
            $table->string('type_file')->nullable();
            $table->string('file')->nullable();

            $table->bigInteger('point')->nullable();
            $table->bigInteger('score')->nullable();

            $table->dateTime('created_at');
            $table->uuid('created_by');
            $table->dateTime('updated_at')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->uuid('deleted_by')->nullable();
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('training_sub_id');
            $table->text('question');
            $table->json('answer');
            $table->dateTime('created_at');
            $table->bigInteger('created_by');
            $table->dateTime('updated_at')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->bigInteger('deleted_by')->nullable();
        });

        Schema::create('answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('question_id');
            $table->string('answer');
            $table->dateTime('created_at');
            $table->uuid('created_by');
            $table->dateTime('updated_at');
            $table->uuid('updated_by');
            $table->dateTime('deleted_at');
            $table->uuid('deleted_by');
        });


        Schema::create('module_employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('module_id');
            $table->uuid('employee_uuid');

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
        Schema::dropIfExists('modules');
        Schema::dropIfExists('trainings');
        Schema::dropIfExists('training_subs');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('answers');
        Schema::dropIfExists('module_employees');
    }
}
