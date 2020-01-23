<?php

namespace App\Http\Controllers;

use App\assessment;
use App\assessmentType;
use App\competency;
use App\competencyType;
use App\competencyPerRoleTarget;
use App\division;
use App\employee_data;
use App\employeeRelationship;
use App\evaluation;
use App\evaluationCompetency;
use App\intervention;
use App\level;
use App\listOfCompetenciesPerRole;
use App\training;
use App\role;
use App\gapAnalysisSetting;
use App\gapAnalysisSettingAssessmentType;
use App\group;
use App\targetSource;
use Illuminate\Http\Request;
use DB;
use stdClass;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewEmployeePerGroup()
    {
        $gapSettings = gapAnalysisSetting::whereNull('deleted_at')
        ->get();

        $gapSettingsAssessmentTypes = gapAnalysisSettingAssessmentType::whereNull('deleted_at')
        ->get();

        $assessmentTypes = assessmentType::whereNull('deleted_at')->get();
        $gapanalysisSettings = gapAnalysisSetting::whereNull('deleted_at')->get();

        return view('admin.report.individual.view-employee-per-group')->with(compact('assessmentTypes', 'gapanalysisSettings', 'gapSettings', 'gapSettingsAssessmentTypes'));
    }

    public function viewAll($groupID)
    {
        $id = $groupID;

        $group = group::find($groupID);
        $gapSettings = gapAnalysisSetting::whereNull('deleted_at')
        ->get();

        $gapSettingsAssessmentTypes = gapAnalysisSettingAssessmentType::whereNull('deleted_at')
        ->get();

        $assessmentTypes = assessmentType::whereNull('deleted_at')->get();
        $gapanalysisSettings = gapAnalysisSetting::whereNull('deleted_at')->get();

        return view('admin.report.individual.view-all')->with(compact('group','id','assessmentTypes', 'gapanalysisSettings', 'gapSettings', 'gapSettingsAssessmentTypes'));
    }

    public function getEmployeePergroup($id)
    {
        $data = employee_data::select('id','employeeID','firstname','lastname', 'email')
            ->where('groupID', $id)
            ->whereNull('deleted_at')
            ->get();
        return datatables($data)->toJson();
    }

    public function reportEmployeeView($id)
    {
        $competencyTypes = competencyType::whereNull('deleted_at')->get();
        $employee = employee_data::find($id);
        $group = group::whereNull('deleted_at')->where('id', $employee->groupID)->first();
        $divisions = division::select('id')->where('groupID', $employee->groupID)->whereNull('deleted_at')->get();
        $interventions = intervention::whereNull('deleted_at')->get();
        $trainings = training::whereNull('deleted_at')->get();
        $supervisor = employee_data::whereNull('deleted_at')->where('employeeID', $employee->supervisorID)->first();

        $assessment = assessment::where('employeeID',$employee->id)->first();
        $evaluation = evaluation::where('assesseeEmployeeID',$assessment->employeeID)->first();

        $competencyTargets = DB::select('
            select compRoleTarget.id, compRoleTarget.roleID, compRoleTarget.competencyID, compRoleTarget.competencyTargetID, compRoleTarget.sourceID, target.name as targetName from (select * from competency_per_role_targets where deleted_at is null) as compRoleTarget
            join 
            (select * from target_sources where deleted_at is null) as target
            on 
            compRoleTarget.sourceID = target.id
            where compRoleTarget.roleID = '.$evaluation->assesseeRoleID.'');

        if($competencyTargets) {
            $targetSources = targetSource::whereNull('deleted_at')->where('id', $competencyTargets[0]->sourceID)->first();
        }

        $competencyTargetNames = DB::select('
            select DISTINCT target.name as targetName from (select * from competency_per_role_targets where deleted_at is null) as compRoleTarget
            join 
            (select * from target_sources where deleted_at is null) as target
            on 
            compRoleTarget.sourceID = target.id
            where compRoleTarget.roleID = '.$evaluation->assesseeRoleID.'');
        

        
        //return $competencyTargetNames;
        // dd($targetSources->name);

        // jinoin ko lang naman yung 5 tables dun ko sinelect yung mga kailangan na ang output ay makuha yung assessment na nakaactive sa gap settings. then pagcocompare ko yung roleID  which is yung condition sa baba
        $assessments = DB::select('
            select eval.id, ass_type.name, gap_set_type.percentAssigned, eval.assesseeEmployeeID, eval.assessorEmployeeID, eval.assesseeRoleID, eval.assessorRoleID from 
            (select * from gap_analysis_settings where is_active = 1 and deleted_at is NULL) as gap_set 
            join 
            (select * from gap_analysis_setting_assessment_types where deleted_at is NULL) as gap_set_type 
            on gap_set.id = gap_set_type.gas_id_foreign 
            join 
            (select * from assessments where assessments.employeeID = '.$id.' and deleted_at is NULL) as ass 
            on ass.assessmentTypeID = gap_set_type.assessmentTypeID 
            join 
            (select * from evaluations where deleted_at is NULL) as eval 
            on ass.evaluationVersionID = eval.id
            join 
            (select * from assessment_types where deleted_at is NULL) as ass_type 
            on ass.assessmentTypeID = ass_type.id');

        $ctr = count($assessments);

        // if ang roleID ay magkakaparehas sa lahat ng rows papasok sya sa loob ng condition pag hindi mag dedeclare sya ng variable na walang laman. so lahat na lumabas sa assessment table na equal sa employeeID ay macacount, ibigsabihin di ko pa naayos yung sa versioning. kaya kapag nasama sya sa assessment macacount din sya as gap.

        $assessmentColumnRoleID = array_column($assessments, "assesseeRoleID");
        if($assessments) {
            if($assessmentColumnRoleID == array_fill(0, count($assessmentColumnRoleID), $assessments[0]->assesseeRoleID)) {

                // ito naman yung gapanalysis score lang to ng assessee and assessor para makuha yung binigay nilang score and percentage as weightscore. 

                $gapanalysis = DB::select('
                   select eval.id, ass_type.name, comp.name as competencyName, level.levelName as levelName, (gap_set_type.percentAssigned / 100 * eval_comp.givenLevelID) as weightScore, eval.assesseeEmployeeID, eval.assessorEmployeeID, eval.assesseeRoleID, eval.assessorRoleID, eval_comp.competencyID, eval_comp.givenLevelID, eval_comp.competencyTypeID, eval_comp.verbatim, empData.assEmpID, empData.empFirstName as assessorFirstName, empData.empLastname as assessorLastName, eval_comp.created_at as assDate from 
                    (select * from gap_analysis_settings where is_active = 1 and deleted_at is NULL) as gap_set 
                    join 
                    (select * from gap_analysis_setting_assessment_types where deleted_at is NULL) as gap_set_type 
                    on gap_set.id = gap_set_type.gas_id_foreign 
                    join 
                    (select * from assessments where assessments.employeeID = '.$id.' and deleted_at is NULL) as ass 
                    on ass.assessmentTypeID = gap_set_type.assessmentTypeID 
                    join 
                    (select * from evaluations where deleted_at is NULL) as eval 
                    on ass.evaluationVersionID = eval.id
                    join
                    (select * from assessment_types where deleted_at is NULL) as ass_type 
                    on ass.assessmentTypeID = ass_type.id
                    join 
                    (select * from evaluation_competencies where deleted_at is NULL) as eval_comp
                    on eval_comp.evaluationID = eval.id
                    join
                    (select id, name as levelName, weight as weightLevel from levels where deleted_at is NULL) as level
                    on level.id = eval_comp.givenLevelID
                    join
                    (select * from competencies where deleted_at is NULL) as comp 
                    on eval_comp.competencyID = comp.id
                    join
                    (select id,employeeID as assEmpID, firstname as empFirstName, lastname as empLastName from employee_datas where employee_datas.firstname <> "employee" and deleted_at is NULL) as empData
                    on eval.assessorEmployeeID = empData.id');

                  // ito naman list lang ng competencies ng employee.
   

                $competencies = DB::select('
                    select *, (targetLevelID - totalWeight ) as gap from 
                    (select *, sum(weightScore) as totalWeight from (
                    select comp.id, comp.name, (gap_set_type.percentAssigned / 100 * eval_comp.givenLevelID)                             
                    as weightScore, comp_type.compTypeName, eval_comp.targetLevelID, eval_comp.competencyID, comp.definition from 
                    (select * from gap_analysis_settings where is_active = 1 and deleted_at is NULL) as gap_set 
                    join 
                    (select * from gap_analysis_setting_assessment_types where deleted_at is NULL) as gap_set_type 
                    on gap_set.id = gap_set_type.gas_id_foreign 
                    join 
                    (select * from assessments where assessments.employeeID = '.$id.' and deleted_at is NULL) as ass 
                    on ass.assessmentTypeID = gap_set_type.assessmentTypeID 
                    join 
                    (select * from evaluations where deleted_at is NULL) as eval 
                    on ass.evaluationVersionID = eval.id
                    join 
                    (select * from assessment_types where deleted_at is NULL) as ass_type 
                    on ass.assessmentTypeID = ass_type.id
                    join 
                    (select * from evaluation_competencies where deleted_at is NULL) as eval_comp
                    on eval_comp.evaluationID = eval.id
                    join 
                    (select * from competencies where deleted_at is NULL) as comp 
                    on eval_comp.competencyID = comp.id
                    join 
                    (select id, name as compTypeName, definition from competency_types where deleted_at is NULL) as comp_type
                    on eval_comp.competencyTypeID = comp_type.id
                    ) as sumTotalWeight
                    group by sumTotalWeight.id
                    ) as gapAnalysis
                    order by gap desc'); 

                // ito naman list lnag ng assessment types na nakaactive sa gap settings.

                $assessmentTypes = DB::select('
                    select eval.id, ass_type.name, role.roleName, eval.assessorEmployeeID from 
                    (select * from gap_analysis_settings where is_active = 1 and deleted_at is NULL) as gap_set 
                    join 
                    (select * from gap_analysis_setting_assessment_types where deleted_at is NULL) as gap_set_type 
                    on gap_set.id = gap_set_type.gas_id_foreign 
                    join 
                    (select * from assessments where assessments.employeeID = '.$id.' and deleted_at is NULL) as ass 
                    on ass.assessmentTypeID = gap_set_type.assessmentTypeID 
                    join 
                    (select * from evaluations where deleted_at is NULL) as eval 
                    on ass.evaluationVersionID = eval.id
                    join 
                    (select * from assessment_types where deleted_at is NULL) as ass_type 
                    on ass.assessmentTypeID = ass_type.id
                    join 
                    (select id, name as roleName from roles where deleted_at is NULL) as role 
                    on role.id = eval.assesseeRoleID');
                
            } 
        } else {
            $assessmentTypes = null;
            $competencies = null;
            $gapanalysis = null;
        }


        //Completion Checker
        $assessmentCompletion = assessment::where('employeeID',$id)->get();
        $completionTrackerIndividual = array();
        if($assessmentCompletion){
            foreach($assessmentCompletion as $assessmentCompletionItem){
                $evaluationCompletion = evaluation::find($assessmentCompletionItem->evaluationVersionID);
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

        $verbatimChecker = array();
        foreach($gapanalysis as $gapVerbatim){
            if($gapVerbatim->verbatim != 'N/A'){
                array_push($verbatimChecker,'1');
            }
        }
        //return count($verbatimChecker);

        //return $completionTrackerIndividual;
        // dd($gapanalysis);
        
        //return $divisions;
        //return $gapanalysis;
        //return $assessmentTypes;
        return view('admin.report.individual.view-employee')->with(compact('verbatimChecker','competencyTargetNames','completionTrackerIndividual','assessmentTypes', 'competencies', 'gapanalysis', 'employee', 'competencyTypes', 'divisions', 'interventions', 'trainings', 'group', 'supervisor', 'competencyTargets', 'targetSources'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function filteredEmployees(Request $request)
    {
        $countSelected = count($request->selected);

        foreach ($request->selected as $key => $select) {


            $assessments[] = DB::select('
                select eval.id, ass_type.name, gap_set_type.percentAssigned, eval.assesseeEmployeeID, eval.assessorEmployeeID, eval.assesseeRoleID, eval.assessorRoleID from 
                (select * from gap_analysis_settings where is_active = 1 and deleted_at is NULL) as gap_set 
                join 
                (select * from gap_analysis_setting_assessment_types where deleted_at is NULL) as gap_set_type 
                on gap_set.id = gap_set_type.gapAnalysisSettingID 
                join 
                (select * from assessments where assessments.employeeID = '.$select.' and deleted_at is NULL) as ass 
                on ass.assessmentTypeID = gap_set_type.assessmentTypeID 
                join 
                (select * from evaluations where deleted_at is NULL) as eval 
                on ass.evaluationVersionID = eval.id
                join 
                (select * from assessment_types where deleted_at is NULL) as ass_type 
                on ass.assessmentTypeID = ass_type.id');

        }

        for ($i=0; $i < $countSelected; $i++) { 
            if($assessments[$i] != null)
            {
                $assessmentCounts = count($assessments[$i]);

                

            }
        }

        //return view('admin.report.individual.filtered-employee');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addCompetencyTarget(Request $request)
    {

        $ctrCompetencies = count($request->competencies);

        for ($i=0; $i < $ctrCompetencies; $i++) { 

            if (competencyPerRoleTarget::where('competencyID', '=', $request->competencies[$i])->exists()) {

                DB::table('competency_per_role_targets')
                ->where('competencyID', $request->competencies[$i])
                ->update(['competencyTarget' => $request->target[$i]]);

            }
            else {

                $competencyPerRoleTarget = new competencyPerRoleTarget;

                $competencyPerRoleTarget->roleID = $request->roleID;
                $competencyPerRoleTarget->competencyID = $request->competencies[$i];
                $competencyPerRoleTarget->competencyTarget = $request->target[$i];

                $competencyPerRoleTarget->save();

            }

        }

        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function removeCompetencyTarget(Request $request)
    {
        $competency = competencyPerRoleTarget::find($request->targetID);

        $competency->delete();

        return redirect()->back();
    }

    public function viewAllGroups()
    {
        $gapSettings = gapAnalysisSetting::whereNull('deleted_at')
        ->get();

        $gapSettingsAssessmentTypes = gapAnalysisSettingAssessmentType::whereNull('deleted_at')
        ->get();

        $assessmentTypes = assessmentType::whereNull('deleted_at')->get();
        $gapanalysisSettings = gapAnalysisSetting::whereNull('deleted_at')->get();

        return view('admin.report.group.view-all-groups')->with(compact('assessmentTypes', 'gapanalysisSettings', 'gapSettings', 'gapSettingsAssessmentTypes'));
    }

    public function viewGroupsPerRole($groupID)
    {
        $group = group::whereNull('deleted_at')->where('id', $groupID)->first();
        // dd($group);

        $gapSettings = gapAnalysisSetting::whereNull('deleted_at')
        ->get();

        $gapSettingsAssessmentTypes = gapAnalysisSettingAssessmentType::whereNull('deleted_at')
        ->get();

        $assessmentTypes = assessmentType::whereNull('deleted_at')->get();
        $gapanalysisSettings = gapAnalysisSetting::whereNull('deleted_at')->get();

        $roles = DB::select('select roles.id, roles.name from list_of_competencies_per_roles
                            join roles on list_of_competencies_per_roles.roleID = roles.id 
                            where list_of_competencies_per_roles.groupID = '.$groupID.' 
                            group by roleID');

        // dd($roles);

        return view('admin.report.group.view-groups-per-role')->with(compact('roles', 'group', 'assessmentTypes', 'gapanalysisSettings', 'gapSettings', 'gapSettingsAssessmentTypes'));
    }

    public function viewRole($id)
    {
        $role = role::whereNull('deleted_at')->where('id', $id)->first();
        $groupID = listOfCompetenciesPerRole::whereNull('deleted_at')->where('roleID', $id)->first();

        // dd($role);

        $listOfCompetenciesPerRoles = DB::select('select comp.id, grp.name as grpName, compType.name as compType, comp.name as competency, role.name as roleName from 
            (select * from list_of_competencies_per_roles where deleted_at is null) as listOfCompetencies
            join 
            (select * from groups where deleted_at is null) as grp
            on listOfCompetencies.groupID = grp.id
            join 
            (select * from roles where deleted_at is null) as role
            on listOfCompetencies.roleID = role.id
            join
            (select * from competency_types where deleted_at is null) as compType
            on listOfCompetencies.competencyTypeID = compType.id
            join 
            (select * from competencies where deleted_at is null) as comp
            on listOfCompetencies.competencyID = comp.id
            where listOfCompetencies.roleID = '.$id.'
            order by comp.id');

        $gapAnalysis = DB::select('select gapAnalysis.competencyID, gapAnalysis.averageGap, gapAnalysis.failedTally, gapAnalysis.passedTally, gapAnalysis.overallTally from 
            (
            select listOfCompetencies.employeeID, listOfCompetencies.competencyID, listOfCompetencies.givenLevelID, listOfCompetencies.targetLevelID, listOfCompetencies.weightedScore as weightedScore, listOfCompetencies.competencyTypeID, round(avg(listOfCompetencies.weightedScore - listOfCompetencies.targetLevelID),2) as averageGap, count(case when listOfCompetencies.targetLevelID > listOfCompetencies.weightedScore then 1 end) as failedTally, count(case when listOfCompetencies.targetLevelID <= listOfCompetencies.weightedScore then 1 end) as passedTally, count(listOfCompetencies.competencyID) as overallTally from 
            (
            select competencyScore.employeeID, competencyScore.competencyID, competencyScore.givenLevelID, competencyScore.targetLevelID, sum((competencyScore.percentAssigned / 100 * competencyScore.weightedScore)) as weightedScore, competencyScore.competencyTypeID, competencyScore.assesseeEmployeeID from 
            (
            select ass.employeeID, evalComp.competencyID, evalComp.givenLevelID, evalComp.targetLevelID, evalComp.weightedScore, evalComp.competencyTypeID, verbatim, gap_set_type.percentAssigned, eval.assesseeEmployeeID from (select * from gap_analysis_settings where is_active = 1 and deleted_at is NULL) as gap_set 
            join 
            (select * from gap_analysis_setting_assessment_types where deleted_at is NULL) as gap_set_type 
            on gap_set.id = gap_set_type.gapAnalysisSettingID 
            join 
            (select * from assessments where deleted_at is NULL) as ass 
            on ass.assessmentTypeID = gap_set_type.assessmentTypeID
            join
            (select * from evaluations where assesseeRoleID = '.$id.') as eval 
            on eval.assessmentID = ass.id
            join
            (select * from evaluation_competencies where deleted_at is NULL) as evalComp
            on evalComp.evaluationID = eval.id ) as competencyScore
            join 
            (select * from employee_datas) as empData
            on competencyScore.assesseeEmployeeID = empData.employeeID

            group by competencyScore.competencyID, competencyScore.employeeID ) as listOfCompetencies  
            group by listOfCompetencies.competencyID) as gapAnalysis');

        // dd($gapAnalysis);



        // dd($listOfCompetenciesPerRoles);

        return view('admin.report.group.view-role')->with(compact('role', 'listOfCompetenciesPerRoles', 'gapAnalysis', 'groupID'));
    }

    public function filteredRoles(Request $request) 
    {
        $roleArray = array();

        //New Version of Group Report

        $gapAnalysisSettings = gapAnalysisSetting::whereNull('deleted_at')->where('is_active',1)->first();
        $gapAnalysisAssessmentTypeSettings = gapAnalysisSettingAssessmentType::whereNull('deleted_at')->where('gapAnalysisSettingID',$gapAnalysisSettings->id)->get();
        //return $gapAnalysisAssessmentTypeSettings;
        $selectedRoleArray = array();

        $gapAnalysisNew = array();


        foreach($request->selected as $selectedRoles){
            
            $arrayRow = new stdClass;
            //Count All Employees with Role

            $targetEmployees = employee_data::where('roleID',$selectedRoles)->whereNull('deleted_at')->get();
                                
            $countTarget = 0;
            //Memory Efficient
            for($i=0;$i<count($targetEmployees);$i++){
                $employeeRelationship = employeeRelationship::where('relationshipID',1)
                    ->where('assesseeEmployeeID',$targetEmployees[$i]->employeeID)
                    ->where('is_active',1)
                    ->whereNull('deleted_at')
                    ->first();
                if($employeeRelationship){
                    $countTarget++;
                }
            }


            $arrayRow->populationPerRole = $countTarget;
            //Get Role Name
            $arrayRow->roleName = role::find($selectedRoles)->name;
            //Count All 
            
            $countAssessed = 0;
            $model = listOfCompetenciesPerRole::where('roleID',$selectedRoles)->whereNull('deleted_at')->get();
            $countModel = count($model);
            //Memory Efficient 
            
            for($i=0;$i<count($targetEmployees);$i++){
                $settingCount = 0;
                foreach($gapAnalysisAssessmentTypeSettings as $settings){
                    $assessmentType = assessmentType::where('id',$settings->assessmentTypeID)->whereNull('deleted_at')->first();
                    $employeeRelationship = employeeRelationship::where('relationshipID',$assessmentType->relationshipID)
                        ->where('assesseeEmployeeID',$targetEmployees[$i]->employeeID)
                        ->where('is_active',1)
                        ->whereNull('deleted_at')
                        ->first();
                    
                    if($employeeRelationship){
                        $assessment = assessment::where('employeeID',$employeeRelationship->assesseeEmployeeID)->where('assessmentTypeID',$settings->assessmentTypeID)->whereNull('deleted_at')->first();
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
                                        //$countAssessed++;
                                        $settingCount++;
                                    }
                                }
                            } 
                        }
                    }
                }
                
                //return count($gapAnalysisAssessmentTypeSettings);
                if($settingCount == count($gapAnalysisAssessmentTypeSettings)){
                    $countAssessed++;
                }
                
            }
            

            $arrayRow->completeAssess = $countAssessed;
            array_push($roleArray,$arrayRow);

            
            $role = role::find($selectedRoles);
            $gapAnalysisNew[$role->name] = array();
            $modelDetail = listOfCompetenciesPerRole::where('roleID',$selectedRoles)->whereNull('deleted_at')->first();
            $group = group::where('id',$modelDetail->groupID)->whereNull('deleted_at')->first();
            for($k = 0;$k<count($model);$k++){
                $gapAnalysisCompetency = new stdClass;

                $competencyType = competencyType::find($model[$k]->competencyTypeID);
                $competency = competency::find($model[$k]->competencyID);
                
                $gapAnalysisCompetency->selfGroup = $group->name;
                $gapAnalysisCompetency->selfRoleName = $role->name;
                $gapAnalysisCompetency->selfType = $competencyType->name;
                $gapAnalysisCompetency->selfCompetency = $competency->name;
                $gapAnalysisCompetency->selfDefinition = $competency->definition;

                $gapFailedTally = 0;
                $gapPassedTally = 0;
                $gapCountPerCompetency = 0;
                $gapTotalPerCompetency = 0;
                $gapAveragePerCompetency = 0;
                for($i=0;$i<count($targetEmployees);$i++){
                    $settingCount = 0;
                    foreach($gapAnalysisAssessmentTypeSettings as $settings){
                        $assessmentType = assessmentType::where('id',$settings->assessmentTypeID)->whereNull('deleted_at')->first();
                        $employeeRelationship = employeeRelationship::where('relationshipID',$assessmentType->relationshipID)
                            ->where('assesseeEmployeeID',$targetEmployees[$i]->employeeID)
                            ->where('is_active',1)
                            ->whereNull('deleted_at')
                            ->first();
                        
                        if($employeeRelationship){
                            $assessment = assessment::where('employeeID',$employeeRelationship->assesseeEmployeeID)->where('assessmentTypeID',$settings->assessmentTypeID)->whereNull('deleted_at')->first();
                            if($assessment){
                                $evaluation = evaluation::where('id',$assessment->evaluationVersionID)->whereNull('deleted_at')->first();
                                if($evaluation){
                                    $evaluationCompetency = evaluationCompetency::where('evaluationID',$evaluation->id)->whereNull('deleted_at')->get();
                                    if($evaluationCompetency){
                                        $model_evaluation_counter = 0;
                                        $evaluationCompetencyRow = evaluationCompetency::where('evaluationID',$evaluation->id)->where('competencyID',$competency->id)->whereNull('deleted_at')->first();
                                        $modelCompetencyRow = listOfCompetenciesPerRole::where('roleID',$role->id)->where('competencyID',$competency->id)->whereNull('deleted_at')->first();
                                        //return $evaluationCompetencyRow;
                                        if($evaluationCompetencyRow && $modelCompetencyRow){
                                            $gapChecker = $modelCompetencyRow->targetLevelID - 1  - $evaluationCompetencyRow->weightedScore;
                                            $gapTotalPerCompetency = $gapTotalPerCompetency + $gapChecker;
                                            $gapCountPerCompetency++;
                                            
                                            if($gapChecker >= 0){
                                                $gapPassedTally++;
                                                echo 'true';
                                            }elseif($gapChecker < 0){
                                                $gapFailedTally++;
                                                echo 'false';
                                            }
                                            
                                        }
                                        
                                        /*
                                        foreach ($model as $modelItem) {
                                            $evaluationChecker = evaluationCompetency::where('competencyID',$modelItem->competencyID)->where('evaluationID',$evaluation->id)->whereNull('deleted_at')->first();
                                            if ($evaluationChecker) {
                                                $model_evaluation_counter++;
                                            }
                                        }
                                        
                                        if($model_evaluation_counter == $countModel){
                                            //$countAssessed++;
                                            $settingCount++;
                                        }*/
                                    }
                                } 
                            }
                        }
                    }
                    
                    //return count($gapAnalysisAssessmentTypeSettings);
                    if($settingCount == count($gapAnalysisAssessmentTypeSettings)){
                        //$countAssessed++;
                        //$gapAveragePerCompetency = 
                    }
                    
                }
                $gapAnalysisCompetency->gap = 0;
                if($gapTotalPerCompetency != 0 || $gapCountPerCompetency != 0){
                    $gapAveragePerCompetency = $gapTotalPerCompetency / $gapCountPerCompetency;
                
                    $gapAnalysisCompetency->gap = $gapAveragePerCompetency;
                }
                $gapAnalysisCompetency->FailedTally = $gapFailedTally;
                $gapAnalysisCompetency->PassedTally = $gapPassedTally;
                $gapAnalysisCompetency->OverallTally = $gapCountPerCompetency;
                
                /*
                $gapAnalysisCompetency->failedTally = ;
                */
                array_push($gapAnalysisNew[$role->name],$gapAnalysisCompetency);

            }
            //$gapAnalysisNew[$rolesRow->selectedRoles->name] = ;

            $gapAnalysis[] = DB::select('select gapAnalysis.competencyID, gapAnalysis.averageGap, gapAnalysis.failedTally, gapAnalysis.passedTally, gapAnalysis.overallTally from 
            (
            select listOfCompetencies.employeeID, listOfCompetencies.competencyID, listOfCompetencies.givenLevelID, listOfCompetencies.targetLevelID, listOfCompetencies.weightedScore as weightedScore, listOfCompetencies.competencyTypeID, round(avg(listOfCompetencies.weightedScore - listOfCompetencies.targetLevelID),2) as averageGap, count(case when listOfCompetencies.targetLevelID > listOfCompetencies.weightedScore then 1 end) as failedTally, count(case when listOfCompetencies.targetLevelID <= listOfCompetencies.weightedScore then 1 end) as passedTally, count(listOfCompetencies.competencyID) as overallTally from 
            (
            select competencyScore.employeeID, competencyScore.competencyID, competencyScore.givenLevelID, competencyScore.targetLevelID, sum((competencyScore.percentAssigned / 100 * competencyScore.weightedScore)) as weightedScore, competencyScore.competencyTypeID, competencyScore.assesseeEmployeeID from 
            (
            select ass.employeeID, evalComp.competencyID, evalComp.givenLevelID, evalComp.targetLevelID, evalComp.weightedScore, evalComp.competencyTypeID, verbatim, gap_set_type.percentAssigned, eval.assesseeEmployeeID from (select * from gap_analysis_settings where is_active = 1 and deleted_at is NULL) as gap_set 
            join 
            (select * from gap_analysis_setting_assessment_types where deleted_at is NULL) as gap_set_type 
            on gap_set.id = gap_set_type.gapAnalysisSettingID 
            join 
            (select * from assessments where deleted_at is NULL) as ass 
            on ass.assessmentTypeID = gap_set_type.assessmentTypeID
            join
            (select * from evaluations where assesseeRoleID = '.$selectedRoles.') as eval 
            on eval.assessmentID = ass.id
            join
            (select * from evaluation_competencies where deleted_at is NULL) as evalComp
            on evalComp.evaluationID = eval.id ) as competencyScore
            join 
            (select * from employee_datas) as empData
            on competencyScore.assesseeEmployeeID = empData.employeeID

            group by competencyScore.competencyID, competencyScore.employeeID ) as listOfCompetencies  
            group by listOfCompetencies.competencyID) as gapAnalysis');

            $listOfCompetenciesPerRoles[] = DB::select('select competencies.id, competencies.name from list_of_competencies_per_roles join competencies on list_of_competencies_per_roles.competencyID = competencies.id where list_of_competencies_per_roles.deleted_at is null and list_of_competencies_per_roles.roleID = '.$selectedRoles.'');

        }


        //return $this->checkEvaluation(6);
        //return $model;
        return dd($gapAnalysisNew);

        //return $gapAnalysis;
        return view('admin.report.group.filtered-roles')->with(compact('roleArray', 'listOfCompetenciesPerRoles', 'gapAnalysis'));
    }


    public function checkEvaluation($targetEmployees)
    {
        return $targetEmployees + 1;
    }
}
