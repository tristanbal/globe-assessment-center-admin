<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\assessmentType;

class CreateAssessmentTypesTable extends Migration
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
        Schema::create('assessment_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('definition', 10000);
            $table->unsignedInteger('relationshipID');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('relationshipID')->references('id')->on('relationships')->onDelete('cascade');
        });

        $selfAssessment = new assessmentType;
        $selfAssessment->name = 'Self-Assessment';
        $selfAssessment->definition = 'Self-Assessment tool is designed to help identify your areas of strength and development aligned to your designated role. This is done by rating yourself based on the behaviors you exhibit in the workplace.';
        $selfAssessment->relationshipID = 1;
        $selfAssessment->save();

        $supervisorAssessment = new assessmentType;
        $supervisorAssessment->name = 'Supervisor Assessment';
        $supervisorAssessment->definition = "This module is designed for Immediate Supervisor to help identify the areas of strength and development for their respective employees. This is done through having the employee's respective immediate supervisor rate his or her direct reports based on the behaviors they exhibit in the workplace. ";
        $supervisorAssessment->relationshipID = 2;
        $supervisorAssessment->save();

        $directAssessment = new assessmentType;
        $directAssessment->name = 'Direct Reporting Assessment';
        $directAssessment->definition = 'N/A';
        $directAssessment->relationshipID = 3;
        $directAssessment->save();


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assessment_types');
    }
}
