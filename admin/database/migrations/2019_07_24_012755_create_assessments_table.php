<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('employeeID');
            $table->integer('evaluationVersionID');
            $table->unsignedInteger('assessmentTypeID');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('employeeID')->references('id')->on('employee_datas')->onDelete('cascade');
            //$table->foreign('evaluationVersionID')->references('id')->on('evaluations')->onDelete('cascade');
            $table->foreign('assessmentTypeID')->references('id')->on('assessment_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assessments');
    }
}
