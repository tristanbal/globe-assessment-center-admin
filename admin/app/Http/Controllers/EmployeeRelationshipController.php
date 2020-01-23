<?php

namespace App\Http\Controllers;

use App\employeeRelationship;
use App\employee_data;
use App\relationship;
use DB;
use stdClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class EmployeeRelationshipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $employeeRelationship = employeeRelationship::whereNull('deleted_at')->get();

        $employee_data = employee_data::whereNull('deleted_at')->get();
        $relationship = relationship::whereNull('deleted_at')->get();
        return view("admin.employee-relationship.view-all")->with(compact('employee_data','relationship'));
    }

    public function getAll()
    {
        $data = DB::table('employee_relationships')
            ->select('employee_relationships.id as id','employee_relationships.assesseeEmployeeID as assesseeEmployeeID','employee_relationships.is_active as is_active','employee_relationships.assessorEmployeeID as assessorEmployeeID','relationships.name as relationshipName','employee_relationships.created_at as created_at','employee_relationships.updated_at as updated_at')
            ->join('relationships','employee_relationships.relationshipID','=','relationships.id')
            ->whereNull('employee_relationships.deleted_at');
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
        $employee_data = employee_data::whereNull('deleted_at')->get();
        $relationship = relationship::whereNull('deleted_at')->get();
        return view("admin.employee-relationship.create")->with(compact('employee_data','relationship'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //fixed

        $employeeRelationship = new employeeRelationship;
        $employeeRelationship->assesseeEmployeeID = $request->input('assesseeEmployeeID');
        $employeeRelationship->assessorEmployeeID = $request->input('assessorEmployeeID');
        $employeeRelationship->relationshipID = $request->input('relationshipID');
        $employeeRelationship->is_active = 1;
        $employeeRelationship->save();

        if($request->input('oppositeRelationshipID')){
            $employeeRelationship_opposite = new employeeRelationship;
            $employeeRelationship_opposite->assesseeEmployeeID = $request->input('assessorEmployeeID');
            $employeeRelationship_opposite->assessorEmployeeID = $request->input('assesseeEmployeeID');
            $employeeRelationship_opposite->relationshipID = $request->input('oppositeRelationshipID');
            $employeeRelationship_opposite->is_active = 1;
            $employeeRelationship_opposite->save();
        }

        return redirect('admin/employee-relationship')->with('success', 'Employee relationship successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\employeeRelationship  $employeeRelationship
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $employeeRelationship = employeeRelationship::find($id);
        $assesseeEmployee = employee_data::find($employeeRelationship->assesseeEmployeeID);
        $assessorEmployee = employee_data::find($employeeRelationship->assessorEmployeeID);
        $relationship = relationship::where('id','=',$employeeRelationship->relationshipID)->first();
        return view("admin.employee-relationship.view")->with(compact('assesseeEmployee','assessorEmployee','relationship','employeeRelationship'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\employeeRelationship  $employeeRelationship
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $employeeRelationship = employeeRelationship::find($id);
        $employee_data = employee_data::whereNull('deleted_at')->get();
        $relationship = relationship::whereNull('deleted_at')->get();

        return view("admin.employee-relationship.edit")->with(compact('employee_data','relationship','employeeRelationship'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\employeeRelationship  $employeeRelationship
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $employeeRelationship = employeeRelationship::find($id);
        $employeeRelationship->assesseeEmployeeID = $request->input('assesseeEmployeeID');
        $employeeRelationship->assessorEmployeeID = $request->input('assessorEmployeeID');
        $employeeRelationship->relationshipID = $request->input('relationshipID');
        $employeeRelationship->is_active = $request->input('is-active');
        $employeeRelationship->save();

        return redirect('admin/employee-relationship')->with('success', 'Employee relationship successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\employeeRelationship  $employeeRelationship
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $employeeRelationship = employeeRelationship::find($id);
        $employeeRelationship->delete();
        return redirect('admin/employee-relationship')->with('success', 'Employee Relationship successfully deleted.');
    }

    public function searchEmployee(Request $request){
        
        $employeeDataAll = employee_data::whereNull('deleted_at')->get();
        $relationshipSummary = relationship::whereNull('deleted_at')->get();
        
        $employeeRelationship = 0;

        $employeeID = $request->input('employeeID');
        $takerID = $request->input('selectTaker');
        $relationshipID = $request->input('relationshipID');

        $employeeSearchedDetails = employee_data::find($employeeID);
        $employeeRelationshipSummary = array();

        switch($takerID){
            case 1: 
                $employeeRelationship = employeeRelationship::where('assesseeEmployeeID',$employeeID)->where('relationshipID',$relationshipID)->whereNull('deleted_at')->get();

                if($employeeRelationship){
                    foreach($employeeRelationship as  $employeeRelationshipItem){
                        $employeeDataRow = employee_data::find($employeeRelationshipItem->assessorEmployeeID);
                        $relationshipRow = relationship::find($employeeRelationshipItem->relationshipID);
    
                        if ($employeeDataRow) {
                            if ($relationshipRow) {
                                $activeStatus = 0;
                                $employeeRelationshipRow = new stdClass;
                                $employeeRelationshipRow->id = $employeeRelationshipItem->id;
                                $employeeRelationshipRow->searchedEmployeeID = $employeeID;
                                $employeeRelationshipRow->employeeID = $employeeDataRow->employeeID;
                                $employeeRelationshipRow->firstname = $employeeDataRow->firstname;
                                $employeeRelationshipRow->lastname = $employeeDataRow->lastname;
                                $employeeRelationshipRow->relationshipID = $relationshipRow->id;
                                $employeeRelationshipRow->relationship = $relationshipRow->name;

                                if($employeeRelationshipItem->is_active == 1){
                                    $activeStatus = 1;
                                }
                                $employeeRelationshipRow->is_active = $activeStatus;
    
                                array_push($employeeRelationshipSummary,$employeeRelationshipRow);
                            }
                        }
                        
                    }
                }
                
                break;
            case 2:
                $employeeRelationship = employeeRelationship::where('assessorEmployeeID',$employeeID)->where('relationshipID',$relationshipID)->whereNull('deleted_at')->get();
                if ($employeeRelationship) {
                    foreach($employeeRelationship as  $employeeRelationshipItem){
                        $employeeDataRow = employee_data::find($employeeRelationshipItem->assesseeEmployeeID);
                        $relationshipRow = relationship::find($employeeRelationshipItem->relationshipID);
    
                        if ($employeeDataRow) {
                            if ($relationshipRow){
                                $activeStatus = 0;
                                $employeeRelationshipRow = new stdClass;
                                $employeeRelationshipRow->id = $employeeRelationshipItem->id;
                                $employeeRelationshipRow->searchedEmployeeID = $employeeID;
                                $employeeRelationshipRow->employeeID = $employeeDataRow->employeeID;
                                $employeeRelationshipRow->firstname = $employeeDataRow->firstname;
                                $employeeRelationshipRow->lastname = $employeeDataRow->lastname;
                                $employeeRelationshipRow->relationshipID = $relationshipRow->id;
                                $employeeRelationshipRow->relationship = $relationshipRow->name;

                                if($employeeRelationshipItem->is_active == 1){
                                    $activeStatus = 1;
                                }
                                $employeeRelationshipRow->is_active = $activeStatus;
            
                                array_push($employeeRelationshipSummary,$employeeRelationshipRow);
                            }
                        }
                    }
                }
                
                break;
        }

        //return $employeeRelationshipSummary;
        return view("admin.employee-relationship.search-index")->with(compact(
            'employeeRelationship',
            'employeeID',
            'takerID',
            'relationshipID',
            'employeeRelationshipSummary',
            'employeeSearchedDetails',
            'employeeDataAll',
            'relationshipSummary'
        ));
    }

    public function searchResult($employeeID,$takerID,$relationshipID){

        $employeeDataAll = employee_data::whereNull('deleted_at')->get();
        $relationshipSummary = relationship::whereNull('deleted_at')->get();

        $employeeID = $employeeID;
        $takerID = $takerID;
        $relationshipID = $relationshipID;

        $employeeRelationship = 0;
        $employeeRelationshipSummary = array();

        $employeeSearchedDetails = employee_data::find($employeeID);
        switch($takerID){
            case 1: 
                $employeeRelationship = employeeRelationship::where('assesseeEmployeeID',$employeeID)->where('relationshipID',$relationshipID)->whereNull('deleted_at')->get();

                if($employeeRelationship){
                    foreach($employeeRelationship as  $employeeRelationshipItem){
                        $employeeDataRow = employee_data::find($employeeRelationshipItem->assessorEmployeeID);
                        $relationshipRow = relationship::find($employeeRelationshipItem->relationshipID);
    
                        if ($employeeDataRow) {
                            if ($relationshipRow) {
                                $activeStatus = 0;
                                $employeeRelationshipRow = new stdClass;
                                $employeeRelationshipRow->id = $employeeRelationshipItem->id;
                                $employeeRelationshipRow->searchedEmployeeID = $employeeID;
                                $employeeRelationshipRow->employeeID = $employeeDataRow->employeeID;
                                $employeeRelationshipRow->firstname = $employeeDataRow->firstname;
                                $employeeRelationshipRow->lastname = $employeeDataRow->lastname;
                                $employeeRelationshipRow->relationshipID = $relationshipRow->id;
                                $employeeRelationshipRow->relationship = $relationshipRow->name;

                                if($employeeRelationshipItem->is_active == 1){
                                    $activeStatus = 1;
                                }
                                $employeeRelationshipRow->is_active = $activeStatus;
    
                                array_push($employeeRelationshipSummary,$employeeRelationshipRow);
                            }
                        }
                        
                    }
                }
                
                break;
            case 2:
                $employeeRelationship = employeeRelationship::where('assessorEmployeeID',$employeeID)->where('relationshipID',$relationshipID)->whereNull('deleted_at')->get();
                if ($employeeRelationship) {
                    foreach($employeeRelationship as  $employeeRelationshipItem){
                        $employeeDataRow = employee_data::find($employeeRelationshipItem->assesseeEmployeeID);
                        $relationshipRow = relationship::find($employeeRelationshipItem->relationshipID);
    
                        if ($employeeDataRow) {
                            if ($relationshipRow){
                                $activeStatus = 0;
                                $employeeRelationshipRow = new stdClass;
                                $employeeRelationshipRow->id = $employeeRelationshipItem->id;
                                $employeeRelationshipRow->searchedEmployeeID = $employeeID;
                                $employeeRelationshipRow->employeeID = $employeeDataRow->employeeID;
                                $employeeRelationshipRow->firstname = $employeeDataRow->firstname;
                                $employeeRelationshipRow->lastname = $employeeDataRow->lastname;
                                $employeeRelationshipRow->relationshipID = $relationshipRow->id;
                                $employeeRelationshipRow->relationship = $relationshipRow->name;

                                if($employeeRelationshipItem->is_active == 1){
                                    $activeStatus = 1;
                                }
                                $employeeRelationshipRow->is_active = $activeStatus;
            
                                array_push($employeeRelationshipSummary,$employeeRelationshipRow);
                            }
                        }
                    }
                }
                
                break;
        }

        //return $employeeRelationshipSummary;
        return view("admin.employee-relationship.search-index")->with(compact(
            'employeeRelationship',
            'employeeID',
            'takerID',
            'relationshipID',
            'employeeRelationshipSummary',
            'employeeSearchedDetails',
            'employeeDataAll',
            'relationshipSummary'
        ));
    }

    // AFTER SEARCH FUNCTIONALITIES

    
    public function storeSearch(Request $request)
    {
        //
        $employeeRelationship = new employeeRelationship;
        $employeeRelationship->assesseeEmployeeID = $request->input('assesseeEmployeeID');
        $employeeRelationship->assessorEmployeeID = $request->input('assessorEmployeeID');
        $employeeRelationship->relationshipID = $request->input('relationshipID');
        $employeeRelationship->is_active = 1;
        $employeeRelationship->save();

        if($request->input('oppositeRelationshipID')){
            $employeeRelationship_opposite = new employeeRelationship;
            $employeeRelationship_opposite->assesseeEmployeeID = $request->input('assessorEmployeeID');
            $employeeRelationship_opposite->assessorEmployeeID = $request->input('assesseeEmployeeID');
            $employeeRelationship_opposite->relationshipID = $request->input('oppositeRelationshipID');
            $employeeRelationship_opposite->is_active = 1;
            $employeeRelationship_opposite->save();
        }

        return redirect('admin/employee-relationship')->with('success', 'Employee relationship successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\employeeRelationship  $employeeRelationship
     * @return \Illuminate\Http\Response
     */
    public function showSearch($employeeID,$takerID,$relationshipID,$id)
    {
        //


        $employeeRelationship = employeeRelationship::find($id);

        $takerID = $takerID;
        $employeeSearchedDetails = 0;
        if ($takerID == 1) {
            $employeeSearchedDetails = employee_data::find($employeeID);
            $employeeDataRow = employee_data::find($employeeRelationship->assessorEmployeeID);
        }else {
            $employeeSearchedDetails = employee_data::find($employeeID);
            $employeeDataRow = employee_data::find($employeeRelationship->assesseeEmployeeID);
        }
        $relationship = relationship::find($relationshipID);

        return view("admin.employee-relationship.search-view")->with(compact(
            'employeeSearchedDetails',
            'takerID',
            'relationship',
            'relationshipID',
            'employeeSearchedDetails',
            'employeeDataRow',
            'employeeRelationship'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\employeeRelationship  $employeeRelationship
     * @return \Illuminate\Http\Response
     */
    public function editSearch($employeeID,$takerID,$relationshipID,$id)
    {
        $employeeRelationship = employeeRelationship::find($id);

        $takerID = $takerID;
        $relationshipID = $relationshipID;
        $employeeSearchedDetails = 0;
        if ($takerID == 1) {
            $employeeSearchedDetails = employee_data::find($employeeID);
            $employeeDataRow = employee_data::find($employeeRelationship->assessorEmployeeID);
        }else {
            $employeeSearchedDetails = employee_data::find($employeeID);
            $employeeDataRow = employee_data::find($employeeRelationship->assesseeEmployeeID);
        }
        $relationshipSelected = relationship::find($relationshipID);


        $employee_data = employee_data::whereNull('deleted_at')->get();
        $relationship = relationship::whereNull('deleted_at')->get();

        return view("admin.employee-relationship.search-edit")->with(compact(
            'employee_data','relationship','employeeRelationship',
            'employeeSearchedDetails',
            'takerID',
            'relationshipID',
            'relationship',
            'employeeSearchedDetails',
            'employeeDataRow'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\employeeRelationship  $employeeRelationship
     * @return \Illuminate\Http\Response
     */
    public function updateSearch(Request $request, $employeeID,$takerID,$relationshipID,$id)
    {
        //
        //return 'true';
        $employeeRelationship = employeeRelationship::find($id);
        $employeeSearchedDetails = 0;
        if ($takerID == 1) {
            $employeeSearchedDetails = employee_data::find($employeeID);
            $employeeDataRow = employee_data::find($employeeRelationship->assessorEmployeeID);
        }else {
            $employeeSearchedDetails = employee_data::find($employeeID);
            $employeeDataRow = employee_data::find($employeeRelationship->assesseeEmployeeID);
        }
        
        $relationshipSelected = relationship::find($relationshipID);
        $employeeRelationship->assesseeEmployeeID = $request->input('assesseeEmployeeID');
        $employeeRelationship->assessorEmployeeID = $request->input('assessorEmployeeID');
        $employeeRelationship->relationshipID = $request->input('relationshipID');
        $employeeRelationship->is_active = $request->input('is-active');
        $employeeRelationship->save();
        
        return \Redirect::route('employee-relationships.search.index',[ 'taker' => $takerID,'employeeID'=>$employeeSearchedDetails->id, 'relationshipID'=>$relationshipID ])->with('success', 'Employee relationship successfully updated.');
        return redirect('admin/employee-relationship')->with('success', 'Employee relationship successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\employeeRelationship  $employeeRelationship
     * @return \Illuminate\Http\Response
     */
    public function destroySearch($employeeID,$takerID,$relationshipID,$id)
    {
        //
        $employeeRelationship = employeeRelationship::find($id);
        $employeeSearchedDetails = 0;
        if ($takerID == 1) {
            $employeeSearchedDetails = employee_data::find($employeeID);
            $employeeDataRow = employee_data::find($employeeRelationship->assessorEmployeeID);
        }else {
            $employeeSearchedDetails = employee_data::find($employeeID);
            $employeeDataRow = employee_data::find($employeeRelationship->assesseeEmployeeID);
        }
        $relationshipSelected = relationship::find($relationshipID);
        $employeeRelationship->delete();
        return \Redirect::route('employee-relationships.search.index',[ 'taker' => $takerID,'employeeID'=>$employeeSearchedDetails->employeeID, 'relationshipID'=>$relationshipSelected->id ])->with('success', 'Employee Relationship successfully deleted.');
        return redirect('admin/employee-relationship')->with('success', 'Employee Relationship successfully deleted.');
    }
}
