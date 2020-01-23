<?php

namespace App\Http\Controllers;

use App\completionTrackerAssignment;
use App\groupsPerGapAnalysisSetting;
use App\employee_data;
use Illuminate\Http\Request;

use App\assessment;
use App\evaluation;
use App\evaluationCompetency;
use App\assessmentType;
use App\competencyType;
use App\relationship;
use App\employeeRelationship;
use App\listOfCompetenciesPerRole;
use App\group;
use App\division;
use App\department;
use App\section;
use App\role;
use App\job;
use App\band;
use App\gapAnalysisSetting;
use App\gapAnalysisSettingAssessmentType;
use App\groupsPerGapAnalysisSettingRole;
use App\Exports\completionTrackerSummaryExport;
use App\Exports\completionTrackerBreakdownExport;
use Maatwebsite\Excel\Facades\Excel;

use \stdClass;
ini_set('max_execution_time', 12000);
ini_set('memory_limit', '4095M');

class CompletionTrackerAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $completionTrackerAssignment = completionTrackerAssignment::whereNull('deleted_at')->get();
        return view("admin.completion-tracker-assignment.view-all")->with(compact('completionTrackerAssignment'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $groupsPerGapAnalysisSetting = groupsPerGapAnalysisSetting::whereNull('deleted_at')->get();
        $employee = employee_data::whereNull('deleted_at')->get();

        return view("admin.completion-tracker-assignment.create")->with(compact('employee','groupsPerGapAnalysisSetting'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $completionTrackerAssignment = new completionTrackerAssignment;
        $completionTrackerAssignment->employeeID = $request->input('employeeDropdown');
        $completionTrackerAssignment->gpgas_id_foreign = $request->input('gpgasDropdown');
        $completionTrackerAssignment->save();

        return \Redirect::route('completionTrackers.index')->with('success', 'Completion Tracker successfully assigned.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\completionTrackerAssignment  $completionTrackerAssignment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $assessmentType = assessmentType::whereNull('deleted_at')->get();

        $completionTrackerAssignment = completionTrackerAssignment::find($id);
        
        $groupsPerGapAnalysisSettingRole = groupsPerGapAnalysisSettingRole::where('gpgas_id_foreign',$completionTrackerAssignment->gpgas_id_foreign)->whereNull('deleted_at')->get();

        $groupsPerGapAnalysisSettingRoleModel = groupsPerGapAnalysisSettingRole::where('gpgas_id_foreign',$completionTrackerAssignment->gpgas_id_foreign)->whereNull('deleted_at')->first();
        
        $modelGroup = listOfCompetenciesPerRole::where('roleID',$groupsPerGapAnalysisSettingRoleModel->roleID)->first();
        $group = group::find($modelGroup->groupID);
        //return $group;

        $roles_selected_id = null;
        $roles_selected = array();
        $roles_name = array();
        foreach($groupsPerGapAnalysisSettingRole as $modelBasisItem){
            array_push($roles_selected,strval($modelBasisItem->roleID));

            $specificRowItem = role::find($modelBasisItem->roleID);
            array_push($roles_name,$specificRowItem->name);
        }
        foreach($groupsPerGapAnalysisSettingRole as $item){
            $roles_selected_id .= $item->roleID.',';
        }
        
        $role = role::whereNull('deleted_at')->get();
        $assessmentTypeTracker = assessmentType::whereNull('deleted_at')->get();
        $competencyTypeTracker = competencyType::whereNull('deleted_at')->get();
        $employeeTracker = employee_data::whereNull('deleted_at')->get();
        $employeeRelationshipTracker = employeeRelationship::whereNull('deleted_at')->get();
        $relationshipTracker = relationship::whereNull('deleted_at')->get();

        //return $roles_selected;
        $arraySelection = array();

        $arrayBreakdown = array();
        //return $completionTrackerAssignment->gpgas_id_foreign;

        $groupsPerGapAnalysisSetting = groupsPerGapAnalysisSetting::find($completionTrackerAssignment->gpgas_id_foreign);
        $gapAnalysisSetting = gapAnalysisSetting::find($groupsPerGapAnalysisSetting->gapAnalysisSettingID);
        if($gapAnalysisSetting){
            if($roles_selected){
                foreach($roles_selected as $rsItem){
                    foreach($role as $roleItem){
                        if($rsItem == $roleItem->id){
                            if($assessmentTypeTracker){
                                foreach($assessmentTypeTracker as $assessmentTypeItem){
                                    
                                    
                                    $countTarget = 0;
    
                                    $targetEmployees = employee_data::where('roleID',$roleItem->id)->whereNull('deleted_at')->get();
                                    
    
                                    //Memory Efficient
                                    for($i=0;$i<count($targetEmployees);$i++){
                                        $employeeRelationshipTracker = employeeRelationship::where('relationshipID',$assessmentTypeItem->relationshipID)
                                            ->where('assesseeEmployeeID',$targetEmployees[$i]->id)
                                            ->where('is_active',1)
                                            ->whereNull('deleted_at')
                                            ->first();
                                        if($employeeRelationshipTracker){
                                            $countTarget++;
                                        }
                                    }
                                    
                                    if ($countTarget > 0) {
                                        $arrayRow = new stdClass();
                                        $arrayRow->roleID = $roleItem->id;
                                        $arrayRow->roleName = $roleItem->name;
                                        $arrayRow->assessmentTypeID = $assessmentTypeItem->id;
                                        $arrayRow->assessmentType = $assessmentTypeItem->name;
                                        $arrayRow->target = $countTarget;
    
                                        $countAssessed = 0;
    
                                        $model = listOfCompetenciesPerRole::where('roleID',$roleItem->id)->whereNull('deleted_at')->get();
                                        $countModel = count($model);
                                        //Memory Efficient 
                                        for($i=0;$i<count($targetEmployees);$i++){
                                            $employeeRelationshipTracker = employeeRelationship::where('relationshipID',$assessmentTypeItem->relationshipID)
                                                ->where('assesseeEmployeeID',$targetEmployees[$i]->id)
                                                ->where('is_active',1)
                                                ->whereNull('deleted_at')
                                                ->first();
                                            if($employeeRelationshipTracker){
                                                $assessmentTracker = assessment::where('employeeID',$employeeRelationshipTracker->assesseeEmployeeID)->where('assessmentTypeID',$assessmentTypeItem->id)->whereNull('deleted_at')->first();
                                                if($assessmentTracker){
                                                    $evaluationTracker = evaluation::where('id',$assessmentTracker->evaluationVersionID)->whereNull('deleted_at')->first();
                                                    if($evaluationTracker){
                                                        $evaluationCompetency = evaluationCompetency::where('evaluationID',$evaluationTracker->id)->whereNull('deleted_at')->get();
                                                        if($evaluationCompetency){
                                                            $model_evaluation_counter = 0;
                                                            foreach ($model as $modelItem) {
                                                                $evaluationChecker = evaluationCompetency::where('competencyID',$modelItem->competencyID)->where('evaluationID',$evaluationTracker->id)->whereNull('deleted_at')->first();
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
                                //Both
                                $model = listOfCompetenciesPerRole::where('roleID',$roleItem->id)->whereNull('deleted_at')->get();
                                $gapAnalysisSettingAssessmentType = gapAnalysisSettingAssessmentType::where('gas_id_foreign',$gapAnalysisSetting->id)->whereNull('deleted_at')->get();
                                
                                $assessmentBothEmployees = array();
                                
                                $countGapAnalysisSettingAssessmentType = count($gapAnalysisSettingAssessmentType);
                                
                                $subtotalAssessmentBothCount = 0;
                                $targetEmployees = employee_data::where('roleID',$roleItem->id)->whereNull('deleted_at')->get();
                                
                                foreach($targetEmployees as $targetEmployeesItem){
                                    $employeeRelationshipTracker = employeeRelationship::where('assesseeEmployeeID',$targetEmployeesItem->id)
                                        ->where('is_active',1)
                                        ->whereNull('deleted_at')
                                        ->get();
                                    
                                        //return $employeeRelationshipTracker;
                                    if($employeeRelationshipTracker){
                                        $totalBothCount = 0;
                                        foreach($employeeRelationshipTracker as $employeeRelationshipTrackerItem){
                                            foreach($gapAnalysisSettingAssessmentType as $gapAnalysisSettingAssessmentTypeItem){
                                                if ($gapAnalysisSettingAssessmentTypeItem->assessmentTypeID == $employeeRelationshipTrackerItem->relationshipID ) {
                                                    $assessmentTracker = assessment::where('employeeID',$employeeRelationshipTrackerItem->assesseeEmployeeID)->where('assessmentTypeID',$gapAnalysisSettingAssessmentTypeItem->assessmentTypeID)->whereNull('deleted_at')->first();
                                                    //echo $assessmentTracker;
                                                    if($assessmentTracker){
                                                        $evaluationTracker = evaluation::where('id',$assessmentTracker->evaluationVersionID)->whereNull('deleted_at')->first();
                                                        if($evaluationTracker){
                                                            $evaluationCompetency = evaluationCompetency::where('evaluationID',$evaluationTracker->id)->whereNull('deleted_at')->get();
                                                            if($evaluationCompetency){
                                                                $model_evaluation_counter = 0;
                                                                foreach ($model as $modelItem) {
                                                                    $evaluationChecker = evaluationCompetency::where('competencyID',$modelItem->competencyID)->where('evaluationID',$evaluationTracker->id)->whereNull('deleted_at')->first();
                                                                    if ($evaluationChecker) {
                                                                        $model_evaluation_counter++;
                                                                    }
                                                                }
                                                                if($model_evaluation_counter == $countModel){
                                                                    $totalBothCount++;
                                                                }
                                                            }
                                                        } 
                                                    }
                                                    if($totalBothCount == $countGapAnalysisSettingAssessmentType){
                                                        $subtotalAssessmentBothCount++;
                                                        
                                                    } 
                                                }
                                            }
                                        }
                                    }
                                }
                                $arrayRowBoth = new stdClass();
                                $arrayRowBoth->roleID = $roleItem->id;
                                $arrayRowBoth->roleName = $roleItem->name;
                                $arrayRowBoth->assessmentTypeID = 0;
                                $arrayRowBoth->assessmentType = 'Both Assessment';
                                $arrayRowBoth->target = count($targetEmployees);
                                $arrayRowBoth->assessed = $subtotalAssessmentBothCount;
                                //return $subtotalAssessmentBothCount;
                                $arrayRowBoth->completion = 0;
                                if ($subtotalAssessmentBothCount > 0 && count($targetEmployees) > 0 ) {
                                    $arrayRowBoth->completion = ($subtotalAssessmentBothCount / count($targetEmployees)) * 100;
                                } 
                                array_push($arraySelection,$arrayRowBoth);
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
                        if($assessmentTypeTracker){
                            foreach($assessmentTypeTracker as $assessmentTypeItem){

                                $targetEmployees = employee_data::where('roleID',$roleItem->id)->whereNull('deleted_at')->get();

                                $selectedAssessmentType = assessmentType::where('relationshipID', $assessmentTypeItem->id)->whereNull('deleted_at')->first();
                                $model = listOfCompetenciesPerRole::where('roleID',$roleItem->id)->whereNull('deleted_at')->get();
                                $countModel = count($model);

                                for($i=0;$i<count($targetEmployees);$i++){
                                    $employeeRelationshipTracker = employeeRelationship::where('relationshipID',$assessmentTypeItem->relationshipID)
                                        ->where('assesseeEmployeeID',$targetEmployees[$i]->id)
                                        ->where('relationshipID',$selectedAssessmentType->relationshipID)
                                        ->where('is_active',1)
                                        ->whereNull('deleted_at')
                                        ->first();

                                    if ($employeeRelationshipTracker) {
                                        $arrayRow = new stdClass();
                                        $arrayRow->roleID = $roleItem->id;
                                        $arrayRow->roleName = $roleItem->name;
                                        $arrayRow->assessmentTypeID = $assessmentTypeItem->id;
                                        $arrayRow->assessmentType = $assessmentTypeItem->name;
                                        
                                        $assessee = employee_data::where('id',$employeeRelationshipTracker->assesseeEmployeeID)->whereNull('deleted_at')->first();
    
                                        $arrayRow->assesseeEmployeeID = $assessee->employeeID;
                                        $arrayRow->assesseeName = $assessee->firstname . ' ' . $assessee->lastname;
    
                                        $assessor = employee_data::where('id',$employeeRelationshipTracker->assessorEmployeeID)->whereNull('deleted_at')->first();
    
                                        $arrayRow->assessorEmployeeID = $assessor->employeeID;
                                        $arrayRow->assessorName = $assessor->firstname . ' ' . $assessor->lastname;
                                        $arrayRow->completion = 0; 

                                        $assessmentTracker = assessment::where('employeeID',$assessee->id)->where('assessmentTypeID',$assessmentTypeItem->id)->whereNull('deleted_at')->first();
                                        if($assessmentTracker){
                                            $evaluationTracker = evaluation::where('id',$assessmentTracker->evaluationVersionID)->whereNull('deleted_at')->first();
                                            if($evaluationTracker){
                                                $evaluationCompetency = evaluationCompetency::where('evaluationID',$evaluationTracker->id)->whereNull('deleted_at')->get();
                                                if($evaluationCompetency){
                                                    $model_evaluation_counter = 0;
                                                    foreach ($model as $modelItem) {
                                                        $evaluationChecker = evaluationCompetency::where('competencyID',$modelItem->competencyID)->where('evaluationID',$evaluationTracker->id)->whereNull('deleted_at')->first();
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



        $finalTargetTotal = 0;
        $finalAssessedTotal = 0;
        $finalPercentageTotal = 0;
        if($gapAnalysisSetting){
            if($roles_selected){
                foreach($roles_selected as $rsItem){
                    $roleItem = role::find($rsItem);
                    if($roleItem){
                        if($assessmentTypeTracker){
                            //Both
                            $model = listOfCompetenciesPerRole::where('roleID',$roleItem->id)->whereNull('deleted_at')->get();
                            $gapAnalysisSettingAssessmentType = gapAnalysisSettingAssessmentType::where('gas_id_foreign',$gapAnalysisSetting->id)->whereNull('deleted_at')->get();
                            
                            $countModel = count($model);
                            $assessmentBothEmployees = array();
                            
                            $countGapAnalysisSettingAssessmentType = count($gapAnalysisSettingAssessmentType);
                            
                            $subtotalAssessmentBothCount = 0;
                            $targetEmployees = employee_data::where('roleID',$roleItem->id)->whereNull('deleted_at')->get();
                            
                            foreach($targetEmployees as $targetEmployeesItem){
                                $employeeRelationshipTracker = employeeRelationship::where('assesseeEmployeeID',$targetEmployeesItem->id)
                                    ->where('is_active',1)
                                    ->whereNull('deleted_at')
                                    ->get();
                                
                                    //return $employeeRelationshipTracker;
                                if($employeeRelationshipTracker){
                                    $totalBothCount = 0;
                                    foreach($employeeRelationshipTracker as $employeeRelationshipTrackerItem){
                                        foreach($gapAnalysisSettingAssessmentType as $gapAnalysisSettingAssessmentTypeItem){
                                            if ($gapAnalysisSettingAssessmentTypeItem->assessmentTypeID == $employeeRelationshipTrackerItem->relationshipID ) {
                                                $assessmentTracker = assessment::where('employeeID',$employeeRelationshipTrackerItem->assesseeEmployeeID)->where('assessmentTypeID',$gapAnalysisSettingAssessmentTypeItem->assessmentTypeID)->whereNull('deleted_at')->first();
                                                //echo $assessmentTracker;
                                                if($assessmentTracker){
                                                    $evaluationTracker = evaluation::where('id',$assessmentTracker->evaluationVersionID)->whereNull('deleted_at')->first();
                                                    if($evaluationTracker){
                                                        $evaluationCompetency = evaluationCompetency::where('evaluationID',$evaluationTracker->id)->whereNull('deleted_at')->get();
                                                        if($evaluationCompetency){
                                                            $model_evaluation_counter = 0;
                                                            foreach ($model as $modelItem) {
                                                                $evaluationChecker = evaluationCompetency::where('competencyID',$modelItem->competencyID)->where('evaluationID',$evaluationTracker->id)->whereNull('deleted_at')->first();
                                                                if ($evaluationChecker) {
                                                                    $model_evaluation_counter++;
                                                                }
                                                            }
                                                            if($model_evaluation_counter == $countModel){
                                                                $totalBothCount++;
                                                            }
                                                        }
                                                    } 
                                                }
                                                if($totalBothCount == $countGapAnalysisSettingAssessmentType){
                                                    $subtotalAssessmentBothCount++;
                                                    
                                                } 
                                            }
                                        }
                                    }
                                }
                            }
                            $finalTargetTotal = $finalTargetTotal + count($targetEmployees);
                            $finalAssessedTotal = $subtotalAssessmentBothCount + $finalAssessedTotal;
                        }
                    }
                }
            }
        }

        if($finalTargetTotal>0 && $finalAssessedTotal >0){
            $finalPercentageTotal = ($finalAssessedTotal/$finalTargetTotal)*100;
        }

        $gapAnalysisSettingAssessmentType = gapAnalysisSettingAssessmentType::where('gas_id_foreign',$gapAnalysisSetting->id)->whereNull('deleted_at')->get();

        //return $arrayBreakdown;
        //
        $completionTrackerAssignment = completionTrackerAssignment::find($id);
        return view("admin.completion-tracker-assignment.view")->with(compact(
            'completionTrackerAssignment',
            'roles_name',
            'finalTargetTotal',
            'finalAssessedTotal',
            'finalPercentageTotal',
            'id',
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
            'roles_selected_id',
            'gapAnalysisSettingAssessmentType'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\completionTrackerAssignment  $completionTrackerAssignment
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $completionTrackerAssignment = completionTrackerAssignment::find($id);
        $groupsPerGapAnalysisSetting = groupsPerGapAnalysisSetting::whereNull('deleted_at')->get();
        $employee = employee_data::whereNull('deleted_at')->get();

        return view("admin.completion-tracker-assignment.edit")->with(compact('employee','groupsPerGapAnalysisSetting','completionTrackerAssignment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\completionTrackerAssignment  $completionTrackerAssignment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $completionTrackerAssignment = completionTrackerAssignment::find($id);
        $completionTrackerAssignment->employeeID = $request->input('employeeDropdown');
        $completionTrackerAssignment->gpgas_id_foreign = $request->input('gpgasDropdown');
        $completionTrackerAssignment->save();

        return \Redirect::route('completionTrackers.index')->with('success', 'Completion Tracker Assignment successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\completionTrackerAssignment  $completionTrackerAssignment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $completionTrackerAssignment = completionTrackerAssignment::find($id);
        $completionTrackerAssignment->delete();
        return \Redirect::route('completionTrackers.index')->with('success', 'Completion Tracker Assignment successfully deleted.');
    }
}
