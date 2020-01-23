<?php

namespace App\Http\Controllers;

use App\targetSource;
use Illuminate\Http\Request;

class TargetSourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view("admin.target-source.view-all");
    }
    public function getAll()
    {
        
        $data = targetSource::whereNull('deleted_at')->get();
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
        return view("admin.target-source.create");
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
        $targetSource = new targetSource;
        $targetSource->name = $request->input('name');
        $targetSource->save();

        return redirect('admin/target-source')->with('success', 'Target Source successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\targetSource  $targetSource
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $targetSource = targetSource::find($id);

        return view("admin.target-source.view")->with(compact('targetSource'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\targetSource  $targetSource
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $targetSource = targetSource::find($id);
        return view("admin.target-source.edit")->with(compact('targetSource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\targetSource  $targetSource
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $targetSource = targetSource::find($id);
        $targetSource->name = $request->input('name');
        $targetSource->save();

        return redirect('admin/target-source')->with('success', 'Target Source successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\targetSource  $targetSource
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $targetSource = targetSource::find($id);
        $targetSource->delete();
        return redirect('admin/target-source')->with('success', 'Target Source successfully deleted.');
    }
}
