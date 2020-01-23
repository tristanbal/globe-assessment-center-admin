<?php

namespace App\Http\Controllers;

use App\talentSegment;
use Illuminate\Http\Request;

class TalentSegmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view("admin.talent-segment.view-all");
    }

    public function getAll()
    {
        
        $data = talentSegment::whereNull('deleted_at');
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
        return view("admin.talent-segment.create");
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
        $talentSegment = new talentSegment;
        $talentSegment->name = $request->input('name');
        $talentSegment->save();

        return redirect('admin/talent-segment')->with('success', 'Talent Segment successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\talentSegment  $talentSegment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $talentSegment = talentSegment::find($id);

        return view("admin.talent-segment.view")->with(compact('talentSegment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\talentSegment  $talentSegment
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $talentSegment = talentSegment::find($id);
        return view("admin.talent-segment.edit")->with(compact('talentSegment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\talentSegment  $talentSegment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $talentSegment = talentSegment::find($id);
        $talentSegment->name = $request->input('name');
        $talentSegment->save();

        return redirect('admin/talent-segment')->with('success', 'Talent Segment successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\talentSegment  $talentSegment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $talentSegment = talentSegment::find($id);
        $talentSegment->delete();
        return redirect('admin/talent-segment')->with('success', 'Talent Segment successfully deleted.');
    }
}
