<?php

namespace App\Http\Controllers;

use App\role;
use App\group;
use App\employee_data;
use App\listOfCompetenciesPerRole;
use App\competency;
use App\level;
use App\competencyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view("admin.role.view-all");
    }

    public function getAll()
    {
        
        $data = role::whereNull('deleted_at');
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
        return view("admin.role.create");
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
        $roleValidate = role::where('name',$request->input('name'))->whereNull('deleted_at')->get();
        if(count($roleValidate)>0){
            return Redirect::back()->withErrors(['Role is already existing.']);
        }

        $role = new role;
        $role->name = $request->input('name');
        $role->save();

        return redirect('admin/role')->with('success', 'Role successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\role  $role
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $role = role::find($id);
        $competency = competency::whereNull('deleted_at')->get();
        $model = listOfCompetenciesPerRole::select('groupID','roleID','created_at')->whereNull('deleted_at')->where('roleID','=',$role->id)->distinct()->get();
        $level = level::whereNull('deleted_at')->get();
        $type = competencyType::whereNull('deleted_at')->get();
        $group = group::whereNull('deleted_at')->get();
        $employee = employee_data::whereNull('deleted_at')->where('roleID','=',$id)->get();
        $modelCompetencies = listOfCompetenciesPerRole::whereNull('deleted_at')->where('roleID','=',$role->id)->get();

        //return $modelCompetencies;

        return view("admin.role.view")->with(compact('role','competency','model','level','type','modelCompetencies','group','employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $role = role::find($id);
        return view("admin.role.edit")->with(compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $role = role::find($id);
        $role->name = $request->input('name');
        $role->save();

        return redirect('admin/role')->with('success', 'Role successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $role = role::find($id);
        $role->delete();
        return redirect('admin/role')->with('success', 'Role successfully deleted.');
    }
}
