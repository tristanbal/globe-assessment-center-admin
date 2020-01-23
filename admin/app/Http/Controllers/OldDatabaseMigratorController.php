<?php

namespace App\Http\Controllers;

use App\oldDatabaseMigrator;
use App\employee_data;
use App\assessment;
use App\role;
use App\evaluation;
use App\evaluationCompetency;
use App\competency;
use App\competencyType;

use Illuminate\Http\Request;
use App\Imports\migratorImport;
use Maatwebsite\Excel\Facades\Excel;

ini_set('max_execution_time', 12000);
ini_set('memory_limit', '4095M');


class OldDatabaseMigratorController extends Controller
{

    //
    public function showUploaderForm()
    {
        //return 'success';
        return view('admin.uploader.evaluation')->with(compact(''));
    }

    public function import(Request $request) 
    {
        //return 'test';
        
        
        $path1 = $request->file('import_file')->store('temp'); 
        $path=storage_path('app').'/'.$path1;
        

        $this->truncateUploaderTable();

        Excel::import(new migratorImport, $path);
        
        
        $uploadErrors = $this->populateAssessmentsTable();
        if(!empty($uploadErrors)){
            $error = '';
            foreach($uploadErrors as $uploadError){
                $error = $error.$uploadError->reason."\r\n";
            }
            $error = "ERROR: UNABLE TO UPLOAD ".count($uploadErrors)." LINES FROM THE FILE UPLOAD \r\n \r\n".$error;
            return redirect('admin/uploader/evaluation')->with('error', $error);

        }
        
        $uploadErrors = $this->populateEvaluationsTable();
        if(!empty($uploadErrors)){
            $error = '';
            foreach($uploadErrors as $uploadError){
                $error = $error.$uploadError->reason."\r\n";
            }
            $error = "ERROR: UNABLE TO UPLOAD ".count($uploadErrors)." LINES FROM THE FILE UPLOAD \r\n \r\n".$error;
            return redirect('admin/uploader/evaluation')->with('error', $error);

        }
        
        
        $uploadErrors = $this->populateEvaluationCompetenciesTable();
        if(!empty($uploadErrors)){
            $error = '';
            foreach($uploadErrors as $uploadError){
                $error = $error.$uploadError->reason."\r\n";
            }
            $error = "ERROR: UNABLE TO UPLOAD ".count($uploadErrors)." LINES FROM THE FILE UPLOAD \r\n \r\n".$error;
            return redirect('admin/uploader/evaluation')->with('error', $error);

        }
        

        //return $groups;
        return redirect('admin/uploader/evaluation')->with('success', 'Evaluation successfully migrated.');
        //return redirect('/')->with('success', 'All good!');
    }

    public function truncateUploaderTable(){
        //Drop uploader data
        oldDatabaseMigrator::truncate();
    }

    public function populateAssessmentsTable(){
        $rowsNotImported = array();

        $oldDatabaseMigrator = oldDatabaseMigrator::orderBy('assessee','ASC')->orderBy('assessor','ASC')->get();

        foreach ($oldDatabaseMigrator as $oldDatabaseMigratorRow) {
            $assesseeEmployeeInfo = employee_data::where('employeeID',$oldDatabaseMigratorRow->assessee)->whereNull('deleted_at')->first();
            $assessorEmployeeInfo = employee_data::where('employeeID',$oldDatabaseMigratorRow->assessor)->whereNull('deleted_at')->first();
            $assessmentTypeValidator = null;
            $assessmentChecker = null;

            if($oldDatabaseMigratorRow->assessee == $oldDatabaseMigratorRow->assessor){
                $assessmentChecker = assessment::where('employeeID',$assesseeEmployeeInfo->id)->where('assessmentTypeID',1)->first();
                $assessmentTypeValidator = 1;
            }else{
                $assessmentChecker = assessment::where('employeeID',$assesseeEmployeeInfo->id)->where('assessmentTypeID',2)->first();
                $assessmentTypeValidator = 2;
            }

            if($assessmentChecker){
                //existing already
            }else{
                $insertAssessment = assessment::updateOrCreate(
                    ['employeeID' => $assesseeEmployeeInfo->id,
                    'evaluationVersionID'=> '0',
                    'assessmentTypeID' => $assessmentTypeValidator],
                    ['employeeID' => $assesseeEmployeeInfo->id,
                    'evaluationVersionID'=> '0',
                    'assessmentTypeID' => $assessmentTypeValidator,
                    'created_at' => $oldDatabaseMigratorRow->origCreated,
                    'updated_at' => $oldDatabaseMigratorRow->origUpdated]
                );
            }

        }
        return ($rowsNotImported);      
    }

