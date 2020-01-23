<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\competencyUploader;
//use Excel;
use App\Imports\CsvDataImport;

use App\cluster;
use App\subcluster;
use App\competency;
use App\proficiency;
use App\talentSegment;
use DB;
use App\Imports\libraryImport;
use App\Imports\libraryExport;
use Maatwebsite\Excel\Facades\Excel;

ini_set('max_execution_time', 12000);
ini_set('memory_limit', '4095M');

class UploaderLibraryController extends Controller
{
    //
    public function showUploaderForm()
    {
        return view('admin.uploader.library')->with(compact(''));
    }

    public function import(Request $request){
        $this->truncateUploaderTable();
        
        //$path = $request->file('import_file')->getRealPath();
        $path1 = $request->file('import_file')->store('temp'); 
        $path=storage_path('app').'/'.$path1;
        //return $path;
        Excel::import(new libraryImport, $path);
        

        $this->populateClustersTable();
        $this->populateSubClustersTable();
        $this->populateTalentSegmentTable();

        //$this->populateCompetenciesTable();

        $uploadErrors = $this->populateCompetenciesTable();
        //return $uploadErrors;
        
        if(!empty($uploadErrors)){
            $error = '';
            foreach($uploadErrors as $uploadError){
                $error = $error.$uploadError->reason."\r\n";
            }
            $error = "ERROR: UNABLE TO UPLOAD ".count($uploadErrors)." LINES FROM THE FILE UPLOAD \r\n \r\n".$error;
            return $error;
            //return redirect('admin/uploader/library')->with('error', $error);
        }

        $this->populateProficienciesTable();
        $this->populateCompetenciesMin();
        $this->populateCompetenciesMax();

        return redirect('admin/uploader/library')->with('success', 'Library successfully uploaded.');
    }
    public function importExcel(Request $request)
    {
        $request->validate([
            'import_file' => 'required'
        ]);

        $path = $request->file('import_file')->getRealPath();
        $data = Excel::load($path, 'windows-1252')->get();
        //return 'test';
 
        $headerRow = $data->first()->keys()->toArray();
        
        
        if($this->checkIfUploadedFilesHasCorrectHeaders($headerRow) == false){
            return redirect('admin/uploader/library')->with('error', "ERROR: The file you are trying to upload does not comply to this uploader's requirement. Kindly check your column headers.");
        }

        $this->truncateUploaderTable();

        //return $data;

        if($data->count()){
            foreach ($data as $key => $dataItem) {
                if($dataItem->competency == '' || $dataItem->clusters == '' || 
                $dataItem->subclusters == '' ||$dataItem->competency_element == '' || $dataItem->talent_segment == '' || 
               $dataItem->one=='' || $dataItem->two == '' || 
                $dataItem->three == '' || $dataItem->four == ''  || $dataItem->five == ''  || $dataItem->definition == ''){

                    $error = '';
                    $error = $error.'DETECTED AN EMPTY COLUMN: '."\r\n";
                    $error = $error.'COMPETENCY: '.$dataItem->competency."\r\n";
                    $error = $error.'CLUSTER: '.$dataItem->clusters."\r\n";
                    $error = $error.'SUBCLUSTER: '.$dataItem->subclusters."\r\n";
                    $error = $error.'COMPETENCY ELEMENT: '.$dataItem->competency_element."\r\n";
                    $error = $error.'TALENT SEGMENT: '.$dataItem->talent_segment."\r\n";
                    $error = $error.'ONE: '.$dataItem->one."\r\n";
                    $error = $error.'TWO: '.$dataItem->two."\r\n";
                    $error = $error.'THREE: '.$dataItem->three."\r\n";
                    $error = $error.'FOUR: '.$dataItem->four."\r\n";
                    $error = $error.'FIVE: '.$dataItem->five."\r\n";

                    $error = $error.'DEFINITION: '.$dataItem->definition."\r\n";


                    $error = "ERROR: UNABLE TO UPLOAD FILE \r\n \r\n".$error;
                    return redirect('admin/uploader/library')->with('error', $error);
                }
                else{
                    $competencyUploader = competencyUploader::updateOrCreate(
                        ['competencyNames' => ($dataItem->competency),
                        'clusters' => ($dataItem->clusters),
                        'subclusters' => ($dataItem->subclusters),
                        'talentsegments' => ($dataItem->talent_segment)],
                        ['competencyElements' => ($dataItem->competency_element),
                        'levelOne' => ($dataItem->one),
                        'levelTwo' => ($dataItem->two),
                        'levelThree' => ($dataItem->three),
                        'levelFour' => ($dataItem->four),
                        'levelFive' => ($dataItem->five),
                        'definitions' => ($dataItem->definition)    
                        ]
                    );
                }
                           
            }
        }



        $this->populateClustersTable();
        $this->populateSubClustersTable();
        $this->populateTalentSegmentTable();
        

        $uploadErrors = $this->populateCompetenciesTable();

        if(!empty($uploadErrors)){
            $error = '';
            foreach($uploadErrors as $uploadError){
                $error = $error.$uploadError->reason."\r\n";
            }
            $error = "ERROR: UNABLE TO UPLOAD ".count($uploadErrors)." LINES FROM THE FILE UPLOAD \r\n \r\n".$error;
            return redirect('admin/uploader/library')->with('error', $error);
        }

    

        $this->populateProficienciesTable();
        $this->populateCompetenciesMin();
        $this->populateCompetenciesMax();


      
        return redirect('admin/uploader/library')->with('success', 'Data successfully imported');       
    }


