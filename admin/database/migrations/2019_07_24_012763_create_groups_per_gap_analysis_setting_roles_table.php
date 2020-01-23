<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;


class CreateGroupsPerGapAnalysisSettingRolesTable extends Migration
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
        Schema::create('groups_per_gap_analysis_setting_roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('gpgas_id_foreign');
            $table->unsignedInteger('roleID');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('roleID')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('gpgas_id_foreign')->references('id')->on('groups_per_gap_analysis_settings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groups_per_gap_analysis_setting_roles');
    }
}
