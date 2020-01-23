<?php

namespace App\Http\Controllers;

use App\band;
use App\employee_data;
use App\group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view("admin.band.view-all");
    }

    public function getAll()
    {
        $data = band::whereNull('deleted_at');
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
        return view("admin.band.create");
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
        $bandValidate = band::where('name',$request->input('name'))->whereNull('deleted_at')->get();
        if(count($bandValidate)>0){
            return Redirect::back()->withErrors(['Band is already existing.']);
        }

        $band = new band;
        $band->name = $request->input('name');
        $band->save();

        return redirect('admin/band')->with('success', 'Band successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\band  $band
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $band = band::find($id);
        $employee = employee_data::where('bandID','=',$band->id)->whereNull('deleted_at')->get();
        return view("admin.band.view")->with(compact('band','employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\band  $band
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $band = band::find($id);
        return view("admin.band.edit")->with(compact('band'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\band  $band
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $band = band::find($id);
        $band->name = $request->input('name');
        $band->save();

        return redirect('admin/band')->with('success', 'Band successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\band  $band
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $band = band::find($id);
        $band->delete();
        return redirect('admin/band')->with('success', 'Band successfully deleted.');
    }
}
