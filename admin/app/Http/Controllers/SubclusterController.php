<?php

namespace App\Http\Controllers;

use DB;
use App\subcluster;
use App\cluster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SubclusterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $cluster = cluster::all();
        return view("admin.subcluster.view-all")->with(compact('cluster'));
    }

    public function getAll()
    {
        
        $data = DB::table('subclusters')
            ->select('subclusters.id as id','subclusters.name as subclusterName','clusters.id as clusterID','clusters.name as clusterName','subclusters.created_at as created_at','subclusters.updated_at as updated_at')
            ->join('clusters','subclusters.clusterID','=','clusters.id')
            ->whereNull('subclusters.deleted_at');
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
        $cluster = cluster::all();
        return view("admin.subcluster.create")->with(compact('cluster'));
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
        $subclusterValidate = subcluster::where('clusterID',$request->input('clusterID'))->where('name',$request->input('name'))->whereNull('deleted_at')->get();
        if(count($subclusterValidate)>0){
            return Redirect::back()->withErrors(['Sub-Cluster is already existing.']);
        }

        $subcluster = new subcluster;
        $subcluster->name = $request->input('name');
        $subcluster->clusterID = $request->input('clusterID');
        $subcluster->save();

        return redirect('admin/subcluster')->with('success', 'Sub-Cluster successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\subcluster  $subcluster
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $subcluster = subcluster::find($id);
        $cluster = cluster::where('id','=',$subcluster->clusterID)->first();

        return view("admin.subcluster.view")->with(compact('subcluster','cluster'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\subcluster  $subcluster
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $subcluster = subcluster::find($id);
        $cluster = cluster::all();
        
        return view("admin.subcluster.edit")->with(compact('subcluster','cluster'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\subcluster  $subcluster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $subcluster = subcluster::find($id);
        $subcluster->name = $request->input('name');
        $subcluster->clusterID = $request->input('clusterID');
        $subcluster->save();
        

        return redirect('admin/subcluster')->with('success', 'Sub-Cluster successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\subcluster  $subcluster
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $subcluster = subcluster::find($id);
        $subcluster->delete();
        return redirect('admin/subcluster')->with('success', 'Sub-Cluster successfully deleted.');
    }
}
