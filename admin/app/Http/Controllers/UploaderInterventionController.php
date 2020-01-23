<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\interventionUploader;
use App\Imports\interventionImport;
use App\competency;
use App\training;
use App\group;
use App\division;
use App\intervention;
use Maatwebsite\Excel\Facades\Excel;
use DB;

ini_set('max_execution_time', 12000);
ini_set('memory_limit', '4095M');

class UploaderInterventionController extends Controller
{
    //
    public function showUploaderForm()
    {
        return view('admin.uploader.intervention')->with(compact(''));
    }

    public function import(Request $request)
    {
        $this->truncateUploaderTable();
        //$path = $request->file('import_file')->getRealPath();
        $path1 = $request->file('import_file')->store('temp'); 
        $path=storage_path('app').'/'.$path1;
        Excel::import(new interventionImport, $path);
        $this->populateTrainingTable();

        $message = $this->populateInterventionTable();
        //return $message;
        if($message){
            return redirect('admin/uploader/intervention')->with('success', 'Intervention partially uploaded. The following were not uploaded: '.$message);
        }else{
            return redirect('admin/uploader/intervention')->with('success', 'Intervention successfully uploaded.');
        }
        
        return $message;
    }

    private function truncateUploaderTable()
    {
        //Drop masterlist uploader data
        interventionUploader::truncate();
    }

    private function populateInterventionTable()
    {
        $listOfInterventions = interventionUploader::all();
        $message = null;
        
        foreach($listOfInterventions as $item){
            $group = group::where('name','=',$item->group)->whereNull('deleted_at')->first();
            $division = division::where('name','=',$item->division)->where('groupID','=',$group->id)->whereNull('deleted_at')->first();
            $competency = DB::table('competencies')->where('name', '=', $item->competency)->whereNull('deleted_at')->first();
            $training = DB::table('trainings')->where('name', '=', $item->training)->whereNull('deleted_at')->first();
            if(!isset($group)||!isset($division)||!isset($competency)||!isset($training)){
                $message .= $item->competency . ' - ' . $item->group .  ' - ' . $item->division . '. ';
            }else{
                $insertIntervention = intervention::updateOrCreate(
                    [
                        'groupID' => $group->id,
                        'divisionID' => $division->id,
                        'competencyID' => $competency->id,
                        'trainingID' => $training->id,
                    ],
                    [
                        'groupID' => $group->id,
                        'divisionID' => $division->id,
                        'competencyID' => $competency->id,
                        'trainingID' => $training->id,
                    ]
                );
            }
            
        }
        return $message;
    }

    private function populateTrainingTable()
    {
        // $employee = DB::table('employee_datas')->where('employeeID', '=', $id)->whereNull('deleted_at')->first();
        $trainingsFromMasterlist = interventionUploader::distinct()->get(['training']);

        foreach($trainingsFromMasterlist as $trainingFromMasterlist)
        {
            $insertTraining = training::updateOrCreate(
                ['name' => $trainingFromMasterlist->training]
            );
        }
    }
/*
    private function populateInterventionTable()
    {
        $interventionsFromUploader = interventionUploader::all();

        $message = null;
        foreach($interventionsFromUploader as $interventionFromUploader)
        {
            $competency = DB::table('competencies')->where('name', '=', $interventionFromUploader->competency)->whereNull('deleted_at')->first();
            $training = DB::table('trainings')->where('name', '=', $interventionFromUploader->training)->whereNull('deleted_at')->first();
            if(!isset($competency) || !isset($training)){
                $message .= $interventionFromUploader->competency . '. ';
            }else {
                $insertEmployee = intervention::updateOrCreate(
                    [
                        'competencyID' => $competency->id,
                        'trainingID' => $training->id
                    ],
                    [
                        'competencyID' => $competency->id,
                        'trainingID' => $training->id
                    ]
                );
                //$message .= $interventionFromUploader->competency . ', ';
            }
        }

        return $message;
    }*/
}
