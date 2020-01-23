<?php

namespace App\Http\Controllers;
use App\assessment;
use App\evaluation;
use App\evaluationCompetency;
use App\group;
use App\division;
use App\role;
use App\employee_data;
use App\competencyType;
use App\assessmentType;
use App\employeeRelationship;
use App\relationship;
use App\listOfCompetenciesPerRole;
use App\completionTrackerAssignment;
use App\Exports\completionTrackerSummaryExport;
use App\Exports\completionTrackerBreakdownExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;


use \stdClass;
ini_set('max_execution_time', 12000);
ini_set('memory_limit', '4095M');

use Illuminate\Http\Request;

class CompletionTrackerController extends Controller
{
    //
    

    public function index()
    {
        $group = group::whereNull('deleted_at')->get();
        $completionTrackerAssignment = completionTrackerAssignment::whereNull('deleted_at')->get();
        return view('admin.completion-tracker.index')->with(compact('group','completionTrackerAssignment'));
    }
    public function oneDown($groupID){
        $group = group::find($groupID);
        $division = division::where('groupID','=',$groupID)->whereNull('deleted_at')->get();

        return view('admin.completion-tracker.one-down')->with(compact('group','division'));
    }
    public function  groupPerRoleSummary($groupID)
    {
        $group = group::find($groupID);
        $modelBasis = listOfCompetenciesPerRole::select('roleID')->where('groupID',$groupID)->whereNull('deleted_at')->distinct()->get();
        $role = role::whereNull('deleted_at')->get();
        return view('admin.completion-tracker.group.index')->with(compact('modelBasis','role','group'));
    }

