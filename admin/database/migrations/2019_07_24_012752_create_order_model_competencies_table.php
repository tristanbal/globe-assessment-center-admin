<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreateOrderModelCompetenciesTable extends Migration
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
        Schema::create('order_model_competencies', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('modelID');
            $table->unsignedInteger('competencyID');
            $table->unsignedInteger('competencyTypeID');
            $table->unsignedInteger('targetProficiencyID');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('modelID')->references('id')->on('order_models')->onDelete('cascade');
            $table->foreign('competencyID')->references('id')->on('competencies')->onDelete('cascade');
            $table->foreign('competencyTypeID')->references('id')->on('competency_types')->onDelete('cascade');
            $table->foreign('targetProficiencyID')->references('id')->on('levels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_model_competencies');
    }
}
