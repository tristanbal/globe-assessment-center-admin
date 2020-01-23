<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreateCompletionTrackerAssignmentsTable extends Migration
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
        Schema::create('completion_tracker_assignments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('employeeID');
            $table->unsignedBigInteger('gpgas_id_foreign');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('employeeID')->references('id')->on('employee_datas')->onDelete('cascade');
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
        Schema::dropIfExists('completion_tracker_assignments');
    }
}
