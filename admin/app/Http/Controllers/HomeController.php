<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\orderModel;
use App\User;
use App\listOfCompetenciesPerRole;
use App\employee_data;
use App\gapAnalysisSetting;
use App\evaluationCompetency;
use App\group;
use App\competency;
use DB;
use \stdClass;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $employee = DB::table('assessments')
            ->select('employee_datas.employeeID as employeeID','employee_datas.firstname as firstname','employee_datas.lastname as lastname','roles.id as roleID','roles.name as role','assessment_types.id as assessmentTypeID','assessment_types.name as assessmentType','employee_datas.email as email','evaluations.id as evaluationID')
            ->join('employee_datas','assessments.employeeID','=','employee_datas.employeeID')
            ->join('assessment_types','assessments.assessmentTypeID','=','assessment_types.id')
            ->join('evaluations','assessments.evaluationVersionID','=','evaluations.id')
            ->join('evaluation_competencies','evaluations.id','=','evaluation_competencies.evaluationID')
            ->join('roles','evaluations.assesseeRoleID','=','roles.id')
            ->whereNull('assessments.deleted_at')
            ->orderBy('evaluation_competencies.updated_at','DESC')
            ->distinct()
            ->take(5)
            ->get();

        $latestFiveAssessee = array();
        foreach($employee as $employeeItem){
            $latestFiveRow = new StdClass;

            $model = listOfCompetenciesPerRole::whereNull('deleted_at')->where('roleID',$employeeItem->roleID)->get();
            $answeredCompetencies = 0;
            for($i=0;$i<count($model);$i++){
                $evaluationCompetency = evaluationCompetency::whereNull('deleted_at')
                    ->where('evaluationID',$employeeItem->evaluationID)
                    ->where('competencyID',$model[$i]->competencyID)
                    ->first();

                if($evaluationCompetency){
                    $answeredCompetencies++;
                }
            }


            $evaluationCompetency = evaluationCompetency::whereNull('deleted_at')
                ->where('evaluationID',$employeeItem->evaluationID)
                ->orderBy('updated_at','DESC')
                ->first();

            $latestFiveRow->employeeID = $employeeItem->employeeID;
            $latestFiveRow->firstname = $employeeItem->firstname;
            $latestFiveRow->lastname = $employeeItem->lastname;
            $latestFiveRow->role = $employeeItem->role;
            $latestFiveRow->assessmentTypeID = $employeeItem->assessmentTypeID;
            $latestFiveRow->assessmentType = $employeeItem->assessmentType;
            $latestFiveRow->email = $employeeItem->email;
            $latestFiveRow->updated_at = $evaluationCompetency->updated_at;
            $latestFiveRow->status = 0;
            $latestFiveRow->model = count($model);
            $latestFiveRow->count = 0;

            if($answeredCompetencies == count($model)){
                $latestFiveRow->status = 1;
                $latestFiveRow->count = $answeredCompetencies;
            }elseif ($answeredCompetencies < count($model) && $answeredCompetencies > 0) {
                $latestFiveRow->status = 2;
                $latestFiveRow->count = $answeredCompetencies;
            }
            
            array_push($latestFiveAssessee,$latestFiveRow);
        }
        // /return dd($latestFiveAssessee) ;

        $totalModels = orderModel::whereNull('deleted_at')->count();
        $pendingModels = orderModel::whereNull('deleted_at')->where('approval',0)->count();
        $approvedModels = orderModel::whereNull('deleted_at')->where('approval',1)->count();
        $rejectedModels = orderModel::whereNull('deleted_at')->where('approval',2)->count();
        
        if ($totalModels == null){
            $totalModels = '0';
        }

        if ($pendingModels == null){
            $pendingModels = '0';
        }
        if ($approvedModels == null){
            $approvedModels = '0';
        }
        if ($rejectedModels == null){
            $rejectedModels = '0';
        }


        $modelsAcross = listOfCompetenciesPerRole::whereNull('deleted_at')->select('roleID')->distinct()->get();
        $allEmployees = employee_data::whereNull('deleted_at')->get();

        $friday = date("Y-m-d", strtotime("previous friday"));
        $allEmployeesLastWeek = employee_data::whereNull('deleted_at')->whereDate('created_at', '>', $friday)->get();
        $allEmployeesThisWeek = employee_data::whereNull('deleted_at')->whereDate('created_at', '<', $friday)->get();


        //return count($allEmployeesLastWeek);

        $percentageEmployee = 0;
        if(count($allEmployeesLastWeek)== null){
            $percentageEmployee = 100;
        }elseif(count($allEmployeesThisWeek)== null){
            $percentageEmployee = 0;
        }else{
            $percentageEmployee = count($allEmployeesThisWeek)/count($allEmployeesLastWeek) * 100;
        }

        $gapAnalysisSetting = gapAnalysisSetting::whereNull('deleted_at')->where('is_active',1)->first();
        
        //$percentageEmployee = 
        // /return $percentageEmployee;

        //return $employee;

        /*$groupModelList = DB::table('list_of_competencies_per_roles')
            ->select('groups.name as groupName',DB::raw('count() as total'))
            ->join('groups','list_of_competencies_per_roles.groupID','=','groups.id')
            ->groupBy('groups.name')
            ->get();*/
        
        $modelListCount = DB::table('list_of_competencies_per_roles')
            ->select('roles.name as roleName',DB::raw('count(list_of_competencies_per_roles.competencyID) as total'))
            ->join('roles','list_of_competencies_per_roles.roleID','=','roles.id')
            ->groupBy('roles.name')
            ->orderBy('list_of_competencies_per_roles.updated_at','desc')
            ->get();


        $group = group::whereNull('deleted_at')->take(5)->get();
        $userLatest = User::whereNull('deleted_at')->take(5)->orderBy('updated_at','desc')->get();
        $competencyLatest = competency::whereNull('deleted_at')->take(5)->orderBy('updated_at','desc')->get();

        return view('home')->with(compact(
            'employee',
            'totalModels',
            'pendingModels',
            'approvedModels',
            'rejectedModels',
            'users',
            'modelsAcross',
            'allEmployees',
            'percentageEmployee',
            'gapAnalysisSetting',
            'latestFiveAssessee',
            'modelListCount',
            'group',
            'userLatest',
            'competencyLatest'
        ));
    }
}
