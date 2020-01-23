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

class EmployeeDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //    
        return view("admin.employee.view-all");
    }

    public function getAll()
    {
        
        $data = employee_data::whereNull('deleted_at');
        return datatables($data)->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $group = group::whereNull('deleted_at')->get();
        $division = division::whereNull('deleted_at')->get();
        $department = department::whereNull('deleted_at')->get();
        $section = section::whereNull('deleted_at')->get();
        $employee = employee_data::whereNull('deleted_at')->get();
        $role = role::whereNull('deleted_at')->get();
        $job = job::whereNull('deleted_at')->get();
        $band = band::whereNull('deleted_at')->get();
        return view("admin.employee.create")->with(compact('group','division','department','section','employee','role','job','band'));
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
        if(!$request->input('employeeID') || !$request->input('firstname') || !$request->input('lastname') ||
            !$request->input('roleID') || !$request->input('jobID') || !$request->input('bandID') || 
            !$request->input('groupsDropdown') || !$request->input('divisionsDropdown') || !$request->input('departmentsDropdown') ||
            !$request->input('sectionsDropdown') || !$request->input('supervisorID') || !$request->input('email'))
        {
            return Redirect::back()->withErrors(['Incomplete Fields.']);
        }

        $middlename = $request->input('middlename');
        $namesuffix = $request->input('namesuffix');

        if(!$request->input('middlename')){
            $middlename = 'N/A';
        }

        if(!$request->input('namesuffix')){
            $namesuffix = 'N/A';
        }

        // Validation
        $employeeIDValidate = employee_data::where('employeeID',$request->input('employeeID'))->whereNull('deleted_at')->get();
        if(count($employeeIDValidate)>0){
            return Redirect::back()->withErrors(['Employee ID is already existing.']);
        }
        $employeeEmailValidate = employee_data::where('email',$request->input('email'))->whereNull('deleted_at')->get();
        if(count($employeeEmailValidate)>0){
            return Redirect::back()->withErrors(['Email is already in use.']);
        }

        // ADD EMPLOYEE
        $employee = new employee_data;
        $employee->employeeID = $request->input('employeeID');
        $employee->firstname = $request->input('firstname');
        $employee->lastname = $request->input('lastname');
        $employee->middlename = $middlename;
        $employee->namesuffix = $namesuffix;
        $employee->roleID = $request->input('roleID');
        $employee->jobID = $request->input('jobID');
        $employee->bandID = $request->input('bandID');
        $employee->groupID = $request->input('groupsDropdown');
        $employee->divisionID = $request->input('divisionsDropdown');
        $employee->departmentID = $request->input('departmentsDropdown');
        $employee->sectionID = $request->input('sectionsDropdown');
        $employee->supervisorID = $request->input('supervisorID');
        $employee->email = $request->input('email');
        $employee->phone = $request->input('phone');
        $employee->isActive = 1;
        $employee->save();

        //Load employee 
        $employeeLoad = employee_data::where('employeeID',$request->input('employeeID'))->whereNull('deleted_at')->first();

        // Add to employee relationship
        $relationshipSelf = relationship::where('name','Self')->whereNull('deleted_at')->first();

        $self = new employeeRelationship;
        $self->assesseeEmployeeID = $employeeLoad->id;
        $self->assessorEmployeeID =  $employeeLoad->id;
        $self->relationshipID = $relationshipSelf->id;
        $self->is_active = 1;
        $self->save();

        $relationshipSupervisor = relationship::where('name','Supervisor')->whereNull('deleted_at')->first();
        $supervisorLoad = employee_data::where('employeeID',$request->input('supervisorID'))->whereNull('deleted_at')->first();

        $supervisor = new employeeRelationship;
        $supervisor->assesseeEmployeeID =  $employeeLoad->id;
        $supervisor->assessorEmployeeID = $supervisorLoad->id;
        $supervisor->relationshipID = $relationshipSupervisor->id;
        $supervisor->is_active = 1;
        $supervisor->save();

        $relationshipDirect = relationship::where('name','Supervisee')->whereNull('deleted_at')->first();

        $direct = new employeeRelationship;
        $direct->assesseeEmployeeID = $supervisorLoad->id;
        $direct->assessorEmployeeID = $employeeLoad->id;
        $direct->relationshipID = $relationshipDirect->id;
        $direct->is_active = 0;
        $direct->save();

        return redirect('admin/employee')->with('success', 'Employee successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\employee_data  $employee_data
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // 
        $employeePersonal = employee_data::find($id);
        if(!$employeePersonal){
            return redirect('admin/user')->with('error', 'Account is not an employee.');
        }
        $group = group::find($employeePersonal->groupID);
        $division = division::find($employeePersonal->divisionID);
        $department = department::find($employeePersonal->departmentID);
        $section = section::find($employeePersonal->sectionID);
        $rolePersonal = role::find($employeePersonal->roleID);
        $job = job::find($employeePersonal->jobID);
        $band = band::find($employeePersonal->bandID);

        $userAccess = User::where('employeeID',$employeePersonal->id)->first();

        // Employee view
        $assessmentType = assessmentType::whereNull('deleted_at')->get();
        $employee = employee_data::whereNull('deleted_at')->where('roleID','<>',3)->where('roleID','<>',8)->get();
        
        // /$employeeRelationshipList = employeeRelationship::where('assessorEmployeeID',$employeeInfo->id)->where('is_active','<>',0)->whereNull('deleted_at')->get();
        $employeeRelationshipList = employeeRelationship::where('assessorEmployeeID',$employeePersonal->id)->whereNull('deleted_at')->get();
        $role = role::whereNull('deleted_at')->get();
        $employeeRelationship = employeeRelationship::select('assessorEmployeeID','relationshipID')->where('assessorEmployeeID',$employeePersonal->id)->whereNull('deleted_at')->where('is_active','<>',0)->distinct()->get();

        $supervisor = employee_data::where('employeeID','=',$employeePersonal->supervisorID)->first();

        //Employee Relationship List
        $employeeRelationshipListSummary = array();
        foreach ($employeeRelationshipList as $empRelListItem) {
            

            $employeeAssessee = employee_data::where('employeeID',$empRelListItem->assesseeEmployeeID)->whereNull('deleted_at')->where('roleID','<>',3)->where('roleID','<>',8)->first();
            $employeeAssessor = employee_data::where('employeeID',$empRelListItem->assessorEmployeeID)->whereNull('deleted_at')->where('roleID','<>',3)->where('roleID','<>',8)->first();
            $relationshipStatus = relationship::find($empRelListItem->relationshipID);
            
            $active = 'no';
            if($empRelListItem->is_active == 1){
                $active = 'yes';
            }
            
            if($employeeAssessee){
                if($employeeAssessor){
                    $relationshipListRow = new stdClass;

                    $relationshipListRow->id = $empRelListItem->id;
                    $relationshipListRow->assessee = $employeeAssessee->employeeID . ' | ' . $employeeAssessee->firstname . ' ' . $employeeAssessee->lastname;
                    $relationshipListRow->assessor = $employeeAssessor->employeeID . ' | ' . $employeeAssessor->firstname . ' ' . $employeeAssessor->lastname;
                    $relationshipListRow->relationship = $relationshipStatus->name;
                    $relationshipListRow->isActive = $active;

                    array_push($employeeRelationshipListSummary,$relationshipListRow);

                }
            }

            
        }

        //return $employeeRelationshipListSummary;
        $employee_data = employee_data::whereNull('deleted_at')->get();
        $relationship = relationship::whereNull('deleted_at')->get();



        return view("admin.employee.view")->with(compact(
            'assessmentType',
            'employeeRelationshipList',
            'employeePersonal',
            'employeeRelationship',
            'rolePersonal',
            'group',
            'division',
            'department',
            'section',
            'employee',
            'role',
            'job',
            'band',
            'supervisor',
            'userAccess',
            'employeeRelationshipListSummary',
            'employee_data',
            'relationship'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\employee_data  $employee_data
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $employee = employee_data::find($id);
        $group = group::whereNull('deleted_at')->get();
        $division = division::whereNull('deleted_at')->get();
        $department = department::whereNull('deleted_at')->get();
        $section = section::whereNull('deleted_at')->get();
        $role = role::whereNull('deleted_at')->get();
        $job = job::whereNull('deleted_at')->get();
        $band = band::whereNull('deleted_at')->get();
        $employeeList = employee_data::whereNull('deleted_at')->get();

        return view("admin.employee.edit")->with(compact('group','division','department','section','employee','role','job','band','employeeList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\employee_data  $employee_data
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if(!$request->input('employeeID') || !$request->input('firstname') || !$request->input('lastname') ||
            !$request->input('roleID') || !$request->input('jobID') || !$request->input('bandID') || 
            !$request->input('groupsDropdown') || !$request->input('divisionsDropdown') || !$request->input('departmentsDropdown') ||
            !$request->input('sectionsDropdown') || !$request->input('supervisorID') || !$request->input('email'))
        {
            return Redirect::back()->withErrors(['Incomplete Fields.']);
        }

        $middlename = $request->input('middlename');
        $namesuffix = $request->input('namesuffix');

        if(!$request->input('middlename')){
            $middlename = 'N/A';
        }

        if(!$request->input('namesuffix')){
            $namesuffix = 'N/A';
        }

        $employee = employee_data::find($id);
        $employee->employeeID = $request->input('employeeID');
        $employee->firstname = $request->input('firstname');
        $employee->lastname = $request->input('lastname');
        $employee->middlename = $middlename;
        $employee->namesuffix = $namesuffix;
        $employee->roleID = $request->input('roleID');
        $employee->jobID = $request->input('jobID');
        $employee->bandID = $request->input('bandID');
        $employee->groupID = $request->input('groupsDropdown');
        $employee->divisionID = $request->input('divisionsDropdown');
        $employee->departmentID = $request->input('departmentsDropdown');
        $employee->sectionID = $request->input('sectionsDropdown');
        $employee->supervisorID = $request->input('supervisorID');
        $employee->email = $request->input('email');
        $employee->phone = $request->input('phone');
        $employee->isActive = 1;
        $employee->save();

        return redirect('admin/employee')->with('success', 'Employee successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\employee_data  $employee_data
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $employee = employee_data::find($id);
        $employee->delete();
        return redirect('admin/employee')->with('success', 'Employee successfully deleted.');
    }
}
