<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreateSectionsTable extends Migration
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
        Schema::create('sections', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('departmentID');
            $table->unsignedInteger('divisionID');
            $table->unsignedInteger('groupID');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('departmentID')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('divisionID')->references('id')->on('divisions')->onDelete('cascade');
            $table->foreign('groupID')->references('id')->on('groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sections');
    }
}
