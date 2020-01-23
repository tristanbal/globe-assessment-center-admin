<?php

namespace App\Http\Controllers;

use App\proficiency;
use App\competency;
use App\level;
use DB;
use Illuminate\Http\Request;

class ProficiencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $level = level::whereNull('deleted_at')->get();
        $competency = competency::whereNull('deleted_at')->get();
        return view("admin.proficiency.view-all")->with(compact('level','competency'));
    }

    public function getAll()
    {
        $data = DB::table('proficiencies')
        ->select('proficiencies.id as id','proficiencies.levelID as levelID','proficiencies.definition as definition','competencies.id as competencyID','competencies.name as competencyName','proficiencies.created_at as created_at','proficiencies.updated_at as updated_at')
        ->join('competencies','proficiencies.competencyID','=','competencies.id')
        ->whereNull('proficiencies.deleted_at');
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
        $level = level::whereNull('deleted_at')->get();
        $competency = competency::whereNull('deleted_at')->get();
        return view("admin.proficiency.create")->with(compact('level','competency'));
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
        $proficiency = new proficiency;
        $proficiency->definition = $request->input('definition');
        $proficiency->competencyID = $request->input('competencyID');
        $proficiency->levelID = $request->input('levelID');
        $proficiency->save();

        return redirect('admin/proficiency')->with('success', 'Proficiency successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\proficiency  $proficiency
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $proficiency = proficiency::find($id);
        $competency = competency::where('id','=',$proficiency->competencyID)->whereNull('deleted_at')->first();
        $level = level::where('id','=',$proficiency->levelID)->whereNull('deleted_at')->first();

        return view("admin.proficiency.view")->with(compact('level','competency','proficiency'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\proficiency  $proficiency
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $proficiency = proficiency::find($id);
        $competency = competency::whereNull('deleted_at')->get();
        $level = level::whereNull('deleted_at')->get();

        return view("admin.proficiency.edit")->with(compact('level','competency','proficiency'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\proficiency  $proficiency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $proficiency = proficiency::find($id);
        $proficiency->competencyID = $request->input('competencyID');
        $proficiency->levelID = $request->input('levelID');
        $proficiency->definition = $request->input('definition');
        $proficiency->save();

        return redirect('admin/proficiency')->with('success', 'Proficiency successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\proficiency  $proficiency
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $proficiency = proficiency::find($id);
        $proficiency->delete();
        return redirect('admin/proficiency')->with('success', 'Proficiency successfully deleted.');
    }
}
