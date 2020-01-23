<?php

namespace App\Http\Controllers;

use App\orderModel;
use App\orderModelCompetency;
use App\competency;
use App\competencyType;
use App\level; 
use App\group;
use App\employee_data;
use App\role;
use App\listOfCompetenciesPerRole;
use Illuminate\Support\Facades\Redirect;
use DB;
use Illuminate\Http\Request;

class OrderModelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $pendingModel = orderModel::where('approval',0)->whereNull('deleted_at')->get();
        //return $pendingModel;
        $approvedModel = orderModel::where('approval',1)->whereNull('deleted_at')->get();
        $notApprovedModel = orderModel::where('approval',2)->whereNull('deleted_at')->get();
        $group = Group::all();

        return view('admin.model.submission.index')->with(compact('pendingModel','approvedModel','group','notApprovedModel'));
    }

    public function getApproved(){
        $data = DB::table('order_models')
            ->select('order_models.id as id','order_models.employeeID as employeeID','order_models.ticketID as ticketID','order_models.roleName as roleName','order_models.approval as approval','groups.id as groupID','groups.name as groupName','order_models.created_at as created_at','order_models.updated_at as updated_at')
            ->join('groups','order_models.groupID','=','groups.id')
            ->where('order_models.approval',1)
            ->whereNull('order_models.deleted_at');
        return datatables($data)->toJson();
    }

    public function getPendingApproval(){

        $data = DB::table('order_models')
            ->select('order_models.id as id','order_models.employeeID as employeeID','order_models.ticketID as ticketID','order_models.roleName as roleName','order_models.approval as approval','groups.id as groupID','groups.name as groupName','order_models.created_at as created_at','order_models.updated_at as updated_at')
            ->join('groups','order_models.groupID','=','groups.id')
            ->where('order_models.approval',0)
            ->whereNull('order_models.deleted_at');
        return datatables($data)->toJson();
    }

    public function getNotApproved(){
        $data = DB::table('order_models')
            ->select('order_models.id as id','order_models.employeeID as employeeID','order_models.ticketID as ticketID','order_models.roleName as roleName','order_models.approval as approval','groups.id as groupID','groups.name as groupName','order_models.created_at as created_at','order_models.updated_at as updated_at')
            ->join('groups','order_models.groupID','=','groups.id')
            ->where('order_models.approval',2)
            ->whereNull('order_models.deleted_at');
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\orderModel  $orderModel
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $orderModel = orderModel::find($id);
        $group = group::find($orderModel->groupID);
        $employeeChecker = employee_data::where('employeeID','=',$orderModel->employeeID)->first();
        $employee = null;
        if($employeeChecker){
            $employee = $employeeChecker;
        }
        $orderModelCompetency = orderModelCompetency::where('modelID','=',$id)->get();
        $competency = competency::whereNull('deleted_at')->get();
        $competencyType = competencyType::whereNull('deleted_at')->get();
        $level = level::whereNull('deleted_at')->get();

        return view('admin.model.submission.pending')->with(compact('orderModel','group','orderModelCompetency','competency','competencyType','level','employee'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\orderModel  $orderModel
     * @return \Illuminate\Http\Response
     */
    public function edit(orderModel $orderModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\orderModel  $orderModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $orderModel = orderModel::find($id);

        if ($orderModel->approval == 1){
            return Redirect::back()->withErrors(['The model was already added to the assessment tool.']);
        }else if ($orderModel->approval == 2){
            return Redirect::back()->withErrors(['The model was already rejected.']);
        }

        $orderModel->remarks = 'Model Accepted';
        $orderModel->approval = 1;
        $orderModel->save();

        $role = new role;
        $role->name = $orderModel->roleName;
        $role->save();

        $orderModelCompetency = OrderModelCompetency::where('modelID','=',$orderModel->id)->get();

        
        $roleDetail = role::where('name','=',$orderModel->roleName)->first();
        
        foreach($orderModelCompetency as $row){
            $uploadedModel = new listOfCompetenciesPerRole;
            $uploadedModel->roleID = $roleDetail->id;
            $uploadedModel->groupID = $orderModel->groupID;
            $uploadedModel->competencyID = $row->competencyID;
            $uploadedModel->competencyTypeID = $row->competencyTypeID;
            $uploadedModel->targetLevelID = $row->targetProficiencyID;
            $uploadedModel->save();
        }


        return redirect('admin/model/submission')->with('success', 'Model successfully added.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\orderModel  $orderModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(orderModel $orderModel)
    {
        //
    }
    
    public function notAccept(Request $request, $id)
    {
        $orderModel = orderModel::find($id);

        if ($orderModel->approval == 1){
            return Redirect::back()->withErrors(['The model was already added to the assessment tool.']);
        }else if ($orderModel->approval == 2){
            return Redirect::back()->withErrors(['The model was already rejected.']);
        }

        $orderModel->remarks = $request->input('remarks');
        $orderModel->approval = 2;
        $orderModel->save();

        return redirect('admin/model/submission')->with('success', 'Model is not approved and returned to sender.');
    }
}
