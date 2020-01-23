<?php

namespace App\Http\Controllers;

use App\competencyPerRoleTarget;
use App\competency;
use App\level;
use App\role;
use App\listOfCompetenciesPerRole;
use App\targetSource;
use Illuminate\Http\Request;

class CompetencyPerRoleTargetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $role = role::whereNull('deleted_at')->get();
        $level = level::whereNull('deleted_at')->get();
        $competency = competency::whereNull('deleted_at')->get();
        $competencyPerRoleTarget = competencyPerRoleTarget::whereNull('deleted_at')->get();
        $targetSource = targetSource::whereNull('deleted_at')->get();
        //return $competencyPerRoleTarget;
        return view('admin.competency-per-role-target.view-all')->with(compact('role','level','competency','competencyPerRoleTarget','targetSource'));
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
        $model = listOfCompetenciesPerRole::whereNull('deleted_at')->get();
        $level = level::whereNull('deleted_at')->get();
        $competency = competency::whereNull('deleted_at')->get();
        $targetSource = targetSource::whereNull('deleted_at')->get();
        return view('admin.competency-per-role-target.create')->with(compact('role','level','competency','competencyPerRoleTarget','targetSource','model'));
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

        $competencyPerRoleTarget = new competencyPerRoleTarget;
        $competencyPerRoleTarget->roleID = $request->input('roleID');
        $competencyPerRoleTarget->competencyID = $request->input('competencyID');
        $competencyPerRoleTarget->competencyTargetID = $request->input('targetLevelID');
        $competencyPerRoleTarget->sourceID = $request->input('targetSourceID');
        $competencyPerRoleTarget->save();

        return redirect('admin/competency-role-target')->with('success', 'Target successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\competencyPerRoleTarget  $competencyPerRoleTarget
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $competencyPerRoleTarget = competencyPerRoleTarget::find($id);
        $role = role::find($competencyPerRoleTarget->roleID);
        $level = level::find($competencyPerRoleTarget->competencyTargetID);
        $competency = competency::find($competencyPerRoleTarget->competencyID);
        $targetSource = targetSource::find($competencyPerRoleTarget->sourceID);

        return view('admin.competency-per-role-target.view')->with(compact('role','level','competency','competencyPerRoleTarget','targetSource'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\competencyPerRoleTarget  $competencyPerRoleTarget
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $competencyPerRoleTarget = competencyPerRoleTarget::find($id);
        $role = role::whereNull('deleted_at')->get();
        $model = listOfCompetenciesPerRole::whereNull('deleted_at')->get();
        $level = level::whereNull('deleted_at')->get();
        $competency = competency::whereNull('deleted_at')->get();
        $targetSource = targetSource::whereNull('deleted_at')->get();

        return view('admin.competency-per-role-target.edit')->with(compact('role','level','competency','competencyPerRoleTarget','targetSource','model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\competencyPerRoleTarget  $competencyPerRoleTarget
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $competencyPerRoleTarget = competencyPerRoleTarget::find($id);
        $competencyPerRoleTarget->roleID = $request->input('roleID');
        $competencyPerRoleTarget->competencyID = $request->input('competencyID');
        $competencyPerRoleTarget->competencyTargetID = $request->input('targetLevelID');
        $competencyPerRoleTarget->sourceID = $request->input('targetSourceID');
        $competencyPerRoleTarget->save();

        return redirect('admin/competency-role-target')->with('success', 'Target successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\competencyPerRoleTarget  $competencyPerRoleTarget
     * @return \Illuminate\Http\Response
     */
    public function destroy(competencyPerRoleTarget $competencyPerRoleTarget)
    {
        //
    }
}
