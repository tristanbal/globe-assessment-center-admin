<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreateListOfCompetenciesPerRolesTable extends Migration
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
        Schema::create('list_of_competencies_per_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('roleID');
            $table->unsignedInteger('groupID');
            $table->unsignedInteger('competencyID');
            $table->unsignedInteger('competencyTypeID');
            $table->unsignedInteger('targetLevelID');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('roleID')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('groupID')->references('id')->on('groups')->onDelete('cascade');
            $table->foreign('competencyID')->references('id')->on('competencies')->onDelete('cascade');
            $table->foreign('competencyTypeID')->references('id')->on('competency_types')->onDelete('cascade');
            $table->foreign('targetLevelID')->references('id')->on('levels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('list_of_competencies_per_roles');
    }
}
