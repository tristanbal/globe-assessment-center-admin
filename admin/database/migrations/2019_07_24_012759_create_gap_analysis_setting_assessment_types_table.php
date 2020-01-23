<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreateGapAnalysisSettingAssessmentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function up()
    {
        Schema::create('gap_analysis_setting_assessment_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('gas_id_foreign');
            $table->unsignedInteger('assessmentTypeID');
            $table->integer('percentAssigned');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('gas_id_foreign')->references('id')->on('gap_analysis_settings')->onDelete('cascade');
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
        Schema::dropIfExists('gap_analysis_setting_assessment_types');
    }
}
