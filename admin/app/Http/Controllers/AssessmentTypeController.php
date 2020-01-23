<?php

namespace App\Http\Controllers;

use DB;
use App\assessmentType;
use App\relationship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
//use DataTablesYajra;
use Session;


class AssessmentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $relationship = relationship::all();
        return view("admin.assessment-type.view-all")->with(compact('relationship'));
    }

    public function getAll()
    {
        
        $data = DB::table('assessment_types')
            ->select('assessment_types.id as id','assessment_types.name as assessmentName','relationships.id as relationshipID','relationships.name as relationshipName','assessment_types.created_at as created_at','assessment_types.updated_at as updated_at')
            ->join('relationships','assessment_types.relationshipID','=','relationships.id')
            ->whereNull('assessment_types.deleted_at');
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
        
        $relationship = relationship::whereNull('deleted_at')->get();
        return view("admin.assessment-type.create")->with(compact('relationship'));
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
        $typeValidate = assessmentType::where('relationshipID',$request->input('relationshipID'))->where('name',$request->input('name'))->whereNull('deleted_at')->get();
        if(count($typeValidate)>0){
            return Redirect::back()->withErrors(['Assessment Type is already existing.']);
        }

        $type = new assessmentType;
        $type->name = $request->input('name');
        $type->definition = $request->input('definition');
        $type->relationshipID = $request->input('relationshipID');
        $type->save();

        return redirect('admin/assessment-type')->with('success', 'Assessment type successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\assessmentType  $assessmentType
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $type = assessmentType::find($id);
        $relationship = relationship::where('id','=',$type->relationshipID)->first();

        return view("admin.assessment-type.view")->with(compact('type','relationship'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\assessmentType  $assessmentType
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $type = assessmentType::find($id);
        //$relationship = relationship::where('id','=',$type->relationshipID)->whereNull('deleted_at')->first();
        $relationship = relationship::whereNull('deleted_at')->get();
        //return $relationship;
        return view("admin.assessment-type.edit")->with(compact('type','relationship'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\assessmentType  $assessmentType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //
        $type = assessmentType::find($id);
        $type->name = $request->input('name');
        $type->definition = $request->input('definition');
        $type->relationshipID = $request->input('relationshipID');
        $type->save();
        

        return redirect('admin/assessment-type')->with('success', 'Assessment type successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\assessmentType  $assessmentType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $type = assessmentType::find($id);
        $type->delete();
        return redirect('admin/assessment-type')->with('success', 'Assessment type successfully deleted.');
    }
}
