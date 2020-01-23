<?php

namespace App\Http\Controllers;

use App\listOfCompetenciesPerRole;
use App\role;
use App\group;
use App\competency;
use App\competencyType;
use App\level;
use App\employee_data;
use Illuminate\Http\Request;
use \stdClass;
use Illuminate\Support\Facades\Redirect;

class ListOfCompetenciesPerRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $model = listOfCompetenciesPerRole::select('groupID','roleID')->distinct()->whereNull('deleted_at')->get();

        $allModel = array();
        foreach($model as $modelItem){
            $arrayRow = new stdClass();

            $group = group::where('id',$modelItem->groupID)->whereNull('deleted_at')->first();
            $role = role::where('id',$modelItem->roleID)->whereNull('deleted_at')->first();
            $arrayRow->groupID = $group->id;
            $arrayRow->groupName = $group->name;
            $arrayRow->roleID = $role->id;
            $arrayRow->roleName = $role->name;

            array_push($allModel,$arrayRow);
        }

        $group = group::whereNull('deleted_at')->get();
        $role = role::whereNull('deleted_at')->get();
        
        return view('admin.model.views.view-all')->with(compact('allModel','group','role'));
    }

    public function getAll()
    {

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
        $role = role::whereNull('deleted_at')->get();
        $competency = competency::whereNull('deleted_at')->get();
        $competencyType = competencyType::whereNull('deleted_at')->get();
        $level = level::whereNull('deleted_at')->get();
        
        return view('admin.model.views.create')->with(compact('group','role','competency','competencyType','level'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $modelCompetency = new listOfCompetenciesPerRole;
        $modelCompetency->groupID = $request->input('groupID');
        $modelCompetency->roleID = $request->input('roleID');
        $modelCompetency->competencyID = $request->input('competencyID');
        $modelCompetency->competencyTypeID = $request->input('typeID');
        $modelCompetency->targetLevelID = $request->input('levelID');
        $modelCompetency->save();

        return redirect('admin/model')->with('success', 'Model successfully added.');
        return Redirect::back()->with('success', 'Model successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\listOfCompetenciesPerRole  $listOfCompetenciesPerRole
     * @return \Illuminate\Http\Response
     */
    public function show($groupID,$roleID)
    {
        //
        $model = listOfCompetenciesPerRole::where('groupID',$groupID)->where('roleID',$roleID)->whereNull('deleted_at')->get();
        $group = group::find($groupID);
        $role = role::find($roleID);
        $employee = employee_data::where('roleID',$roleID)->whereNull('deleted_at')->get();
        $type = competencyType::whereNull('deleted_at')->get();

        $modelCompetencies = array();
        foreach($model as $modelItem){
            $arrayRow = new stdClass();

            $competency = competency::where('id',$modelItem->competencyID)->whereNull('deleted_at')->first();
            $competencyType = competencyType::where('id',$modelItem->competencyTypeID)->whereNull('deleted_at')->first();
            $level = level::where('id',$modelItem->targetLevelID)->whereNull('deleted_at')->first();

            $arrayRow->competencyID = $competency->id;
            $arrayRow->competencyName = $competency->name;
            $arrayRow->competencyDefinition = $competency->definition;
            $arrayRow->competencyTypeID = $competencyType->id;
            $arrayRow->competencyTypeName = $competencyType->name;
            $arrayRow->targetLevelID = $level->id;
            $arrayRow->targetLevelWeight = $level->weight;
            $arrayRow->targetLevelName = $level->name;

            array_push($modelCompetencies,$arrayRow);
        }

        return view('admin.model.views.view')->with(compact('modelCompetencies','group','role','employee','type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\listOfCompetenciesPerRole  $listOfCompetenciesPerRole
     * @return \Illuminate\Http\Response
     */
    public function edit($groupID,$roleID)
    {
        //
        $model = listOfCompetenciesPerRole::where('groupID',$groupID)->where('roleID',$roleID)->whereNull('deleted_at')->get();
        $group = group::find($groupID);
        $role = role::find($roleID);
        $employee = employee_data::where('roleID',$roleID)->whereNull('deleted_at')->get();
        $type = competencyType::whereNull('deleted_at')->get();

        $modelCompetencies = array();
        foreach($model as $modelItem){
            $arrayRow = new stdClass();

            $competency = competency::where('id',$modelItem->competencyID)->whereNull('deleted_at')->first();
            $competencyType = competencyType::where('id',$modelItem->competencyTypeID)->whereNull('deleted_at')->first();
            $level = level::where('id',$modelItem->targetLevelID)->whereNull('deleted_at')->first();

            $arrayRow->competencyID = $competency->id;
            $arrayRow->competencyName = $competency->name;
            $arrayRow->competencyDefinition = $competency->definition;
            $arrayRow->competencyTypeID = $competencyType->id;
            $arrayRow->competencyTypeName = $competencyType->name;
            $arrayRow->targetLevelID = $level->id;
            $arrayRow->targetLevelWeight = $level->weight;
            $arrayRow->targetLevelName = $level->name;

            array_push($modelCompetencies,$arrayRow);
        }


        $competency = competency::whereNull('deleted_at')->get();
        $competencyType = competencyType::whereNull('deleted_at')->get();
        $level = level::whereNull('deleted_at')->get();

        return view('admin.model.views.edit')->with(compact('modelCompetencies','group','role','employee','type','competency','competencyType','level'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\listOfCompetenciesPerRole  $listOfCompetenciesPerRole
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, listOfCompetenciesPerRole $listOfCompetenciesPerRole)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\listOfCompetenciesPerRole  $listOfCompetenciesPerRole
     * @return \Illuminate\Http\Response
     */
    public function destroy($groupID,$roleID)
    {
        //
    }

    public function destroyCompetency($groupID,$roleID,$competencyID)
    {
        //
        $modelCompetency = listOfCompetenciesPerRole::where('groupID',$groupID)->where('roleID',$roleID)->where('competencyID',$competencyID)->whereNull('deleted_at')->first();
        $modelCompetency->delete();

    }

    public function storeCompetency(Request $request,$groupID,$roleID)
    {
        $modelCompetency = new listOfCompetenciesPerRole;
        $modelCompetency->groupID = $groupID;
        $modelCompetency->roleID = $roleID;
        $modelCompetency->competencyID = $request->input('competencyID');
        $modelCompetency->competencyTypeID = $request->input('competencyTypeID');
        $modelCompetency->targetLevelID = $request->input('levelID');
        $modelCompetency->save();
        
        return redirect('admin/model')->with('success', 'Competency successfully added.');
    }
}
