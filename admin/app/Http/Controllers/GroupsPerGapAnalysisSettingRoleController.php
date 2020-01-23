<?php

namespace App\Http\Controllers;

use App\groupsPerGapAnalysisSettingRole;
use App\groupsPerGapAnalysisSetting;
use App\role;
use Illuminate\Http\Request;

class GroupsPerGapAnalysisSettingRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $groupsPerGapAnalysisSettingRole = groupsPerGapAnalysisSettingRole::whereNull('deleted_at')->get();
        return view("admin.groups-per-gap-analysis-setting-role.view-all")->with(compact('groupsPerGapAnalysisSettingRole'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $role = role::whereNull('deleted_at')->get();
        $groupsPerGapAnalysisSetting = groupsPerGapAnalysisSetting::whereNull('deleted_at')->get();
        return view("admin.groups-per-gap-analysis-setting-role.create")->with(compact('role','groupsPerGapAnalysisSetting'));
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
        $groupsPerGapAnalysisSettingRole = new groupsPerGapAnalysisSettingRole;
        $groupsPerGapAnalysisSettingRole->gpgas_id_foreign = $request->input('gpgasDropdown');
        $groupsPerGapAnalysisSettingRole->roleID = $request->input('roleDropdown');
        $groupsPerGapAnalysisSettingRole->save();

        return \Redirect::route('groupsPerGapAnalysisSettingRoles.index')->with('success', 'Role assigned to Groups Per Gap Analysis Setting.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\groupsPerGapAnalysisSettingRole  $groupsPerGapAnalysisSettingRole
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $groupsPerGapAnalysisSettingRole = groupsPerGapAnalysisSettingRole::find($id);
        return view("admin.groups-per-gap-analysis-setting-role.view")->with(compact('groupsPerGapAnalysisSettingRole'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\groupsPerGapAnalysisSettingRole  $groupsPerGapAnalysisSettingRole
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $groupsPerGapAnalysisSettingRole = groupsPerGapAnalysisSettingRole::find($id);
        $role = role::whereNull('deleted_at')->get();
        $groupsPerGapAnalysisSetting = groupsPerGapAnalysisSetting::whereNull('deleted_at')->get();

        return view("admin.groups-per-gap-analysis-setting-role.edit")->with(compact('role','groupsPerGapAnalysisSetting','groupsPerGapAnalysisSettingRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\groupsPerGapAnalysisSettingRole  $groupsPerGapAnalysisSettingRole
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $groupsPerGapAnalysisSettingRole = groupsPerGapAnalysisSettingRole::find($id);
        $groupsPerGapAnalysisSettingRole->gpgas_id_foreign = $request->input('gpgasDropdown');
        $groupsPerGapAnalysisSettingRole->roleID = $request->input('roleDropdown');
        $groupsPerGapAnalysisSettingRole->save();

        return \Redirect::route('groupsPerGapAnalysisSettingRoles.index')->with('success', 'Groups Per Gap Analysis Setting Per Role Successfully Edited.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\groupsPerGapAnalysisSettingRole  $groupsPerGapAnalysisSettingRole
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $groupsPerGapAnalysisSettingRole = groupsPerGapAnalysisSettingRole::find($id);
        $groupsPerGapAnalysisSettingRole->delete();
        return \Redirect::route('groupsPerGapAnalysisSettingRoles.index')->with('success', 'Successfully Deleted.');
    }
}
