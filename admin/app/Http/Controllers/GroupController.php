<?php

namespace App\Http\Controllers;

use App\group;
use App\division;
use App\employee_data;
use App\role;
use App\listOfCompetenciesPerRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //
        return view("admin.group.view-all");
    }

    public function getAll()
    {
        
        $data = group::whereNull('deleted_at');
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
        return view("admin.group.create");
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
        $groupValidate = group::where('name',$request->input('name'))->whereNull('deleted_at')->get();
        if(count($groupValidate)>0){
            return Redirect::back()->withErrors(['Group is already existing.']);
        }
        
        $group = new group;
        $group->name = $request->input('name');
        $group->save();

        return redirect('admin/group')->with('success', 'Group successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\group  $group
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $group = group::find($id);
        $division = division::whereNull('deleted_at')->where('groupID','=',$group->id)->get();
        $employee = employee_data::whereNull('deleted_at')->where('groupID','=',$group->id)->get();
        $role = role::whereNull('deleted_at')->get();

        $model = listOfCompetenciesPerRole::select('groupID','roleID','created_at')->whereNull('deleted_at')->where('groupID','=',$group->id)->distinct()->get();

        $divisionOverall = division::whereNull('deleted_at')->get();
        $employeeOverall = employee_data::whereNull('deleted_at')->get();
        return view("admin.group.view")->with(compact('group','employee','division','employeeOverall','divisionOverall','model','role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\job  $job
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $group = group::find($id);
        return view("admin.group.edit")->with(compact('group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $group = group::find($id);
        $group->name = $request->input('name');
        $group->save();

        return redirect('admin/group')->with('success', 'Group successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $group = group::find($id);
        $group->delete();
        return redirect('admin/group')->with('success', 'Group successfully deleted.');
    }
}
