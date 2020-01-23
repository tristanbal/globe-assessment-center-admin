<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreateOldDatabaseMigratorsTable extends Migration
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
        Schema::create('old_database_migrators', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('assessee', 1000);
            $table->string('assessor', 1000);
            $table->string('competency', 1000);
            $table->string('givenLevelID', 1000);
            $table->string('targetLevelID', 1000);
            $table->string('weightedScore', 1000);
            $table->string('role', 1000);
            $table->string('competencyType', 1000);
            $table->string('origCreated', 1000);
            $table->string('origUpdated', 1000);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('old_database_migrators');
    }
}