    public function groupPerRoleSummaryTrack(Request $request,$groupID)
    {
        $group = group::find($groupID);

        if ($request->input('roleselect') == 'N/A') {
            $modelBasis = listOfCompetenciesPerRole::select('roleID')->where('groupID',$groupID)->whereNull('deleted_at')->distinct()->get();
            $roles_selected = array();

            foreach($modelBasis as $modelBasisItem){
                array_push($roles_selected,strval($modelBasisItem->roleID));
            }

            $roles_selected_id = null;
            foreach($roles_selected as $item){
                $roles_selected_id .= $item.',';
            }

        } else {
            $roles_selected = $request->input('roleselect');
            
            $roles_selected_id = null;
            foreach($roles_selected as $item){
                $roles_selected_id .= $item.',';
            }
        }
        
        
        $role = role::whereNull('deleted_at')->get();
        $assessmentType = assessmentType::whereNull('deleted_at')->get();
        $competencyType = competencyType::whereNull('deleted_at')->get();
        $employee = employee_data::whereNull('deleted_at')->get();
        $employeeRelationship = employeeRelationship::whereNull('deleted_at')->get();
        $relationship = relationship::whereNull('deleted_at')->get();

        //return $roles_selected;
        $arraySelection = array();

        $arrayBreakdown = array();
        
        if($roles_selected){
            foreach($roles_selected as $rsItem){
                foreach($role as $roleItem){
                    if($rsItem == $roleItem->id){
                        if($assessmentType){
                            foreach($assessmentType as $assessmentTypeItem){
                                $arrayRow = new stdClass();
                                $arrayRow->roleID = $roleItem->id;
                                $arrayRow->roleName = $roleItem->name;
                                $arrayRow->assessmentTypeID = $assessmentTypeItem->id;
                                $arrayRow->assessmentType = $assessmentTypeItem->name;
                                
                                $countTarget = 0;

                                $targetEmployees = employee_data::where('roleID',$roleItem->id)->whereNull('deleted_at')->get();
                                

                                //Memory Efficient
                                for($i=0;$i<count($targetEmployees);$i++){
                                    $employeeRelationship = employeeRelationship::where('relationshipID',$assessmentTypeItem->relationshipID)
                                        ->where('assesseeEmployeeID',$targetEmployees[$i]->id)
                                        ->where('is_active',1)
                                        ->whereNull('deleted_at')
                                        ->first();
                                    if($employeeRelationship){
                                        $countTarget++;
                                    }
                                }

                                $arrayRow->target = $countTarget;

                                $countAssessed = 0;

                                $model = listOfCompetenciesPerRole::where('roleID',$roleItem->id)->whereNull('deleted_at')->get();
                                $countModel = count($model);
                                //Memory Efficient 
                                for($i=0;$i<count($targetEmployees);$i++){
                                    $employeeRelationship = employeeRelationship::where('relationshipID',$assessmentTypeItem->relationshipID)
                                        ->where('assesseeEmployeeID',$targetEmployees[$i]->id)
                                        ->where('is_active',1)
                                        ->whereNull('deleted_at')
                                        ->first();
                                    if($employeeRelationship){
                                        $assessment = assessment::where('employeeID',$employeeRelationship->assesseeEmployeeID)->where('assessmentTypeID',$assessmentTypeItem->id)->whereNull('deleted_at')->first();
                                        if($assessment){
                                            $evaluation = evaluation::where('id',$assessment->evaluationVersionID)->whereNull('deleted_at')->first();
                                            if($evaluation){
                                                $evaluationCompetency = evaluationCompetency::where('evaluationID',$evaluation->id)->whereNull('deleted_at')->get();
                                                if($evaluationCompetency){
                                                    $model_evaluation_counter = 0;
                                                    foreach ($model as $modelItem) {
                                                        $evaluationChecker = evaluationCompetency::where('competencyID',$modelItem->competencyID)->where('evaluationID',$evaluation->id)->whereNull('deleted_at')->first();
                                                        if ($evaluationChecker) {
                                                            $model_evaluation_counter++;
                                                        }
                                                    }
                                                    if($model_evaluation_counter == $countModel){
                                                        $countAssessed++;
                                                    }
                                                }
                                            } 
                                        }
                                    }
                                }

                                $arrayRow->assessed = $countAssessed;

                                $arrayRow->completion = 0;
                                if ($countAssessed > 0 && $countTarget > 0 ) {
                                    $arrayRow->completion = ($countAssessed / $countTarget) * 100;
                                } 
                                array_push($arraySelection,$arrayRow);
                            }
                        }
                    }
                }
            }
        }


        if($roles_selected){
            foreach($roles_selected as $rsItem){
                foreach($role as $roleItem){
                    if($rsItem == $roleItem->id){
                        if($assessmentType){
                            foreach($assessmentType as $assessmentTypeItem){

                                $targetEmployees = employee_data::where('roleID',$roleItem->id)->whereNull('deleted_at')->get();

                                $selectedAssessmentType = assessmentType::where('relationshipID', $assessmentTypeItem->id)->whereNull('deleted_at')->first();
                                $model = listOfCompetenciesPerRole::where('roleID',$roleItem->id)->whereNull('deleted_at')->get();
                                $countModel = count($model);

                                for($i=0;$i<count($targetEmployees);$i++){
                                    $employeeRelationship = employeeRelationship::where('relationshipID',$assessmentTypeItem->relationshipID)
                                        ->where('assesseeEmployeeID',$targetEmployees[$i]->id)
                                        ->where('relationshipID',$selectedAssessmentType->relationshipID)
                                        ->where('is_active',1)
                                        ->whereNull('deleted_at')
                                        ->first();

                                    if ($employeeRelationship) {
                                        $arrayRow = new stdClass();
                                        $arrayRow->roleID = $roleItem->id;
                                        $arrayRow->roleName = $roleItem->name;
                                        $arrayRow->assessmentTypeID = $assessmentTypeItem->id;
                                        $arrayRow->assessmentType = $assessmentTypeItem->name;
                                        
                                        $assessee = employee_data::where('id',$employeeRelationship->assesseeEmployeeID)->whereNull('deleted_at')->first();
    
                                        $arrayRow->assesseeEmployeeID = $assessee->employeeID;
                                        $arrayRow->assesseeName = $assessee->firstname . ' ' . $assessee->lastname;
    
                                        $assessor = employee_data::where('id',$employeeRelationship->assessorEmployeeID)->whereNull('deleted_at')->first();
    
                                        $arrayRow->assessorEmployeeID = $assessor->employeeID;
                                        $arrayRow->assessorName = $assessor->firstname . ' ' . $assessor->lastname;
                                        $arrayRow->completion = 0; 

                                        $assessment = assessment::where('employeeID',$assessee->id)->where('assessmentTypeID',$assessmentTypeItem->id)->whereNull('deleted_at')->first();
                                        if($assessment){
                                            $evaluation = evaluation::where('id',$assessment->evaluationVersionID)->whereNull('deleted_at')->first();
                                            if($evaluation){
                                                $evaluationCompetency = evaluationCompetency::where('evaluationID',$evaluation->id)->whereNull('deleted_at')->get();
                                                if($evaluationCompetency){
                                                    $model_evaluation_counter = 0;
                                                    foreach ($model as $modelItem) {
                                                        $evaluationChecker = evaluationCompetency::where('competencyID',$modelItem->competencyID)->where('evaluationID',$evaluation->id)->whereNull('deleted_at')->first();
                                                        if ($evaluationChecker) {
                                                            $model_evaluation_counter++;
                                                        }
                                                    }
                                                    if($model_evaluation_counter == $countModel){
                                                        $arrayRow->completion = 1; 
                                                    }elseif($model_evaluation_counter <= $countModel && $model_evaluation_counter >0){
                                                        $arrayRow->completion = 2; 
                                                    }
                                                }
                                            } 
                                        }
                                        array_push($arrayBreakdown,$arrayRow);
                                    }
                                    
                                }
                                
                            }
                        }
                    }
                }
            }
        }


        //return $arrayBreakdown;
        
        return view('admin.completion-tracker.group.show')->with(compact(
            'group',
            'roles_selected',
            'role',
            'assessmentType',
            'assessment',
            'evaluation',
            'evaluationCompetency',
            'competencyType',
            'employee',
            'arraySelection',
            'arrayBreakdown',
            'roles_selected_id'
        ));
    }

