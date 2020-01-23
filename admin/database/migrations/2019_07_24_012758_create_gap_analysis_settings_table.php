<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreateGapAnalysisSettingsTable extends Migration
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
        Schema::create('gap_analysis_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 1000);
            $table->string('description', 1000);
            $table->integer('is_active');
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
        Schema::dropIfExists('gap_analysis_settings');
    }
}
