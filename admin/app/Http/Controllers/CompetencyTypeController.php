<?php

namespace App\Http\Controllers;

use App\competencyType;
use Illuminate\Http\Request;

class CompetencyTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view("admin.competency-type.view-all");
    }

    public function getAll()
    {
        
        $data = competencyType::whereNull('deleted_at');
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
        return view("admin.competency-type.create");
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
        $competencyType = new competencyType;
        $competencyType->name = $request->input('name');
        $competencyType->definition = $request->input('definition');
        $competencyType->save();

        return redirect('admin/competency-type')->with('success', 'Competency type successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\competencyType  $competencyType
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $competencyType = competencyType::find($id);

        return view("admin.competency-type.view")->with(compact('competencyType'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\competencyType  $competencyType
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $competencyType = competencyType::find($id);
        return view("admin.competency-type.edit")->with(compact('competencyType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\competencyType  $competencyType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //
        $competencyType = competencyType::find($id);
        $competencyType->name = $request->input('name');
        $competencyType->definition = $request->input('definition');
        $competencyType->save();

        return redirect('admin/competency-type')->with('success', 'Competency type successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\competencyType  $competencyType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $competencyType = competencyType::find($id);
        $competencyType->delete();
        return redirect('admin/competency-type')->with('success', 'Competency type successfully deleted.');
    }
}
