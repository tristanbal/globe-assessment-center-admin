<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreateCompetenciesTable extends Migration
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
        Schema::create('competencies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('clusterID');
            $table->unsignedInteger('subclusterID');
            $table->unsignedInteger('talentSegmentID');
            $table->integer('maximumLevelID');
            $table->integer('minimumLevelID');
            $table->string('definition', 10000);

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('clusterID')->references('id')->on('clusters')->onDelete('cascade');
            $table->foreign('subclusterID')->references('id')->on('subclusters')->onDelete('cascade');
            $table->foreign('talentSegmentID')->references('id')->on('talent_segments')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competencies');
    }
}
