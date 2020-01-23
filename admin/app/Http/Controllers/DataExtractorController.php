<?php

namespace App\Http\Controllers;

use App\employee_data;
use App\group;
use App\division;
use App\department;
use App\section;
use App\role;
use App\band;
use App\job;
use App\User;
use App\employeeRelationship;
use App\assessmentType;
use App\relationship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use stdClass;
use App\cluster;
use App\subcluster;
use App\talentSegment;
use App\competency;
use App\level;
use App\proficiency;
use App\listOfCompetenciesPerRole;
use App\competencyType;
use App\evaluation;
use App\evaluationCompetency;
use App\assessment;


class DataExtractorController extends Controller
{
    //

    public function index(){
        //Data Extract Module
        return view('admin.data-extract.index');
    }

    public function competencyLibrary(){
        $competencySummary = competency::whereNull('deleted_at')->orderBy('clusterID','asc')->get();
        $level = level::whereNull('deleted_at')->get();

        $finalCompetency = array();
        foreach($competencySummary as $competencySummaryItem){
            $competencySummaryRow = new stdClass;

            $clusterRow = cluster::find($competencySummaryItem->clusterID);
            $subclusterRow = subcluster::find($competencySummaryItem->subclusterID);
            $talentSegmentRow = talentSegment::find($competencySummaryItem->talentSegmentID);

            $competencySummaryRow->clusterID = $competencySummaryItem->clusterID;
            $competencySummaryRow->cluster = $clusterRow->name;
            $competencySummaryRow->subcluster = $subclusterRow->name;
            $competencySummaryRow->talentSegment = $talentSegmentRow->name;
            $competencySummaryRow->competencyName = $competencySummaryItem->name;
            $competencySummaryRow->competencyDefinition = $competencySummaryItem->definition;

            foreach($level as $levelCount){
                if($levelCount->weight > 0){
                    $levelName = 'level'.$levelCount->weight;

                    $proficiencyRow = proficiency::where('competencyID',$competencySummaryItem->id)->where('levelID',$levelCount->id)->whereNull('deleted_at')->first();

                    if ($proficiencyRow) {
                        $competencySummaryRow->{$levelName} = $proficiencyRow->definition;
                    }else {
                        $competencySummaryRow->{$levelName} = 'N/A';
                    }
                    
                }
            }
            

            array_push($finalCompetency,$competencySummaryRow);
        }

        return view('admin.data-extract.competency-library.index')->with(compact('finalCompetency'));
        return $finalCompetency;
    }

    public function masterlist(){
        $employeeDataMasterlist = employee_data::whereNull('deleted_at')->get();

        $employeeDataSummary = array();

        foreach($employeeDataMasterlist as $employeeSourceItem){
            $employeeDataRow = new stdClass;

            $groupRow = group::find($employeeSourceItem->groupID);
            $divisionRow = division::find($employeeSourceItem->divisionID);
            $departmentRow = department::find($employeeSourceItem->departmentID);
            $sectionRow = section::find($employeeSourceItem->sectionID);
            $roleRow = role::find($employeeSourceItem->roleID);
            $bandRow = band::find($employeeSourceItem->bandID);
            $supervisorRow = employee_data::where('employeeID',$employeeSourceItem->supervisorID)->whereNull('deleted_at')->first();

            $supervisorSelected = 'N/A';
            if ($supervisorRow) {
                $supervisorSelected = $supervisorRow->employeeID;
            }

            $employeeDataRow->employeeID = $employeeSourceItem->employeeID;
            $employeeDataRow->group = $groupRow->name;
            $employeeDataRow->division = $divisionRow->name;
            $employeeDataRow->department = $departmentRow->name;
            $employeeDataRow->section = $sectionRow->name;
            $employeeDataRow->firstname =  $employeeSourceItem->firstname;
            $employeeDataRow->lastname =  $employeeSourceItem->lastname;
            $employeeDataRow->middlename =  $employeeSourceItem->middlename;
            $employeeDataRow->namesuffix =  $employeeSourceItem->nameSuffix;
            $employeeDataRow->role = $roleRow->name;
            $employeeDataRow->band = $bandRow->name;
            $employeeDataRow->supervisorID = $supervisorSelected;
            $employeeDataRow->email =  $employeeSourceItem->email;
            $employeeDataRow->phone =  $employeeSourceItem->phone;
            
            array_push($employeeDataSummary,$employeeDataRow);

        }

        return view('admin.data-extract.masterlist.index')->with(compact('employeeDataSummary'));
    }

