<?php

namespace App\Http\Controllers;

use App\job;
use App\employee_data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view("admin.job.view-all");
    }

    public function getAll()
    {
        
        $data = job::whereNull('deleted_at');
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
        return view("admin.job.create");
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
        $jobValidate = job::where('name',$request->input('name'))->whereNull('deleted_at')->get();
        if(count($jobValidate)>0){
            return Redirect::back()->withErrors(['Job is already existing.']);
        }

        $job = new job;
        $job->name = $request->input('name');
        $job->save();

        return redirect('admin/job')->with('success', 'Job successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\job  $job
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $job = job::find($id);
        $employee = employee_data::where('jobID','=',$job->id)->whereNull('deleted_at')->get();

        return view("admin.job.view")->with(compact('job','employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\job  $job
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $job = job::find($id);
        return view("admin.job.edit")->with(compact('job'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\job  $job
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $job = job::find($id);
        $job->name = $request->input('name');
        $job->save();

        return redirect('admin/job')->with('success', 'Job successfully updated.');
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
        $job = job::find($id);
        $job->delete();
        return redirect('admin/job')->with('success', 'Job successfully deleted.');
    }
}
