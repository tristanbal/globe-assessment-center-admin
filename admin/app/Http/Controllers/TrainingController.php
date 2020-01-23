<?php

namespace App\Http\Controllers;

use DB;
use App\training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view("admin.training.view-all");
    }

    public function getAll()
    {
        
        $data = training::whereNull('deleted_at')->get();
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
        return view("admin.training.add");
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
        $trainingValidate = training::where('name',$request->input('name'))->whereNull('deleted_at')->get();
        if(count($trainingValidate)>0){
            return Redirect::back()->withErrors(['Training is already existing.']);
        }

        $training = new training;
        $training->name = $request->input('name');
        $training->save();

        return redirect('admin/training')->with('success', 'Training successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\training  $training
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $training = training::find($id);
        return view("admin.training.view")->with(compact('training'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\training  $training
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $training = training::find($id);
        return view("admin.training.edit")->with(compact('training'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\training  $training
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        
        $training = training::find($id);
        $training->name = $request->input('name');
        $training->save();

        return redirect('admin/training')->with('success', 'Training successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\training  $training
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $training = training::find($id);
        $training->delete();

        return redirect('/admin/training')->with('success', 'Training successfully deleted.');

    }
}
