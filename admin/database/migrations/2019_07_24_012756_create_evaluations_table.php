<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreateEvaluationsTable extends Migration
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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('assessmentID');
            $table->unsignedInteger('assesseeEmployeeID');
            $table->unsignedInteger('assessorEmployeeID');
            $table->unsignedInteger('assesseeRoleID');
            $table->unsignedInteger('assessorRoleID');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('assessmentID')->references('id')->on('assessments')->onDelete('cascade');
            $table->foreign('assesseeEmployeeID')->references('id')->on('employee_datas')->onDelete('cascade');
            $table->foreign('assessorEmployeeID')->references('id')->on('employee_datas')->onDelete('cascade');
            $table->foreign('assesseeRoleID')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('assessorRoleID')->references('id')->on('roles')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluations');
    }
}
