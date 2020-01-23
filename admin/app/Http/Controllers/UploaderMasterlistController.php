<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\masterlist;
//use Excel;
use App\Imports\CsvDataImport;

use App\band;
use App\group;
use App\role;
use App\job;
use App\division;
use App\department;
use App\section;
use App\employee_data;
use App\employeeRelationship;
use App\relationship;
use DB;
use App\Imports\masterlistImport;
use App\Imports\masterlistExport;
use Maatwebsite\Excel\Facades\Excel;

ini_set('max_execution_time', 12000);
ini_set('memory_limit', '4095M');

class UploaderMasterlistController extends Controller
{
    //
    public function showUploaderForm()
    {
        return view('admin.uploader.masterlist')->with(compact(''));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request) 
    {
        //return 'test';
        $path1 = $request->file('import_file')->store('temp'); 
        $path=storage_path('app').'/'.$path1;
        //return $path;
        //return 'true';

        $this->truncateUploaderTable();


        Excel::import(new masterlistImport, $path);
        
        $groups = DB::table("masterlists")->select("groups")->distinct()->get();
        foreach($groups as $row){
            $group = group::updateOrCreate(['name'=> $row->groups]);
        }

        $bands = DB::table("masterlists")->select("bands")->distinct()->get();
        foreach($bands as $row){
            $group = band::updateOrCreate(['name'=> $row->bands]);
        }

        $this->populateDivisionsTable();
        $this->populateDepartmentsTable();
        $this->populateSectionsTable();
        $this->populateRolesTable();
        
        $this->populateEmployee_DatasTable();
        $this->populateEmployeeRelationship();



        //return $groups;
        return redirect('admin/uploader/masterlist')->with('success', 'Masterlist successfully uploaded.');
        //return redirect('/')->with('success', 'All good!');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'import_file' => 'required'
        ]);
 
        
        $path = $request->file('import_file')->getRealPath();
        //$data = Excel::import($path, 'windows-1252')->get();
        //$import = new CsvDataImport();
        $data = Excel::toCollection(new CsvDataImport,$path);
        return $data;
        //return dd($sample);
        //$data = Excel::import($import, $path);
        //return dd($data);
        $headerRow = $data->first()->keys()->toArray();
        $uploadedHeaderRow = $data->first()->keys()->toArray();

        $this->truncateUploaderTable();
        
        if(!$this->checkIfUploadedFilesHasCorrectHeaders($headerRow)){
            return redirect('admin/uploader/masterlist')->with('error', 'File does not comply with the required column headers.');
        }



        // return $headerRow;

        if($data->count()){
            foreach ($data as $key => $dataItem) {
                    $middlenameChecker = trim($dataItem->middlename);
                    if($dataItem->middle_name == '' || $dataItem->middle_name == null ) {
                        $dataItem->middle_name = "N/A";
                    }
                    
                    if($dataItem->phone_number == '') {
                        $dataItem->phone_number = "N/A";
                    }
                        $masterlist = masterlist::updateOrCreate(
                            ['employeeID' => $dataItem->employee_id],
                            ['groups' => $dataItem->group,
                            'divisions' => $dataItem->division  ,
                            'departments' => $dataItem->department,
                            'sections' => $dataItem->section,
                            'firstname' => $dataItem->first_name,
                            'lastname' => $dataItem->last_name,
                            'middlename' => $dataItem->middle_name,
                            'nameSuffix' => $dataItem->name_suffix,
                            'roles' => $dataItem->role,
                            'bands' => $dataItem->band,
                            'supervisorID' => $dataItem->supervisor_id,
                            'email' => $dataItem->email,
                            'phone' => $dataItem->phone_number
                            ]
                        );         
                }
        }


        $this->populateBandsTable();

        $this->populateGroupsTable();
        $this->populateDivisionsTable();
        $this->populateDepartmentsTable();
        $this->populateSectionsTable();
        $this->populateRolesTable();
        $this->populateEmployee_DatasTable();

        
        return redirect('admin/uploader/masterlist')->with('success', 'Data successfully imported');

        // return view('AdminViews.Uploader.admin-uploader-masterlist')->with('success', 'CSV successfully imported.');

  
    }


    private function truncateUploaderTable(){
        //Drop masterlist uploader data
        masterlist::truncate();
    }


    private function checkIfUploadedFilesHasCorrectHeaders($headerRow){
        $expectedHeaderRow = array(
            'employee_id',
            'group',
            'division',
            'department',
            'section',
            'first_name',
            'last_name',
            'middle_name',
            'name_suffix',
            'role',
            'band',
            'supervisor_id',
            'email',
            'phone_number'
        );

        sort($headerRow);
        sort($expectedHeaderRow);
        if ($headerRow==$expectedHeaderRow) {
            return true;
        }
        else{
            return false;
        }

    }
   

    //

    private function populateBandsTable(){
        // $employee = DB::table('employee_datas')->where('employeeID', '=', $id)->whereNull('deleted_at')->first();
        $bandsFromMasterlist = masterlist::distinct()->get(['bands']);

        foreach($bandsFromMasterlist as $bandFromMasterlist)
        {
            $insertBand = band::updateOrCreate(
                ['name' => $bandFromMasterlist->bands]
            );
        }
    }

    private function populateGroupsTable(){
        $groupsFromMasterlist = masterlist::distinct()->get(['groups']);

        foreach($groupsFromMasterlist as $groupFromMasterlist)
        {
            $insertGroup = group::updateOrCreate(
                ['name' => $groupFromMasterlist->groups]
            );
        }
    }

    private function populateDivisionsTable(){
        // $divisionsFromMasterlist = masterlist::distinct()->get(['groups','divisions']);
        $divisionsFromMasterlist = masterlist::groupBy('groups', 'divisions')->get(['groups','divisions']);
        foreach($divisionsFromMasterlist as $divisionFromMasterlist)
        {
            $insertDivision = division::updateOrCreate(
                ['name' => $divisionFromMasterlist->divisions,'groupID' => DB::table('groups')->where('name', '=', $divisionFromMasterlist->groups)->whereNull('deleted_at')->first()->id]
            );
        }
    }

    private function populateDepartmentsTable(){
        $departmentsFromMasterlist = masterlist::groupBy('groups', 'divisions','departments')->get(['groups','divisions','departments']);
        
        foreach($departmentsFromMasterlist as $departmentFromMasterlist)
        {
                $insertDepartment = department::updateOrCreate(
                    ['name' => $departmentFromMasterlist->departments,
                    'divisionID'=> DB::table('divisions')->where([['name', '=', $departmentFromMasterlist->divisions],['groupID', '=', DB::table('groups')->where('name', '=', $departmentFromMasterlist->groups)->whereNull('deleted_at')->first()->id]])->whereNull('deleted_at')->first()->id,
                    'groupID'=>DB::table('groups')->where('name', '=', $departmentFromMasterlist->groups)->whereNull('deleted_at')->first()->id]
                );      
        }
    }    

    private function populateSectionsTable(){
        $sectionsFromMasterlist = masterlist::groupBy('groups', 'divisions','departments','sections')->get(['groups','divisions','departments','sections']);

        foreach($sectionsFromMasterlist as $sectionFromMasterlist)
        {
            $insertSection = section::updateOrCreate(
                ['name' => $sectionFromMasterlist->sections,
                'departmentID'=> DB::table('departments')->where([['name', '=', $sectionFromMasterlist->departments],
                                                                ['divisionID', '=', DB::table('divisions')->where([['name', '=', $sectionFromMasterlist->divisions],['groupID', '=', DB::table('groups')->where('name', '=', $sectionFromMasterlist->groups)->whereNull('deleted_at')->first()->id]])->whereNull('deleted_at')->first()->id]])->whereNull('deleted_at')->first()->id,
                'groupID'=>DB::table('groups')->where('name', '=', $sectionFromMasterlist->groups)->whereNull('deleted_at')->first()->id,
                'divisionID'=> DB::table('divisions')->where([['name', '=', $sectionFromMasterlist->divisions],['groupID', '=', DB::table('groups')->where('name', '=', $sectionFromMasterlist->groups)->whereNull('deleted_at')->first()->id]])->whereNull('deleted_at')->first()->id]);
            }
    }


    private function populateRolesTable(){
        $rolesFromMasterlist = masterlist::distinct()->get(['roles']);

        foreach($rolesFromMasterlist as $roleFromMasterlist)
        {
            $insertRole = role::updateOrCreate(
                ['name' => $roleFromMasterlist->roles]
            );
        }
    }

    private function populateEmployeeRelationship(){
        $employeesFromMasterlist = employee_data::all();
        $selfRelationship =  relationship::where('name','=','Self')->first();
        $supervisorRelationship =  relationship::where('name','=','Supervisor')->first();
        $superviseeRelationship =  relationship::where('name','=','Supervisee')->first();

        foreach($employeesFromMasterlist as $employeeFromMasterlist){
            $insertSelf = employeeRelationship::updateOrCreate(
                ['assesseeEmployeeID' => $employeeFromMasterlist->id,
                'assessorEmployeeID' => $employeeFromMasterlist->id,
                'relationshipID'=> $selfRelationship->id],
                ['assesseeEmployeeID' => $employeeFromMasterlist->id,
                'assessorEmployeeID' => $employeeFromMasterlist->id,
                'relationshipID'=> $selfRelationship->id,
                'is_active'=> 1]
            );

            $unsetSupervisor = employeeRelationship::whereNull('deleted_at')->where('assesseeEmployeeID', $employeeFromMasterlist->id)->where('relationshipID',$supervisorRelationship->id)->update(['is_active'=>0]);

            $supervisorActualID = employee_data::where('employeeID',$employeeFromMasterlist->supervisorID)->whereNull('deleted_at')->first();
            if($supervisorActualID){
                $insertSupervisor = employeeRelationship::updateOrCreate(
                    ['assesseeEmployeeID' => $employeeFromMasterlist->id,
                    'assessorEmployeeID' => $supervisorActualID->id,
                    'relationshipID'=> $supervisorRelationship->id],
                    ['assesseeEmployeeID' => $employeeFromMasterlist->id,
                    'assessorEmployeeID' => $supervisorActualID->id,
                    'relationshipID'=> $supervisorRelationship->id,
                    'is_active'=> 1]
                );
    
                $insertSupervisee = employeeRelationship::updateOrCreate(
                    ['assesseeEmployeeID' => $supervisorActualID->id,
                    'assessorEmployeeID' => $employeeFromMasterlist->id,
                    'relationshipID'=> $superviseeRelationship->id],
                    ['assesseeEmployeeID' => $supervisorActualID->id,
                    'assessorEmployeeID' => $employeeFromMasterlist->id,
                    'relationshipID'=> $superviseeRelationship->id,
                    'is_active'=> 0]
                );
            }
            
        }
    }

    private function populateEmployee_DatasTable(){
        $employeesFromMasterlist = masterlist::all();

        foreach($employeesFromMasterlist as $employeeFromMasterlist)
        {
            $insertEmployee = employee_data::updateOrCreate(
                ['employeeID' => $employeeFromMasterlist->employeeID],
                ['firstname'=> $employeeFromMasterlist->firstname,
                'lastname'=> $employeeFromMasterlist->lastname,
                'middlename'=> $employeeFromMasterlist->middlename,
                'nameSuffix'=> $employeeFromMasterlist->nameSuffix,
                'email'=> $employeeFromMasterlist->email,
                'phone'=> $employeeFromMasterlist->phone,
                'supervisorID'=> $employeeFromMasterlist->supervisorID,
                'jobID'=>1,
                'isActive'=>0,
                'roleID'=> DB::table('roles')->where('name', '=', $employeeFromMasterlist->roles)->whereNull('deleted_at')->first()->id,
                'bandID'=> DB::table('bands')->where('name', '=', $employeeFromMasterlist->bands)->whereNull('deleted_at')->first()->id,
                'groupID'=> DB::table('groups')->where('name', '=', $employeeFromMasterlist->groups)->whereNull('deleted_at')->first()->id,
                'divisionID'=> DB::table('divisions')->where([['name', '=', $employeeFromMasterlist->divisions],['groupID','=',DB::table('groups')->where('name', '=', $employeeFromMasterlist->groups)->whereNull('deleted_at')->first()->id]])->whereNull('deleted_at')->first()->id,
                'departmentID'=> DB::table('departments')->where([['name', '=', $employeeFromMasterlist->departments],['groupID','=',DB::table('groups')->where('name', '=', $employeeFromMasterlist->groups)->whereNull('deleted_at')->first()->id],['divisionID','=',DB::table('divisions')->where([['name', '=', $employeeFromMasterlist->divisions],['groupID','=',DB::table('groups')->where('name', '=', $employeeFromMasterlist->groups)->whereNull('deleted_at')->first()->id]])->whereNull('deleted_at')->first()->id]])->whereNull('deleted_at')->first()->id,
                'sectionID'=> DB::table('sections')->where([['name', '=', $employeeFromMasterlist->sections],['departmentID','=',DB::table('departments')->where([['name', '=', $employeeFromMasterlist->departments],['groupID','=',DB::table('groups')->where('name', '=', $employeeFromMasterlist->groups)->whereNull('deleted_at')->first()->id],['divisionID','=',DB::table('divisions')->where([['name', '=', $employeeFromMasterlist->divisions],['groupID','=',DB::table('groups')->where('name', '=', $employeeFromMasterlist->groups)->whereNull('deleted_at')->first()->id]])->whereNull('deleted_at')->first()->id]])->whereNull('deleted_at')->first()->id]])->whereNull('deleted_at')->first()->id]
            );
            
        }
    }
}
