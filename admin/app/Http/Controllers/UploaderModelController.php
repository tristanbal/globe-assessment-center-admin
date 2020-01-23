<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\competencyPerRoleUploader;
use App\group;
use App\role;
use App\competencyType;
use App\competency;
use App\listOfCompetenciesPerRole;
use App\level;
//use Excel;
use App\Imports\modelImport;
use Maatwebsite\Excel\Facades\Excel;

ini_set('max_execution_time', 12000);
ini_set('memory_limit', '4095M');

class UploaderModelController extends Controller
{
    //
    public function showUploaderForm()
    {
        return view('admin.uploader.model')->with(compact(''));
    }

    public function import(Request $request) 
    {
        //return 'test';
        $path1 = $request->file('import_file')->store('temp'); 
        $path=storage_path('app').'/'.$path1;
        

        $this->truncateUploaderTable();

        Excel::import(new modelImport, $path);

        $uploadErrors = $this->populateListOfCompetenciesTable();
        if(!empty($uploadErrors)){
            $error = '';
            foreach($uploadErrors as $uploadError){
                $error = $error.$uploadError->reason."\r\n";
            }
            $error = "ERROR: UNABLE TO UPLOAD ".count($uploadErrors)." LINES FROM THE FILE UPLOAD \r\n \r\n".$error;
            return redirect('admin/uploader/model')->with('error', $error);

        }
        
        

        //return $groups;
        return redirect('admin/uploader/model')->with('success', 'Model successfully uploaded.');
        //return redirect('/')->with('success', 'All good!');
    }

    private function checkIfUploadedFilesHasCorrectHeaders($headerRow){
        $requiredHeaders = ["groups","roles","competencies","competencytypes","targets"];

        if($headerRow != $requiredHeaders){
            return false;
        }
        return true;
    }

    private function truncateUploaderTable(){
        //Drop masterlist uploader data
        competencyPerRoleUploader::truncate();
    }

    //

    private function populateListOfCompetenciesTable(){
        $rowsNotImported = array();

        $listOfCompetenciesPerRoleFromModel = competencyPerRoleUploader::all();

        foreach($listOfCompetenciesPerRoleFromModel as $competencyPerRoleFromModel)
        {
            $group = group::where(['name'=>$competencyPerRoleFromModel->groupNames])->first();
            $role = role::where(['name'=>$competencyPerRoleFromModel->roleNames])->first();
            $competencyType = competencyType::where(['name'=>$competencyPerRoleFromModel->priorities])->first();
            $targetLevel = level::where(['weight'=>$competencyPerRoleFromModel->targetWeights])->first();
            $competency = competency::where(['name'=>$competencyPerRoleFromModel->competencyNames])->first();

            if(!isset($role)){
                $newRole = new role;
                $newRole->name = $competencyPerRoleFromModel->roleNames;
                $newRole->save();
                $role = role::where(['name'=>$competencyPerRoleFromModel->roleNames])->first();
            }


            if(!isset($competency)|| !isset($group) || !isset($competencyType) || !isset($targetLevel)){
                array_push($rowsNotImported, $competencyPerRoleFromModel);
                end($rowsNotImported)->reason = end($rowsNotImported)->reason."\r\n".'ERROR DETAIL: '."\r\n";
                if(!isset($competency)){
                    end($rowsNotImported)->reason = end($rowsNotImported)->reason.'Competency name not found in the database: '.$competencyPerRoleFromModel->competencyNames;
                }
                if(!isset($group)){
                    end($rowsNotImported)->reason = end($rowsNotImported)->reason.'Group name not found in the database: '.$competencyPerRoleFromModel->groupNames;
                }
                if(!isset($competencyType)){
                    end($rowsNotImported)->reason = end($rowsNotImported)->reason.'Competency Type name not found in the database: '.$competencyPerRoleFromModel->priorities;
                }
                if(!isset($targetLevel)){
                    end($rowsNotImported)->reason = end($rowsNotImported)->reason.'Target Level name not found in the database: '.$competencyPerRoleFromModel->targetWeights;
                }
                end($rowsNotImported)->reason = end($rowsNotImported)->reason."\r\n"."\r\n".'FOR ROW: '."\r\n";
                end($rowsNotImported)->reason = end($rowsNotImported)->reason.'GROUP: '.$competencyPerRoleFromModel->groupNames."\r\n";
                end($rowsNotImported)->reason = end($rowsNotImported)->reason.'ROLE: '.$competencyPerRoleFromModel->roleNames."\r\n";
                end($rowsNotImported)->reason = end($rowsNotImported)->reason.'COMPETENCY: '.$competencyPerRoleFromModel->competencyNames."\r\n";
                end($rowsNotImported)->reason = end($rowsNotImported)->reason.'PRIORITY: '.$competencyPerRoleFromModel->priorities."\r\n";
                end($rowsNotImported)->reason = end($rowsNotImported)->reason.'TARGET WEIGHT: '.$competencyPerRoleFromModel->targetWeights."\r\n";      
            }
            else{
                $insertListOfCompetenciesItem = listOfCompetenciesPerRole::updateOrCreate(
                    ['groupID' => $group->id,
                    'roleID'=> $role->id,
                    'competencyID' => $competency->id],
                    ['competencyTypeID' => $competencyType->id,
                    'targetLevelID' => $targetLevel->id]
                );
            }

        }
        return ($rowsNotImported);      


    }
}