    public function export(Request $request,$groupID) 
    {
        $group = group::find($groupID);
        $roles_selected_id = $request->input('roles_selected_id');
        $roles_selected = explode(",",$roles_selected_id);

        $role = role::whereNull('deleted_at')->get();
        $assessmentType = assessmentType::whereNull('deleted_at')->get();
        $competencyType = competencyType::whereNull('deleted_at')->get();
        $employee = employee_data::whereNull('deleted_at')->get();
        $employeeRelationship = employeeRelationship::whereNull('deleted_at')->get();
        $relationship = relationship::whereNull('deleted_at')->get();

        //return $roles_selected;
        $arraySelection = array();

        $arrayBreakdown = array();
        
        if($roles_selected){
            foreach($roles_selected as $rsItem){
                foreach($role as $roleItem){
                    if($rsItem == $roleItem->id){
                        if($assessmentType){
                            foreach($assessmentType as $assessmentTypeItem){
                                $arrayRow = new stdClass();
                                $arrayRow->roleName = $roleItem->name;
                                $arrayRow->assessmentType = $assessmentTypeItem->name;
                                
                                $countTarget = '0';

                                $targetEmployees = employee_data::where('groupID',$groupID)->where('roleID',$roleItem->id)->whereNull('deleted_at')->get();
                                

                                //Memory Efficient
                                for($i=0;$i<count($targetEmployees);$i++){
                                    $employeeRelationship = employeeRelationship::where('relationshipID',$assessmentTypeItem->relationshipID)
                                        ->where('assesseeEmployeeID',$targetEmployees[$i]->employeeID)
                                        ->where('is_active',1)
                                        ->whereNull('deleted_at')
                                        ->first();
                                    if($employeeRelationship){
                                        $countTarget++;
                                    }
                                }

                                $arrayRow->target =  $countTarget ;

                                $countAssessed = '0';

                                $model = listOfCompetenciesPerRole::where('roleID',$roleItem->id)->whereNull('deleted_at')->get();
                                $countModel = count($model);
                                //Memory Efficient 
                                for($i=0;$i<count($targetEmployees);$i++){
                                    $employeeRelationship = employeeRelationship::where('relationshipID',$assessmentTypeItem->relationshipID)
                                        ->where('assesseeEmployeeID',$targetEmployees[$i]->employeeID)
                                        ->where('is_active',1)
                                        ->whereNull('deleted_at')
                                        ->first();
                                    if($employeeRelationship){
                                        $assessment = assessment::where('employeeID',$employeeRelationship->assesseeEmployeeID)->where('assessmentTypeID',$assessmentTypeItem->id)->whereNull('deleted_at')->first();
                                        if($assessment){
                                            $evaluation = evaluation::where('id',$assessment->evaluationVersionID)->whereNull('deleted_at')->first();
                                            if($evaluation){
                                                $evaluationCompetency = evaluationCompetency::where('evaluationID',$evaluation->id)->whereNull('deleted_at')->get();
                                                if($evaluationCompetency){
                                                    $model_evaluation_counter = 0;
                                                    foreach ($model as $modelItem) {
                                                        $evaluationChecker = evaluationCompetency::where('competencyID',$modelItem->competencyID)->where('evaluationID',$evaluation->id)->whereNull('deleted_at')->first();
                                                        if ($evaluationChecker) {
                                                            $model_evaluation_counter++;
                                                        }
                                                    }
                                                    if($model_evaluation_counter == $countModel){
                                                        $countAssessed++;
                                                    }
                                                }
                                            } 
                                        }
                                    }
                                }

                                $arrayRow->assessed =  $countAssessed;

                                $arrayRow->completion = 'N/A';
                                if ($countAssessed > 0 && $countTarget > 0 ) {
                                    $arrayRow->completion = ($countAssessed / $countTarget) * 100 . '%';
                                } 
                                array_push($arraySelection,$arrayRow);
                            }
                        }
                    }
                }
            }
        }


        if($roles_selected){
            foreach($roles_selected as $rsItem){
                foreach($role as $roleItem){
                    if($rsItem == $roleItem->id){
                        if($assessmentType){
                            foreach($assessmentType as $assessmentTypeItem){

                                $targetEmployees = employee_data::where('groupID',$groupID)->where('roleID',$roleItem->id)->whereNull('deleted_at')->get();

                                $selectedAssessmentType = assessmentType::where('relationshipID', $assessmentTypeItem->id)->whereNull('deleted_at')->first();
                                $model = listOfCompetenciesPerRole::where('roleID',$roleItem->id)->whereNull('deleted_at')->get();
                                $countModel = count($model);

                                for($i=0;$i<count($targetEmployees);$i++){
                                    $employeeRelationship = employeeRelationship::where('relationshipID',$assessmentTypeItem->relationshipID)
                                        ->where('assesseeEmployeeID',$targetEmployees[$i]->employeeID)
                                        ->where('relationshipID',$selectedAssessmentType->relationshipID)
                                        ->where('is_active',1)
                                        ->whereNull('deleted_at')
                                        ->first();

                                    if ($employeeRelationship) {
                                        $arrayRow = new stdClass();
                                        $arrayRow->roleID = $roleItem->id;
                                        $arrayRow->roleName = $roleItem->name;
                                        $arrayRow->assessmentTypeID = $assessmentTypeItem->id;
                                        $arrayRow->assessmentType = $assessmentTypeItem->name;
                                        
                                        $assessee = employee_data::where('id',$employeeRelationship->assesseeEmployeeID)->whereNull('deleted_at')->first();
    
                                        $arrayRow->assesseeEmployeeID = $assessee->employeeID;
                                        $arrayRow->assesseeName = $assessee->firstname . ' ' . $assessee->lastname;
    
                                        $assessor = employee_data::where('id',$employeeRelationship->assessorEmployeeID)->whereNull('deleted_at')->first();
    
                                        $arrayRow->assessorEmployeeID = $assessor->employeeID;
                                        $arrayRow->assessorName = $assessor->firstname . ' ' . $assessor->lastname;
                                        $arrayRow->completion = 0; 

                                        $assessment = assessment::where('employeeID',$assessee->employeeID)->where('assessmentTypeID',$assessmentTypeItem->id)->whereNull('deleted_at')->first();
                                        if($assessment){
                                            $evaluation = evaluation::where('id',$assessment->evaluationVersionID)->whereNull('deleted_at')->first();
                                            if($evaluation){
                                                $evaluationCompetency = evaluationCompetency::where('evaluationID',$evaluation->id)->whereNull('deleted_at')->get();
                                                if($evaluationCompetency){
                                                    $model_evaluation_counter = 0;
                                                    foreach ($model as $modelItem) {
                                                        $evaluationChecker = evaluationCompetency::where('competencyID',$modelItem->competencyID)->where('evaluationID',$evaluation->id)->whereNull('deleted_at')->first();
                                                        if ($evaluationChecker) {
                                                            $model_evaluation_counter++;
                                                        }
                                                    }
                                                    if($model_evaluation_counter == $countModel){
                                                        $arrayRow->completion = 1; 
                                                    }
                                                }
                                            } 
                                        }
                                        array_push($arrayBreakdown,$arrayRow);
                                    }
                                    
                                }
                                
                            }
                        }
                    }
                }
            }
        }
        

        $export = new completionTrackerSummaryExport($arraySelection);
        return Excel::download($export, 'CompletionTracker.xlsx');
    }


