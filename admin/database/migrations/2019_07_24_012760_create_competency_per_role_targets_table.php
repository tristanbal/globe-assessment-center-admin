<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreateCompetencyPerRoleTargetsTable extends Migration
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
        Schema::create('competency_per_role_targets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('roleID');
            $table->unsignedInteger('competencyID');
            $table->unsignedInteger('competencyTargetID');
            $table->unsignedBigInteger('sourceID');
            $table->softDeletes();
            $table->timestamps();
            
            $table->foreign('roleID')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('competencyID')->references('id')->on('competencies')->onDelete('cascade');
            $table->foreign('competencyTargetID')->references('id')->on('levels')->onDelete('cascade');
            $table->foreign('sourceID')->references('id')->on('target_sources')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competency_per_role_targets');
    }
}
