<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreateInterventionsTable extends Migration
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
        Schema::create('interventions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('groupID');
            $table->unsignedInteger('divisionID');
            $table->unsignedInteger('competencyID');
            $table->unsignedInteger('trainingID');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('groupID')->references('id')->on('groups')->onDelete('cascade');
            $table->foreign('divisionID')->references('id')->on('divisions')->onDelete('cascade');
            $table->foreign('competencyID')->references('id')->on('competencies')->onDelete('cascade');
            $table->foreign('trainingID')->references('id')->on('trainings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interventions');
    }
}
