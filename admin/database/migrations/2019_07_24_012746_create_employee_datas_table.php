<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreateEmployeeDatasTable extends Migration
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
        Schema::create('employee_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employeeID');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('middlename');
            $table->string('nameSuffix');
            $table->unsignedInteger('roleID');
            $table->unsignedInteger('jobID');
            $table->unsignedInteger('bandID');
            $table->unsignedInteger('groupID');
            $table->unsignedInteger('divisionID');
            $table->unsignedInteger('departmentID');
            $table->unsignedInteger('sectionID');
            $table->string('supervisorID');
            $table->string('email');
            $table->string('phone');
            $table->boolean('isActive');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('roleID')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('jobID')->references('id')->on('jobs')->onDelete('cascade');
            $table->foreign('bandID')->references('id')->on('bands')->onDelete('cascade');
            $table->foreign('groupID')->references('id')->on('groups')->onDelete('cascade');
            $table->foreign('divisionID')->references('id')->on('divisions')->onDelete('cascade');
            $table->foreign('departmentID')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('sectionID')->references('id')->on('sections')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_datas');
    }
}
