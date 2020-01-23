<?php

namespace App\Http\Controllers;

use App\intervention;
use App\competency;
use App\training;
use App\group;
use App\division;
use DB;
use Illuminate\Http\Request;

class InterventionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $group = group::whereNull('deleted_at')->get();
        $division = division::whereNull('deleted_at')->get();
        $training = training::whereNull('deleted_at')->get();
        $competency = competency::whereNull('deleted_at')->get();
        $intervention = intervention::whereNull('deleted_at')->get();
        $data = DB::table('interventions')
            ->select('interventions.id as id','groups.name as groupName','divisions.name as divisionName','competencies.name as competencyName','trainings.name as trainingName','interventions.created_at as created_at','interventions.updated_at as updated_at')
            ->join('groups','interventions.groupID','=','groups.id')
            ->join('divisions','interventions.divisionID','=','divisions.id')
            ->join('competencies','interventions.competencyID','=','competencies.id')
            ->join('trainings','interventions.trainingID','=','trainings.id')
            ->whereNull('interventions.deleted_at')->get();
        return view("admin.intervention.view-all")->with(compact('group','division','training','competency','data'));

    }

    public function getAll()
    {
        $data = DB::table('interventions')
            ->select('interventions.id as id','groups.name as groupName','divisions.name as divisionName','competencies.name as competencyName','trainings.name as trainingName','interventions.created_at as created_at','interventions.updated_at as updated_at')
            ->join('groups','interventions.groupID','=','groups.id')
            ->join('divisions','interventions.divisionID','=','divisions.id')
            ->join('competencies','interventions.competencyID','=','competencies.id')
            ->join('trainings','interventions.trainingID','=','trainings.id')
            ->whereNull('interventions.deleted_at')->get();
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
        $training = training::whereNull('deleted_at')->get();
        $competency = competency::whereNull('deleted_at')->get();
        return view("admin.intervention.create")->with(compact('group','division','training','competency'));
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
        $intervention = new intervention;
        $intervention->groupID = $request->input('groupsDropdown');
        $intervention->divisionID = $request->input('divisionsDropdown');
        $intervention->competencyID = $request->input('competencyID');
        $intervention->trainingID = $request->input('trainingID');
        $intervention->save();

        return redirect('admin/intervention')->with('success', 'Intervention successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\intervention  $intervention
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $intervention = intervention::find($id);
        $group = group::where('id','=',$intervention->groupID)->first();
        $division = division::where('id','=',$intervention->divisionID)->first();
        $competency = competency::where('id','=',$intervention->competencyID)->first();
        $training = training::where('id','=',$intervention->trainingID)->first();

        return view("admin.intervention.view")->with(compact('group','division','competency','training','intervention'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\intervention  $intervention
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $intervention = intervention::find($id);
        $group = group::whereNull('deleted_at')->get();
        $division = division::whereNull('deleted_at')->get();
        $training = training::whereNull('deleted_at')->get();
        $competency = competency::whereNull('deleted_at')->get();

        return view("admin.intervention.edit")->with(compact('group','division','competency','training','intervention'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\intervention  $intervention
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $intervention = intervention::find($id);
        $intervention->groupID = $request->input('groupsDropdown');
        $intervention->divisionID = $request->input('divisionsDropdown');
        $intervention->competencyID = $request->input('competencyID');
        $intervention->trainingID = $request->input('trainingID');
        $intervention->save();

        return redirect('admin/intervention')->with('success', 'Intervention successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\intervention  $intervention
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $intervention = intervention::find($id);
        $intervention->delete();
        return redirect('admin/intervention')->with('success', 'Intervention successfully deleted.');
    }
}