    private function checkIfUploadedFilesHasCorrectHeaders($headerRow){
        $requiredHeaders = ["clusters","subclusters","talent_segment","competency","competency_element","definition","one","two","three","four","five"];

        if($headerRow != $requiredHeaders){
            return false;
        }
        return true;
    }

    private function truncateUploaderTable(){
        //Drop masterlist uploader data
        competencyUploader::truncate();
    }

    private function populateCompetenciesMin(){
        DB::update("UPDATE competencies SET minimumLevelID = (SELECT min(levelID) FROM proficiencies where proficiencies.competencyID = competencies.id group by competencyID)"); 
    }

    private function populateCompetenciesMax(){
        DB::update("UPDATE competencies SET maximumLevelID = (SELECT max(levelID) FROM proficiencies where proficiencies.competencyID = competencies.id group by competencyID)"); 
    }


    private function populateProficienciesTable(){
        // $employee = DB::table('employee_datas')->where('employeeID', '=', $id)->whereNull('deleted_at')->first();
        $competenciesFromLibrary = competencyUploader::all();

            foreach($competenciesFromLibrary as $competencyFromLibrary)
            {
                if($competencyFromLibrary->levelOne!='N/A'){
                    $levelID = '2';
                    $cluster = cluster::where(['name'=>$competencyFromLibrary->clusters])->first();
                    $subcluster = subcluster::where(['name'=>$competencyFromLibrary->subclusters,'clusterID' => $cluster->id])->first();
                    $competency = competency::where(['name'=>$competencyFromLibrary->competencyNames,'subclusterID' => $subcluster->id,'clusterID' => $cluster->id])->first();

                    $insertProficiency = proficiency::updateOrCreate(
                        ['levelID' => $levelID,
                        'competencyID'=> $competency->id],
                        ['definition' => $competencyFromLibrary->levelOne]
                    );
                }
                
                if($competencyFromLibrary->levelTwo!='N/A'){
                    $levelID = '3';
                    $cluster = cluster::where(['name'=>$competencyFromLibrary->clusters])->first();
                    $subcluster = subcluster::where(['name'=>$competencyFromLibrary->subclusters,'clusterID' => $cluster->id])->first();
                    $competency = competency::where(['name'=>$competencyFromLibrary->competencyNames,'subclusterID' => $subcluster->id,'clusterID' => $cluster->id])->first();

                        $insertProficiency = proficiency::updateOrCreate(
                            ['levelID' => $levelID,
                            'competencyID'=> $competency->id],
                            ['definition' => $competencyFromLibrary->levelTwo]
                        );
                }

                if($competencyFromLibrary->levelThree!='N/A'){
                    $levelID = '4';
                    $cluster = cluster::where(['name'=>$competencyFromLibrary->clusters])->first();
                    $subcluster = subcluster::where(['name'=>$competencyFromLibrary->subclusters,'clusterID' => $cluster->id])->first();
                    $competency = competency::where(['name'=>$competencyFromLibrary->competencyNames,'subclusterID' => $subcluster->id,'clusterID' => $cluster->id])->first();

                        $insertProficiency = proficiency::updateOrCreate(
                            ['levelID' => $levelID,
                            'competencyID'=> $competency->id],
                            ['definition' => $competencyFromLibrary->levelThree]
                        );
                }

                if($competencyFromLibrary->levelFour!='N/A'){
                    $levelID = '5';
                    $cluster = cluster::where(['name'=>$competencyFromLibrary->clusters])->first();
                    $subcluster = subcluster::where(['name'=>$competencyFromLibrary->subclusters,'clusterID' => $cluster->id])->first();
                    $competency = competency::where(['name'=>$competencyFromLibrary->competencyNames,'subclusterID' => $subcluster->id,'clusterID' => $cluster->id])->first();

                        $insertProficiency = proficiency::updateOrCreate(
                            ['levelID' => $levelID,
                            'competencyID'=> $competency->id],
                            ['definition' => $competencyFromLibrary->levelFour]
                        );
                }

                if($competencyFromLibrary->levelFive!='N/A'){
                    $levelID = '6';
                    $cluster = cluster::where(['name'=>$competencyFromLibrary->clusters])->first();
                    $subcluster = subcluster::where(['name'=>$competencyFromLibrary->subclusters,'clusterID' => $cluster->id])->first();
                    $competency = competency::where(['name'=>$competencyFromLibrary->competencyNames,'subclusterID' => $subcluster->id,'clusterID' => $cluster->id])->first();

                        $insertProficiency = proficiency::updateOrCreate(
                            ['levelID' => $levelID,
                            'competencyID'=> $competency->id],
                            ['definition' => $competencyFromLibrary->levelFive]
                        );
                }
              
              
       
            
        }
    }
    
