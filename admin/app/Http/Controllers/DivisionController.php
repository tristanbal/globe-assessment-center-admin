<?php

namespace App\Http\Controllers;

use DB;
use App\division;
use App\group;
use App\employee_data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $group = group::all();
        return view("admin.division.view-all")->with(compact('group'));
    }

    public function getAll()
    {
        
        $data = DB::table('divisions')
            ->select('divisions.id as id','divisions.name as divisionName','groups.id as groupID','groups.name as groupName','divisions.created_at as created_at','divisions.updated_at as updated_at')
            ->join('groups','divisions.groupID','=','groups.id')
            ->whereNull('divisions.deleted_at');
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
        $group = group::all();
        return view("admin.division.create")->with(compact('group'));
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
        $divisionValidate = division::where('groupID',$request->input('groupID'))->where('name',$request->input('name'))->whereNull('deleted_at')->get();
        if(count($divisionValidate)>0){
            return Redirect::back()->withErrors(['Division is already existing.']);
        }


        $division = new division;
        $division->name = $request->input('name');
        $division->groupID = $request->input('groupID');
        $division->save();

        return redirect('admin/division')->with('success', 'Division successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\division  $division
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $division = division::find($id);
        $group = group::where('id','=',$division->groupID)->first();
        $employee = employee_data::whereNull('deleted_at')->where('divisionID','=',$division->id)->get();

        return view("admin.division.view")->with(compact('division','group','employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\division  $division
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $division = division::find($id);
        //$relationship = relationship::where('id','=',$type->relationshipID)->whereNull('deleted_at')->first();
        $group = group::all();
        //return $relationship;
        return view("admin.division.edit")->with(compact('division','group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\division  $division
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $division = division::find($id);
        $division->name = $request->input('name');
        $division->groupID = $request->input('groupID');
        $division->save();
        

        return redirect('admin/division')->with('success', 'Division successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\division  $division
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $division = division::find($id);
        $division->delete();
        return redirect('admin/division')->with('success', 'Division successfully deleted.');
    }
}