    public function populateEvaluationsTable(){
        $rowsNotImported = array();

        $oldDatabaseMigrator = oldDatabaseMigrator::orderBy('assessee','ASC')->orderBy('assessor','ASC')->get();

        $assesseeIterator = null;
        $assessorIterator = null;

        foreach($oldDatabaseMigrator as $oldDatabaseMigratorRow){
            $assesseeEmployeeInfo = employee_data::where('employeeID',$oldDatabaseMigratorRow->assessee)->whereNull('deleted_at')->first();
            $assessorEmployeeInfo = employee_data::where('employeeID',$oldDatabaseMigratorRow->assessor)->whereNull('deleted_at')->first();
            $role = role::where('name',$oldDatabaseMigratorRow->role)->whereNull('deleted_at')->first();
            


            if(!isset($role)){
                $newRole = new role;
                $newRole->name = $oldDatabaseMigratorRow->role;
                $newRole->save();
                $role = role::where('name',$oldDatabaseMigratorRow->role)->whereNull('deleted_at')->first();
            }
            
            $assessmentTypeValidator = null;
            $assessmentChecker = null;

            if($oldDatabaseMigratorRow->assessee == $oldDatabaseMigratorRow->assessor){
                $assessmentChecker = assessment::where('employeeID',$assesseeEmployeeInfo->id)->where('assessmentTypeID',1)->first();
                $assessmentTypeValidator = 1;
            }else{
                $assessmentChecker = assessment::where('employeeID',$assesseeEmployeeInfo->id)->where('assessmentTypeID',2)->first();
                $assessmentTypeValidator = 2;
            }

            
            if ($assesseeEmployeeInfo != $assesseeIterator || $assessorEmployeeInfo != $assessorIterator) {
                if($assessmentChecker->evaluationVersionID == '0'){
                    $evaluationNew = new evaluation;
                    $evaluationNew->assessmentID = $assessmentChecker->id;
                    $evaluationNew->assesseeEmployeeID = $assesseeEmployeeInfo->id;
                    $evaluationNew->assessorEmployeeID = $assessorEmployeeInfo->id;
                    $evaluationNew->assesseeRoleID = $role->id;
                    $evaluationNew->assessorRoleID = $role->id;
                    $evaluationNew->created_at = $oldDatabaseMigratorRow->origUpdated;
                    $evaluationNew->save();
    
                    $initEvaluation = evaluation::where('assessmentID',$assessmentChecker->id)
                        ->where('assesseeEmployeeID',$assesseeEmployeeInfo->id)
                        ->where('assessorEmployeeID',$assessorEmployeeInfo->id)
                        ->where('assesseeRoleID',$role->id)
                        ->orderBy('updated_at','desc')
                        ->whereNull('deleted_at')
                        ->first();
                    
                    $assessmentUpdate = assessment::find($assessmentChecker->id);
                    $assessmentUpdate->evaluationVersionID = $initEvaluation->id;
                    $assessmentUpdate->save();
                    $sample = 'updated';
                }else{
                    $evaluationNew = new evaluation;
                    $evaluationNew->assessmentID = $assessmentChecker->id;
                    $evaluationNew->assesseeEmployeeID = $assesseeEmployeeInfo->id;
                    $evaluationNew->assessorEmployeeID = $assessorEmployeeInfo->id;
                    $evaluationNew->assesseeRoleID = $role->id;
                    $evaluationNew->assessorRoleID = $role->id;
                    $evaluationNew->created_at = $oldDatabaseMigratorRow->origUpdated;
                    $evaluationNew->save();
                }
            }

            
            $assesseeIterator = $assesseeEmployeeInfo;
            $assessorIterator = $assessorEmployeeInfo;
        }

        return ($rowsNotImported); 
    }

