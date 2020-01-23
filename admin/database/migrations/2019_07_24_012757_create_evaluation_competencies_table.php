<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationCompetenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluation_competencies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('evaluationID');
            $table->unsignedInteger('competencyID');
            $table->unsignedInteger('givenLevelID');
            $table->unsignedInteger('targetLevelID');
            $table->double('weightedScore');
            $table->unsignedInteger('competencyTypeID');
            $table->string('verbatim', 1000);
            $table->string('additional_file');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('evaluationID')->references('id')->on('evaluations')->onDelete('cascade');
            $table->foreign('competencyID')->references('id')->on('competencies')->onDelete('cascade');
            $table->foreign('givenLevelID')->references('id')->on('levels')->onDelete('cascade');
            $table->foreign('targetLevelID')->references('id')->on('levels')->onDelete('cascade');
            $table->foreign('competencyTypeID')->references('id')->on('competency_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluation_competencies');
    }
}