    public function breakdown(Request $request,$groupID) 
    {
        $group = group::find($groupID);
        $roles_selected_id = $request->input('roles_selected_id');
        $roles_selected = explode(",",$roles_selected_id);

        $role = role::whereNull('deleted_at')->get();
        $assessmentType = assessmentType::whereNull('deleted_at')->get();
        $competencyType = competencyType::whereNull('deleted_at')->get();
        $employee = employee_data::whereNull('deleted_at')->get();
        $employeeRelationship = employeeRelationship::whereNull('deleted_at')->get();
        $relationship = relationship::whereNull('deleted_at')->get();

        //return $roles_selected;
        $arrayBreakdown = array();
        
        if($roles_selected){
            foreach($roles_selected as $rsItem){
                foreach($role as $roleItem){
                    if($rsItem == $roleItem->id){
                        if($assessmentType){
                            foreach($assessmentType as $assessmentTypeItem){
                                $targetEmployees = employee_data::where('groupID',$groupID)->where('roleID',$roleItem->id)->whereNull('deleted_at')->get();

                                $selectedAssessmentType = assessmentType::where('relationshipID', $assessmentTypeItem->id)->whereNull('deleted_at')->first();
                                $model = listOfCompetenciesPerRole::where('roleID',$roleItem->id)->whereNull('deleted_at')->get();
                                $countModel = count($model);

                                for($i=0;$i<count($targetEmployees);$i++){
                                    $employeeRelationship = employeeRelationship::where('relationshipID',$assessmentTypeItem->relationshipID)
                                        ->where('assesseeEmployeeID',$targetEmployees[$i]->employeeID)
                                        ->where('relationshipID',$selectedAssessmentType->relationshipID)
                                        ->where('is_active',1)
                                        ->whereNull('deleted_at')
                                        ->first();

                                    if ($employeeRelationship) {
                                        $arrayRow = new stdClass();
                                        $arrayRow->roleName = $roleItem->name;
                                        $arrayRow->assessmentType = $assessmentTypeItem->name;
                                        
                                        $assessee = employee_data::where('id',$employeeRelationship->assesseeEmployeeID)->whereNull('deleted_at')->first();
    
                                        $arrayRow->assesseeName = $assessee->employeeID . ' - ' . $assessee->firstname . ' ' . $assessee->lastname;
    
                                        $assessor = employee_data::where('id',$employeeRelationship->assessorEmployeeID)->whereNull('deleted_at')->first();
    
                                        $arrayRow->assessorName = $assessor->employeeID . ' - ' . $assessor->firstname . ' ' . $assessor->lastname;
                                        $arrayRow->completion = 'On-Going'; 

                                        $assessment = assessment::where('employeeID',$assessee->employeeID)->where('assessmentTypeID',$assessmentTypeItem->id)->whereNull('deleted_at')->first();
                                        if($assessment){
                                            $evaluation = evaluation::where('id',$assessment->evaluationVersionID)->whereNull('deleted_at')->first();
                                            if($evaluation){
                                                $evaluationCompetency = evaluationCompetency::where('evaluationID',$evaluation->id)->whereNull('deleted_at')->get();
                                                if($evaluationCompetency){
                                                    $model_evaluation_counter = 0;
                                                    foreach ($model as $modelItem) {
                                                        $evaluationChecker = evaluationCompetency::where('competencyID',$modelItem->competencyID)->where('evaluationID',$evaluation->id)->whereNull('deleted_at')->first();
                                                        if ($evaluationChecker) {
                                                            $model_evaluation_counter++;
                                                        }
                                                    }
                                                    if($model_evaluation_counter == $countModel){
                                                        $arrayRow->completion = 'Completed'; 
                                                    }else{
                                                        $arrayRow->completion = 'On-Going'; 
                                                    }
                                                }
                                            } 
                                        }
                                        array_push($arrayBreakdown,$arrayRow);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        //return $arrayBreakdown;
        $export = new completionTrackerBreakdownExport($arrayBreakdown);
        return Excel::download($export, 'CompletionTrackerBreakdown.xlsx');
    }
}
