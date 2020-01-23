<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreateSubclustersTable extends Migration
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
        Schema::create('subclusters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('clusterID');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('clusterID')->references('id')->on('clusters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subclusters');
    }
}
