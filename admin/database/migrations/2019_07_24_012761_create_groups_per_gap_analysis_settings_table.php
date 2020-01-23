<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreateGroupsPerGapAnalysisSettingsTable extends Migration
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
        Schema::create('groups_per_gap_analysis_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 1000);
            $table->integer('selectedDataType');
            $table->integer('dataTypeID');
            $table->unsignedBigInteger('gapAnalysisSettingID');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('gapAnalysisSettingID')->references('id')->on('gap_analysis_settings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groups_per_gap_analysis_settings');
    }
}
