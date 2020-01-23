<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreateEmployeeRelationshipsTable extends Migration
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
        Schema::create('employee_relationships', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('assesseeEmployeeID');
            $table->unsignedInteger('assessorEmployeeID');
            $table->unsignedInteger('relationshipID');
            $table->integer('is_active');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('assesseeEmployeeID')->references('id')->on('employee_datas')->onDelete('cascade');
            $table->foreign('assessorEmployeeID')->references('id')->on('employee_datas')->onDelete('cascade');
            $table->foreign('relationshipID')->references('id')->on('relationships')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_relationships');
    }
}
