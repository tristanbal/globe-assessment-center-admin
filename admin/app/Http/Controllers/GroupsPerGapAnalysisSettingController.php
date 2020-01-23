<?php

namespace App\Http\Controllers;

use App\groupsPerGapAnalysisSetting;
use App\employee_data;
use App\group;
use App\division;
use App\department;
use App\section;
use App\gapAnalysisSetting;
use Illuminate\Http\Request;
use stdClass;

class GroupsPerGapAnalysisSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $groupsPerGapAnalysisSetting = groupsPerGapAnalysisSetting::whereNull('deleted_at')->get();

        $selectedDataType = null;
        $dataType = null;
        $GPASetting = array();
        foreach($groupsPerGapAnalysisSetting as $groupsPerGapAnalysisSettingItem){
            switch($groupsPerGapAnalysisSettingItem->selectedDataType){
                case 1:
                    $selectedDataType = 'Group';
                    $dataType = group::find($groupsPerGapAnalysisSettingItem->dataTypeID);
                break;
                case 2:
                    $selectedDataType = 'Division';
                    $dataType = division::find($groupsPerGapAnalysisSettingItem->dataTypeID);
                break;
                case 3:
                    $selectedDataType = 'Department';
                    $dataType = department::find($groupsPerGapAnalysisSettingItem->dataTypeID);
                break;
                case 4:
                    $selectedDataType = 'Section';
                    $dataType = section::find($groupsPerGapAnalysisSettingItem->dataTypeID);
                break;
            }

            $gapAnalysisSettingRow = gapAnalysisSetting::find($groupsPerGapAnalysisSettingItem->gapAnalysisSettingID);

            $gpasettingrow = new stdClass;
            $gpasettingrow->id = $groupsPerGapAnalysisSettingItem->id;
            $gpasettingrow->name = $groupsPerGapAnalysisSettingItem->name;
            $gpasettingrow->selectedDataType = $selectedDataType;
            $gpasettingrow->dataTypeID = $dataType->name;
            $gpasettingrow->gapAnalysisSettingID = $gapAnalysisSettingRow->name;
            $gpasettingrow->created_at = $groupsPerGapAnalysisSettingItem->created_at;
            $gpasettingrow->updated_at = $groupsPerGapAnalysisSettingItem->updated_at;

            array_push($GPASetting,$gpasettingrow);
        }
        return view("admin.groups-per-gap-analysis-setting.view-all")->with(compact('groupsPerGapAnalysisSetting','GPASetting'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $employees = employee_data::whereNull('deleted_at')->get();
        $group = group::whereNull('deleted_at')->get();
        $division = division::whereNull('deleted_at')->get();
        $department = department::whereNull('deleted_at')->get();
        $section = section::whereNull('deleted_at')->get();
        $gapAnalysisSetting = gapAnalysisSetting::whereNull('deleted_at')->get();

        return view("admin.groups-per-gap-analysis-setting.create")->with(compact('employees','group','division','department','section','gapAnalysisSetting'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $selectedDataType = $request->input('selectionDropdown');

        
        switch($selectedDataType){
            case 1: 
                if($request->input('selectionDropdown') == null){
                    return \Redirect::route('groupsPerGapAnalysisSettings.create')->with('error', 'Invalid Input.');
                }else{
                    $dataTypeID = $request->input('dataSelectedID1');
                }
                break;
            case '2':
                if($request->input('selectionDropdown') == null){
                    return \Redirect::route('groupsPerGapAnalysisSettings.create')->with('error', 'Invalid Input.');
                }else{
                    $dataTypeID = $request->input('dataSelectedID2');
                }
                break;
            case '3':
                if($request->input('selectionDropdown') == null){
                    return \Redirect::route('groupsPerGapAnalysisSettings.create')->with('error', 'Invalid Input.');
                }else{
                    $dataTypeID = $request->input('dataSelectedID3');
                }
                break;
            case '4':
                if($request->input('selectionDropdown') == null){
                    return \Redirect::route('groupsPerGapAnalysisSettings.create')->with('error', 'Invalid Input.');
                }else{
                    $dataTypeID = $request->input('dataSelectedID4');
                }
                break;
            default:
                return 'false';
                break;
        }
        

        $groupsPerGapAnalysisSetting = new groupsPerGapAnalysisSetting;
        $groupsPerGapAnalysisSetting->name = $request->input('name');
        $groupsPerGapAnalysisSetting->selectedDataType =$selectedDataType;
        $groupsPerGapAnalysisSetting->dataTypeID = $dataTypeID;
        $groupsPerGapAnalysisSetting->gapAnalysisSettingID = $request->input('settingDropdown');
        $groupsPerGapAnalysisSetting->save();

        return \Redirect::route('groupsPerGapAnalysisSettings.index')->with('success', 'Groups Per Gap Analysis Setting Assigned.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\groupsPerGapAnalysisSetting  $groupsPerGapAnalysisSetting
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $groupsPerGapAnalysisSetting = groupsPerGapAnalysisSetting::find($id);
        return view("admin.groups-per-gap-analysis-setting.view")->with(compact('groupsPerGapAnalysisSetting'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\groupsPerGapAnalysisSetting  $groupsPerGapAnalysisSetting
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

        $groupsPerGapAnalysisSetting = groupsPerGapAnalysisSetting::find($id);
        $employees = employee_data::whereNull('deleted_at')->get();
        $group = group::whereNull('deleted_at')->get();
        $division = division::whereNull('deleted_at')->get();
        $department = department::whereNull('deleted_at')->get();
        $section = section::whereNull('deleted_at')->get();
        $gapAnalysisSetting = gapAnalysisSetting::whereNull('deleted_at')->get();

        return view("admin.groups-per-gap-analysis-setting.edit")->with(compact('groupsPerGapAnalysisSetting','employees','group','division','department','section','gapAnalysisSetting'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\groupsPerGapAnalysisSetting  $groupsPerGapAnalysisSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, groupsPerGapAnalysisSetting $groupsPerGapAnalysisSetting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\groupsPerGapAnalysisSetting  $groupsPerGapAnalysisSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(groupsPerGapAnalysisSetting $groupsPerGapAnalysisSetting)
    {
        //
        $groupsPerGapAnalysisSetting = groupsPerGapAnalysisSetting::find($id);
        $groupsPerGapAnalysisSetting->delete();

        return \Redirect::route('groupsPerGapAnalysisSettings.index')->with('success', 'Groups Per Gap Analysis Setting Successfully UnAssigned.');
    }
}