    private function populateTalentSegmentTable(){
        // $employee = DB::table('employee_datas')->where('employeeID', '=', $id)->whereNull('deleted_at')->first();
        $talentSegmentFromLibrary = competencyUploader::distinct()->get(['talentsegments']);

        foreach($talentSegmentFromLibrary as $talentSegmentsFromLibrary)
        {
            $insertTalentSegment = talentSegment::updateOrCreate(
                ['name' => $talentSegmentsFromLibrary->talentsegments]
            );
        }
    }

    private function populateClustersTable(){
        // $employee = DB::table('employee_datas')->where('employeeID', '=', $id)->whereNull('deleted_at')->first();
        $clustersFromLibrary = competencyUploader::distinct()->get(['clusters']);

        foreach($clustersFromLibrary as $clusterFromLibrary)
        {
            $insertCluster = cluster::updateOrCreate(
                ['name' => $clusterFromLibrary->clusters]
            );
        }
    }

    private function populateSubClustersTable(){
         $subclustersFromLibrary = competencyUploader::groupBy('clusters', 'subclusters')->get(['clusters','subclusters']);
         foreach($subclustersFromLibrary as $subclusterFromLibrary)
         {
             $insertSubcluster = subcluster::updateOrCreate(
                 ['name' => $subclusterFromLibrary->subclusters,
                 'clusterID' => DB::table('clusters')->where('name', '=', $subclusterFromLibrary->clusters)->whereNull('deleted_at')->first()->id]
             );
         }
    }

    private function populateCompetenciesTable(){

        $rowsNotImported = array();
        //return 'test';
        $competenciesFromLibrary = competencyUploader::select('clusters','subclusters','competencyNames','talentSegments','definitions','deleted_at')->groupBy('clusters','subclusters','competencyNames','talentsegments','competencyElements','definitions','deleted_at')->get();
        //return $competenciesFromLibrary;
        
        foreach($competenciesFromLibrary as $competencyFromLibrary)
        {
            $cluster = DB::table('clusters')->where('name', '=', $competencyFromLibrary->clusters)->whereNull('deleted_at')->first();
            $subcluster = DB::table('subclusters')->where(['name'=> $competencyFromLibrary->subclusters,'clusterID' => DB::table('clusters')->where('name', '=', $competencyFromLibrary->clusters)->whereNull('deleted_at')->first()->id])->whereNull('deleted_at')->first();
            $talentsegment = DB::table('talent_segments')->where('name', '=', $competencyFromLibrary->talentSegments)->whereNull('deleted_at')->first();
            //return dd($talentsegment);
            //return $talentsegment;
            //Error checker
            if(!isset($cluster)|| !isset($subcluster) || !isset($talentsegment)){
                array_push($rowsNotImported, $competencyFromLibrary);
                end($rowsNotImported)->reason = end($rowsNotImported)->reason."\r\n".'ERROR DETAIL: '."\r\n";
                
                if(!isset($cluster)){
                    end($rowsNotImported)->reason = end($rowsNotImported)->reason.'Cluster name not found in the database: '.$competencyFromLibrary->clusters;
                }
                if(!isset($subcluster)){
                    end($rowsNotImported)->reason = end($rowsNotImported)->reason.'Subcluster name not found in the database: '.$competencyFromLibrary->subclusters;
                }
                if(!isset($talentsegment)){
                    end($rowsNotImported)->reason = end($rowsNotImported)->reason.'Talentsegment name not found in the database: '.$competencyFromLibrary->talentsegments;
                }
                end($rowsNotImported)->reason = end($rowsNotImported)->reason."\r\n"."\r\n".'FOR ROW: '."\r\n";
                return 'failed';
                /*end($rowsNotImported)->reason = end($rowsNotImported)->reason.'Cluster: '.$competencyPerRoleFromModel->clusters."\r\n";
                end($rowsNotImported)->reason = end($rowsNotImported)->reason.'Subcluster: '.$competencyPerRoleFromModel->subclusters."\r\n";
                end($rowsNotImported)->reason = end($rowsNotImported)->reason.'Talentsegment: '.$competencyPerRoleFromModel->talentsegments."\r\n";
                end($rowsNotImported)->reason = end($rowsNotImported)->reason.'Competency: '.$competencyPerRoleFromModel->competencyNames."\r\n";
                end($rowsNotImported)->reason = end($rowsNotImported)->reason.'Definition: '.$competencyPerRoleFromModel->definition."\r\n";*/
            }
            else{
                $insertCompetency = competency::updateOrCreate(
                    ['name' => $competencyFromLibrary->competencyNames],
                    [
                    'clusterID' => $cluster->id,
                    'subclusterID' => $subcluster->id,
                    'talentSegmentID' => $talentsegment->id,
                    'maximumLevelID'=> "-1",
                    'minimumLevelID'=> "-1",
                    'definition' => $competencyFromLibrary->definitions]
                );
            }
        }
        return ($rowsNotImported);      
   }
}
