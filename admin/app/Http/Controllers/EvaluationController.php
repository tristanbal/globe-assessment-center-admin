<?php

namespace App\Http\Controllers;

use App\evaluation;
use App\evaluationCompetency;
use App\employee_data;
use App\assessment;
use App\assessmentType;
use App\competency;
use App\competencyType;
use App\level;
use App\role;
use App\group;
use App\employeeRelationship;
use App\listOfCompetenciesPerRole;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use stdClass;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //$employee = assessment::whereNull('deleted_at')->get();

        $employee = DB::table('assessments')
            ->select('employee_datas.id as id','employee_datas.employeeID as employeeID','employee_datas.firstname as firstname','employee_datas.lastname as lastname','employee_datas.email as email','assessments.updated_at as updated_at')
            ->join('employee_datas','assessments.employeeID','=','employee_datas.id')
            ->whereNull('assessments.deleted_at')
            ->distinct()
            ->get();

        //return $employee;
        $assessmentType = assessmentType::whereNull('deleted_at')->get();
        return view("admin.evaluation.view-all")->with(compact(
            'assessmentType','employee'
        ));
    }

    public function assessmentSearch($id)
    {
        $assessmentTypeSearch = assessmentType::find($id);       
        return view("admin.evaluation.specific.view-assessmentType")->with(['id'=>$id]);
    }

    public function assessmentIndividual()
    {
        return view("admin.evaluation.individual.view-employee-all");
    }

    /*AJAX Data */
    public function getAllEmployee()
    {
        $data = employee_data::select('id','employeeID','firstname','lastname')
            ->whereNull('deleted_at')
            ->get();
        return datatables($data)->toJson();
    }

    public function getAssessmentSearch($id)
    {
        $assessmentTypeSearch = assessmentType::find($id);
        
        $employeeRelationshipSearch = DB::table('employee_relationships')
        ->select('employee_relationships.id as id','employee_datas.employeeID as employeeID','employee_datas.firstname as firstname','employee_datas.lastname as lastname')
        ->join('employee_datas','employee_relationships.assesseeEmployeeID','=','employee_datas.employeeID')
        ->whereNull('employee_relationships.deleted_at')
        ->where('employee_relationships.relationshipID','=',$assessmentTypeSearch->relationshipID)
        ->get();
        
        return datatables($employeeRelationshipSearch)->toJson();
    }

    /* Evaluation Views */
    public function evaluationSpecificView(Request $request,$employeeID)
    {
        $assesseeEmployee = employee_data::find($employeeID);
        $assesseeRole = role::find($assesseeEmployee->roleID);
        $model = listOfCompetenciesPerRole::where('roleID',$assesseeEmployee->roleID)->whereNull('deleted_at')->get();

        //Completion Checker
        $assessmentCompletion = assessment::where('employeeID',$employeeID)->get();
        $completionTrackerIndividual = array();
        //return $assessmentCompletion;
        if($assessmentCompletion){
            foreach($assessmentCompletion as $assessmentCompletionItem){
                $evaluationCompletion = evaluation::find($assessmentCompletionItem->evaluationVersionID);
                if($evaluationCompletion){
                    $completionCount = 0;
                    $modelChecker = listOfCompetenciesPerRole::where('roleID',$evaluationCompletion->assesseeRoleID)->whereNull('deleted_at')->get();
                    
                    if($modelChecker){
                        foreach($modelChecker as $modelCheckerItem){
                            $evaluationCompetencyChecker = evaluationCompetency::where('competencyID',$modelCheckerItem->competencyID)->first();
                            if($evaluationCompetencyChecker){
                                $completionCount++;
                            }
                        }
                    }
                    
                    $assessmentTypeCompletion = assessmentType::find($assessmentCompletionItem->assessmentTypeID);
    
                    $completionTrackerIndividualItem = new stdClass;
                    $completionTrackerIndividualItem->assessmentTypeID = $assessmentTypeCompletion->id;
                    $completionTrackerIndividualItem->assessmentType = $assessmentTypeCompletion->name;
                    $completionTrackerIndividualItem->completion = 0;
                    if(count($modelChecker) == $completionCount){
                        $completionTrackerIndividualItem->completion = 1;
                    }elseif(count($modelChecker) < $completionCount && count($modelChecker)>0){
                        $completionTrackerIndividualItem->completion = 2;
                    }else{
                        $completionTrackerIndividualItem->completion = 0;
                    }
                    array_push($completionTrackerIndividual,$completionTrackerIndividualItem);
                    
                }
                
            }
        }

        
        //Evaluations Versioning
        $assessment = assessment::where('employeeID',$assesseeEmployee->id)->whereNull('deleted_at')->get();

        $employeeRelationships = employeeRelationship::where('assesseeEmployeeID',$assesseeEmployee->id)
            ->whereNull('deleted_at')
            ->where('is_active',1)
            ->select('relationshipID')
            ->distinct()
            ->get();

        $assessmentType = array();
        foreach($employeeRelationships as $employeeRelationshipRow){
            $assessmentTypeCheck = assessmentType::find($employeeRelationshipRow->relationshipID);
            array_push($assessmentType,$assessmentTypeCheck);
        }
        
        $employeeRelationshipList = employeeRelationship::where('assesseeEmployeeID',$assesseeEmployee->id)
            ->whereNull('deleted_at')
            ->where('is_active',1)
            ->get();

        $evaluation = evaluation::where('assesseeEmployeeID',$assesseeEmployee->id)->whereNull('deleted_at')->get();
        $evaluationCompetency = evaluationCompetency::whereNull('deleted_at')->get();
        $competency = competency::whereNull('deleted_at')->get();
        $role = role::whereNull('deleted_at')->get();

        $answeredEvaluations = array();
        
        foreach($assessment as $assessments){
            foreach($evaluation as $evaluations){
                foreach($evaluationCompetency as  $evaluationCompetencies){
                    if ($assessments->evaluationVersionID == $evaluations->id &&
                        $evaluations->id == $evaluationCompetencies->evaluationID)  {

                        
                        $answeredRow = new StdClass;

                        $answeredRow->id = $evaluationCompetencies->id;
                        $assessmentTypeRow = assessmentType::find($assessments->assessmentTypeID);
                        $answeredRow->assessmentTypeID = $assessmentTypeRow->id;
                        $answeredRow->assessmentType = $assessmentTypeRow->name;

                        $assessorEmployee = employee_data::find($evaluations->assessorEmployeeID);
                        $answeredRow->assessorEmployeeID = $evaluations->assessorEmployeeID;
                        $answeredRow->assessorName = $assessorEmployee->firstname . ' ' . $assessorEmployee->lastname;

                        $roleRow = role::find($evaluations->assesseeRoleID);
                        $answeredRow->assesseeRoleID = $roleRow->name;

                        $competencyRow = competency::find($evaluationCompetencies->competencyID);
                        $answeredRow->competency = $competencyRow->name;

                        $competencyTypeRow = competencyType::find($evaluationCompetencies->competencyTypeID);
                        $answeredRow->competencyTypeID = $competencyTypeRow->id;
                        $answeredRow->competencyType = $competencyTypeRow->name;

                        if ($evaluationCompetencies->givenLevelID == 0) {
                            $levelActualScore = level::find(1);
                        }else {
                            $levelActualScore = level::find($evaluationCompetencies->givenLevelID);
                        }
                        $answeredRow->answeredScore = $levelActualScore->weight . ' - ' . $levelActualScore->name;
                        $answeredRow->verbatim = $evaluationCompetencies->verbatim;
    
                        array_push($answeredEvaluations,$answeredRow);
                    }
                }
            }
        }
        //return $evaluation;

        return view("admin.evaluation.monitoring.view")->with(compact(
            'competency',
            'assesseeEmployee',
            'assessment',
            'assessmentType',
            'evaluation',
            'evaluationCompetency',
            'employeeRelationshipList',
            'role',
            'answeredEvaluations',
            'assesseeRole',
            'model',
            'completionTrackerIndividual'
        ));
    }

    
    public function evaluationEmployeeView($employeeID)
    {
        //return $employeeID;
        $employee = employee_data::find($employeeID);
        $group = group::where('id',$employee->groupID)->whereNull('deleted_at')->first();
        $role = role::where('id',$employee->roleID)->whereNull('deleted_at')->first();

        return view("admin.evaluation.individual.view")->with(compact(
            'employee',
            'role',
            'group'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\evaluation  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function show(evaluation $evaluation)
    {
        //
        return 'show';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\evaluation  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function edit(evaluation $evaluation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\evaluation  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, evaluation $evaluation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\evaluation  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $evaluation = evaluation::find($id);
        $evaluation->delete();

        return Redirect::back()->with('success', 'Answer successfully deleted.');
    }
}
