<?php

namespace App\Http\Controllers;

use App\competency;
use App\cluster;
use App\subcluster;
use App\level;
use App\talentSegment;
use App\role;
use App\listOfCompetenciesPerRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CompetencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $cluster = cluster::whereNull('deleted_at')->get();
        $subcluster = subcluster::whereNull('deleted_at')->get();
        $level = level::whereNull('deleted_at')->get();
        $talentSegment = talentSegment::whereNull('deleted_at')->get();
        return view("admin.competency.view-all")->with(compact('level','cluster','subcluster','talentSegment'));
    }

    public function getAll()
    {
        
        $data = competency::whereNull('deleted_at');
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
        $subcluster = subcluster::whereNull('deleted_at')->get();
        $level = level::whereNull('deleted_at')->get();
        $talentSegment = talentSegment::whereNull('deleted_at')->get();
        return view("admin.competency.create")->with(compact('level','subcluster','talentSegment'));
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
        $competencyValidate = competency::where('name',$request->input('name'))->whereNull('deleted_at')->get();
        if(count($competencyValidate)>0){
            return Redirect::back()->withErrors(['Competency is already existing.']);
        }

        $subcluster = subcluster::find($request->input('subclusterID'))->first();

        $competency = new competency;
        $competency->name = $request->input('name');
        $competency->talentSegmentID = $request->input('talentSegmentID');
        $competency->clusterID = $subcluster->clusterID;
        $competency->subclusterID = $subcluster->id;
        $competency->maximumLevelID = $request->input('maximumLevelID');
        $competency->minimumLevelID = $request->input('minimumLevelID');
        $competency->definition = $request->input('definition');
        $competency->save();

        return redirect('admin/competency')->with('success', 'Competency successfully added.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\competency  $competency
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $competency = competency::find($id);
        $subcluster = subcluster::find($competency->subclusterID)->first();
        $cluster = cluster::find($subcluster->id)->first();
        $talentSegment = talentSegment::find($competency->talentSegmentID)->first();
        $maximumLevel = level::find($competency->maximumLevelID)->first();
        $minimumLevel = level::find($competency->minimumLevelID)->first();
        $definition = $competency->definition;
        $model = listOfCompetenciesPerRole::whereNull('deleted_at')->where('competencyID',$competency->id)->get();
        
        return view("admin.competency.view")->with(compact('cluster','competency','subcluster','talentSegement','maximumLevel','minimumLevel','definition','model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\competency  $competency
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $competency = competency::find($id);
        $subcluster = subcluster::whereNull('deleted_at')->get();
        $talentSegment = talentSegment::whereNull('deleted_at')->get();
        $level = level::whereNull('deleted_at')->get();
        
        //return $maximumLevel;
        return view("admin.competency.edit")->with(compact('competency','subcluster','talentSegment','level'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\competency  $competency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $subcluster = subcluster::find($request->input('subclusterID'))->first();

        $competency = competency::find($id);
        $competency->name = $request->input('name');
        $competency->talentSegmentID = $request->input('talentSegmentID');
        $competency->clusterID = $subcluster->clusterID;
        $competency->subclusterID = $subcluster->id;
        $competency->maximumLevelID = $request->input('maximumLevelID');
        $competency->minimumLevelID = $request->input('minimumLevelID');
        $competency->definition = $request->input('definition');
        $competency->save();

        return redirect('admin/competency')->with('success', 'Competency successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\competency  $competency
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $competency = competency::find($id);
        $competency->delete();
        return redirect('admin/competency')->with('success', 'Competency successfully deleted.');
    }
}
