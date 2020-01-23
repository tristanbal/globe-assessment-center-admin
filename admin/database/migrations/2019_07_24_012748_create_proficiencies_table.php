<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreateProficienciesTable extends Migration
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
        Schema::create('proficiencies', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('levelID');
            $table->unsignedInteger('competencyID');
            $table->string('definition', 10000);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('levelID')->references('id')->on('levels')->onDelete('cascade');
            $table->foreign('competencyID')->references('id')->on('competencies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proficiencies');
    }
}
