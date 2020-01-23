<?php

namespace App\Http\Controllers;

use App\assessment;
use Illuminate\Http\Request;

class AssessmentController extends Controller
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
    public function create()
    {
        //
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
     * @param  \App\assessment  $assessment
     * @return \Illuminate\Http\Response
     */
    public function show(assessment $assessment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\assessment  $assessment
     * @return \Illuminate\Http\Response
     */
    public function edit(assessment $assessment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\assessment  $assessment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id,$employeeID)
    {
        //
        $assessment = assessment::where('assessmentTypeID',$id)->where('employeeID',$employeeID)->whereNull('deleted_at')->first();
        $assessment->evaluationVersionID = 0;
        $assessment->save();

        return redirect()->back()->with('success', 'Assessment reset.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\assessment  $assessment
     * @return \Illuminate\Http\Response
     */
    public function destroy(assessment $assessment)
    {
        //
    }

    public function changeVersion(Request $request,$employeeID)
    {
        $assessment = assessment::where('assessmentTypeID',$request->input('assessmentTypeID'))->where('employeeID',$employeeID)->whereNull('deleted_at')->first();
        
        $assessment->evaluationVersionID = $request->input('evaluationID');
        $assessment->save();

        return redirect()->back()->with('success', 'Assessment Versioning is Changed.');
    }
}
