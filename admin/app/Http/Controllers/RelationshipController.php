<?php

namespace App\Http\Controllers;

use App\relationship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RelationshipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view("admin.relationship-type.view-all");
    }

    public function getAll()
    {
        
        $data = relationship::whereNull('deleted_at');
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
        return view("admin.relationship-type.create");
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
        $relationshipValidate = relationship::where('name',$request->input('name'))->whereNull('deleted_at')->get();
        if(count($relationshipValidate)>0){
            return Redirect::back()->withErrors(['Relationship is already existing.']);
        }

        $type = new relationship;
        $type->name = $request->input('name');
        $type->save();

        return redirect('admin/relationship-type')->with('success', 'Relationship type successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\relationship  $relationship
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $type = relationship::find($id);

        return view("admin.relationship-type.view")->with(compact('type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\relationship  $relationship
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $type = relationship::find($id);
        return view("admin.relationship-type.edit")->with(compact('type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\relationship  $relationship
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //
        $type = relationship::find($id);
        $type->name = $request->input('name');
        $type->save();
        

        return redirect('admin/relationship-type')->with('success', 'Relationship type successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\relationship  $relationship
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $type = relationship::find($id);
        $type->delete();
        return redirect('admin/relationship-type')->with('success', 'Relationship type successfully deleted.');
    }
}