    public function populateEvaluationCompetenciesTable(){
        
        $rowsNotImported = array();

        $oldDatabaseMigrator = oldDatabaseMigrator::orderBy('assessee','ASC')->orderBy('assessor','ASC')->get();

        $assesseeIterator = null;
        $assessorIterator = null;

        foreach($oldDatabaseMigrator as $oldDatabaseMigratorRow){
            $assesseeEmployeeInfo = employee_data::where('employeeID',$oldDatabaseMigratorRow->assessee)->whereNull('deleted_at')->first();
            $assessorEmployeeInfo = employee_data::where('employeeID',$oldDatabaseMigratorRow->assessor)->whereNull('deleted_at')->first();
            $role = role::where('name',$oldDatabaseMigratorRow->role)->whereNull('deleted_at')->first();
            $competencyInfo = competency::where('name',$oldDatabaseMigratorRow->competency)->whereNull('deleted_at')->first();
            $competencyTypeInfo = competencyType::where('name',$oldDatabaseMigratorRow->competencyType)->whereNull('deleted_at')->first();


            if(!isset($role)){
                $newRole = new role;
                $newRole->name = $oldDatabaseMigratorRow->role;
                $newRole->save();
                $role = role::where('name',$oldDatabaseMigratorRow->role)->whereNull('deleted_at')->first();
            }
            
            $assessmentTypeValidator = null;
            $assessmentChecker = null;

            if($oldDatabaseMigratorRow->assessee == $oldDatabaseMigratorRow->assessor){
                $assessmentChecker = assessment::where('employeeID',$assesseeEmployeeInfo->id)->where('assessmentTypeID',1)->first();
                $assessmentTypeValidator = 1;
            }else{
                $assessmentChecker = assessment::where('employeeID',$assesseeEmployeeInfo->id)->where('assessmentTypeID',2)->first();
                $assessmentTypeValidator = 2;
            }

            $initEvaluation = evaluation::where('assessmentID',$assessmentChecker->id)
            ->where('assesseeEmployeeID',$assesseeEmployeeInfo->id)
            ->where('assessorEmployeeID',$assessorEmployeeInfo->id)
            ->where('assesseeRoleID',$role->id)
            ->orderBy('updated_at','desc')
            ->whereNull('deleted_at')
            ->first();

            if(!isset($initEvaluation)|| !isset($competencyInfo) || !isset($competencyTypeInfo) || !isset($role)){
                array_push($rowsNotImported, $oldDatabaseMigratorRow);
                end($rowsNotImported)->reason = end($rowsNotImported)->reason."\r\n".'ERROR DETAIL: '."\r\n";
                /*if(!isset($initEvaluation)){
                    end($initEvaluation)->reason = end($rowsNotImported)->reason.'Initial Evaluation not found in the database: '.$oldDatabaseMigratorRow->id;
                }*/
                if(!isset($competencyInfo)){
                    end($competencyInfo)->reason = end($rowsNotImported)->reason.'Competency name not found in the database: '.$oldDatabaseMigratorRow->competency;
                }
                if(!isset($competencyTypeInfo)){
                    end($competencyTypeInfo)->reason = end($rowsNotImported)->reason.'Competency Type name not found in the database: '.$oldDatabaseMigratorRow->competencyTypeInfo;
                }
                if(!isset($role)){
                    end($role)->reason = end($rowsNotImported)->reason.'Role not found in the database: '.$oldDatabaseMigratorRow->role;
                }
                end($rowsNotImported)->reason = end($rowsNotImported)->reason."\r\n"."\r\n".'FOR ROW: '."\r\n";
                end($rowsNotImported)->reason = end($rowsNotImported)->reason.'ID: '.$oldDatabaseMigratorRow->id."\r\n";
                end($rowsNotImported)->reason = end($rowsNotImported)->reason.'ROLE: '.$oldDatabaseMigratorRow->role."\r\n";
                end($rowsNotImported)->reason = end($rowsNotImported)->reason.'COMPETENCY: '.$oldDatabaseMigratorRow->competency."\r\n"; 
            }
            else{
                $evaluationCompetencyNew = evaluationCompetency::updateOrCreate(
                    ['evaluationID' => $initEvaluation->id,
                    'competencyID'=> $competencyInfo->id,
                    'competencyTypeID' => $competencyTypeInfo->id],
                    ['givenLevelID' => $oldDatabaseMigratorRow->givenLevelID,
                    'targetLevelID' => $oldDatabaseMigratorRow->targetLevelID,
                    'weightedScore' => $oldDatabaseMigratorRow->weightedScore,
                    'verbatim' => 'N/A',
                    'additional_file' => 'N/A',
                    'created_at' => $oldDatabaseMigratorRow->origCreated,
                    'updated_at' => $oldDatabaseMigratorRow->origUpdated]
                );
            }

            /*
            if ($initEvaluation) {
                $evaluationCompetencyNew = new evaluationCompetency;
                $evaluationCompetencyNew->evaluationID = $initEvaluation->id;
                $evaluationCompetencyNew->competencyID = $competencyInfo->id;
                $evaluationCompetencyNew->givenLevelID = $oldDatabaseMigratorRow->givenLevelID;
                $evaluationCompetencyNew->targetLevelID = $oldDatabaseMigratorRow->targetLevelID;
                $evaluationCompetencyNew->weightedScore = $oldDatabaseMigratorRow->weightedScore;
                $evaluationCompetencyNew->competencyTypeID = $competencyTypeInfo->id;
                $evaluationCompetencyNew->verbatim = 'N/A';
                $evaluationCompetencyNew->additional_file = 'N/A';
                $evaluationCompetencyNew->created_at = $oldDatabaseMigratorRow->origCreated;
                $evaluationCompetencyNew->updated_at = $oldDatabaseMigratorRow->origUpdated;
                $evaluationCompetencyNew->save();
                
            }*/
        }

        return ($rowsNotImported); 
    }








    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\oldDatabaseMigrator  $oldDatabaseMigrator
     * @return \Illuminate\Http\Response
     */
    public function show(oldDatabaseMigrator $oldDatabaseMigrator)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\oldDatabaseMigrator  $oldDatabaseMigrator
     * @return \Illuminate\Http\Response
     */
    public function edit(oldDatabaseMigrator $oldDatabaseMigrator)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\oldDatabaseMigrator  $oldDatabaseMigrator
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, oldDatabaseMigrator $oldDatabaseMigrator)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\oldDatabaseMigrator  $oldDatabaseMigrator
     * @return \Illuminate\Http\Response
     */
    public function destroy(oldDatabaseMigrator $oldDatabaseMigrator)
    {
        //
    }
}
