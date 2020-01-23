<?php

namespace App\Http\Controllers;

use App\User;
use App\right;
use App\employee_data;
use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Redirect;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::whereNull('deleted_at')->get();
        return view("admin.user.view-all")->with(compact('users'));
    }

    public function getAll()
    {
        
        $data = User::whereNull('deleted_at');
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
        $employee = employee_data::all();
        $right = right::all();
       
        return view('admin.user.register')->with(compact('employee','right'));
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
        if($request->input('email') == '' && $request->input('employeesDropdown') == '')
        {
            return Redirect::back()->withErrors(['Invalid Inputs.']);
        }

 
        if($request->input('password') != $request->input('password_confirmation')){
            return Redirect::back()->withErrors(['Password does not match.']);
        }

        
        
        //for adding a user
        if($request->input('rightsDropdown')=='1')
        {
            $employee = DB::table('employee_datas')->where('employeeID', $request->input('employeesDropdown'))->first();
            $user = User::create([
                'email' => $employee->email,
                'rightID' => $request->input('rightsDropdown'),
                'employeeID' => $employee->id,
                'password' => Hash::make($request->input('password')),
                'profileImage' => 'no-image.png',
            ]);
        }
        //for adding an admin
        if($request->input('rightsDropdown')=='2'){

            // if(User::where('email','=',$data['email'])!=null){
                
            // }

            $user = User::create([
                'email' => $request->input('email'),
                'rightID' => $request->input('rightsDropdown'),
                'employeeID' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'profileImage' => 'no-image.png',
            ]);
        }
          //for adding an admin
          if($request->input('rightsDropdown')=='3'){
            $user = User::create([
                'email' => $request->input('email'),
                'rightID' => $request->input('rightsDropdown'),
                'employeeID' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'profileImage' => 'no-image.png',
            ]);
        }

        return redirect('admin/user')->with('success', 'User successfully registered.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $user = User::find($id);
        $user->delete();
        return redirect('admin/user')->with('success', 'User successfully deleted.');
    }
}
