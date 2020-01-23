<?php

namespace App\Http\Controllers;

use App\cluster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ClusterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view("admin.cluster.view-all");
    }

    public function getAll()
    {
        
        $data = cluster::whereNull('deleted_at');
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
        return view("admin.cluster.create");
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
        $clusterValidate = cluster::where('name',$request->input('name'))->whereNull('deleted_at')->get();
        if(count($clusterValidate)>0){
            return Redirect::back()->withErrors(['Cluster is already existing.']);
        }

        $cluster = new cluster;
        $cluster->name = $request->input('name');
        $cluster->save();

        return redirect('admin/cluster')->with('success', 'Cluster successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\cluster  $cluster
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $cluster = cluster::find($id);

        return view("admin.cluster.view")->with(compact('cluster'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\cluster  $cluster
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $cluster = cluster::find($id);
        return view("admin.cluster.edit")->with(compact('cluster'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\cluster  $cluster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $cluster = cluster::find($id);
        $cluster->name = $request->input('name');
        $cluster->save();

        return redirect('admin/cluster')->with('success', 'Cluster successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $cluster = cluster::find($id);
        $cluster->delete();
        return redirect('admin/cluster')->with('success', 'Cluster successfully deleted.');
    }
}
