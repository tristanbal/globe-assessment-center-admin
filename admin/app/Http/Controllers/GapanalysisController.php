<?php

namespace App\Http\Controllers;

use App\gapAnalysisSetting;
use App\gapAnalysisSettingAssessmentType;
use Illuminate\Http\Request;
use DB;

class GapanalysisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $gapanalysisSettings = new gapAnalysisSetting;

        $gapanalysisSettings->name = $request->name;
        $gapanalysisSettings->description = $request->description;
        $gapanalysisSettings->is_active = 0;

        $gapanalysisSettings->save();


        $ctr = count($request->assessmentType);

        for ($i=0; $i < $ctr; $i++) { 
            $gapanalysisSettingsType = new gapAnalysisSettingAssessmentType;

            $gapanalysisSettingsType->gas_id_foreign = $gapanalysisSettings->id;
            $gapanalysisSettingsType->assessmentTypeID = $request->assessmentType[$i];
            $gapanalysisSettingsType->percentAssigned = $request->percentage[$i];

            $gapanalysisSettingsType->save();
        }

        return redirect('admin/report/view-employee-per-group');
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        DB::table('gap_analysis_settings')->update(['is_active' => 0]);

        $gapanalysisSettings = gapAnalysisSetting::find($request->activeSetting);

        $gapanalysisSettings->is_active = 1;

        $gapanalysisSettings->save();

        return redirect('admin/report/view-employee-per-group');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