    public function model(){
        $modelRow = listOfCompetenciesPerRole::whereNull('deleted_at')->get();
        
        $modelSummary = array();
        foreach($modelRow as $modelRowItem){
            $modelDataRow = new stdClass;

            //$groupRow = group::find($modelRowItem->groupID);
            //$roleRow = role::find($modelRowItem->roleID);
            $competencyRow = competency::find($modelRowItem->competencyID);
            $competencyTypeRow = competencyType::find($modelRowItem->competencyTypeID);
            $levelRow = level::find($modelRowItem->targetLevelID);

            $modelDataRow->group = $modelRowItem->group->name;
            $modelDataRow->role = $modelRowItem->role->name;
            $modelDataRow->competency = $competencyRow->name;
            $modelDataRow->priority = $competencyTypeRow->name;
            $modelDataRow->target = $levelRow->weight;

            array_push($modelSummary,$modelDataRow);
        }
        return view('admin.data-extract.model.index')->with(compact('modelSummary'));
        return $modelSummary;
    }

    public function evaluationRawData(){

        $rawDataSummary = array();

        $evaluationCompetencyRow = evaluationCompetency::whereNull('deleted_at')->get();
        foreach ($evaluationCompetencyRow as $evaluationCompetencyRowItem) {
            $evaluationRow = evaluation::find($evaluationCompetencyRowItem->evaluationID);
            $assessmentRow = assessment::where('evaluationVersionID',$evaluationRow->id)->whereNull('deleted_at')->first();

            if ($assessmentRow) {
                $assessee = employee_data::where('id',$evaluationRow->assesseeEmployeeID)->whereNull('deleted_at')->first();
                $assessor = employee_data::where('id',$evaluationRow->assessorEmployeeID)->whereNull('deleted_at')->first();
                $assessmentType = assessmentType::find($assessmentRow->assessmentTypeID);
                $competency = competency::find($evaluationCompetencyRowItem->competencyID);
                $competencyType = competencyType::find($evaluationCompetencyRowItem->competencyTypeID);
                $targetLevel = level::find($evaluationCompetencyRowItem->targetLevelID);
                $role = role::find($evaluationRow->assesseeRoleID);
                $group = group::find($assessee->groupID);

                $rawDataRow = new stdClass;
                $rawDataRow->group = $group->name;
                $rawDataRow->role = $role->name;
                $rawDataRow->assesseeEmployeeID = $assessee->employeeID;
                $rawDataRow->assesseeName = $assessee->firstname . ' '. $assessee->lastname;
                $rawDataRow->assessorEmployeeID = $assessor->employeeID;
                $rawDataRow->assessorName = $assessor->firstname . ' '. $assessor->lastname;
                $rawDataRow->assessmentType = $assessmentType->name;
                $rawDataRow->competencyType = $competencyType->name;
                $rawDataRow->competency = $competency->name;
                $rawDataRow->target = $targetLevel->weight;
                $rawDataRow->weight = $evaluationCompetencyRowItem->weightedScore;
                $rawDataRow->verbatim = $evaluationCompetencyRowItem->verbatim;
                $rawDataRow->additionalFile = $evaluationCompetencyRowItem->additional_file;
                $rawDataRow->timestamp = $evaluationCompetencyRowItem->updated_at;

                array_push($rawDataSummary,$rawDataRow);

            }
        }

        return view('admin.data-extract.raw-data.index')->with(compact('rawDataSummary'));
        return $rawDataSummary;
    }
 
}
