<?php

namespace App\Http\Controllers;

use App\level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view("admin.level.view-all");
    }

    public function getAll()
    {
        
        $data = level::whereNull('deleted_at');
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
        return view("admin.level.create");
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
        $level = new level;
        $level->name = $request->input('name');
        $level->weight = $request->input('weight');
        $level->definition = $request->input('definition');
        $level->save();

        return redirect('admin/level')->with('success', 'Level successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\level  $level
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $level = level::find($id);

        return view("admin.level.view")->with(compact('level'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\level  $level
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $level = level::find($id);
        return view("admin.level.edit")->with(compact('level'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\level  $level
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $level = level::find($id);
        $level->name = $request->input('name');
        $level->weight = $request->input('weight');
        $level->definition = $request->input('definition');
        $level->save();


        return redirect('admin/level')->with('success', 'Level successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\level  $level
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $level = level::find($id);
        $level->delete();
        return redirect('admin/level')->with('success', 'Level successfully deleted.');
    }
}
