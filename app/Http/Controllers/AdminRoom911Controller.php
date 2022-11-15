<?php

namespace App\Http\Controllers;

use App\Models\Admin_room_911;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class AdminRoom911Controller extends Controller
{
    //GET Add new admin view
    public function index($id_admin_room_911){
        $admin = Admin_room_911::find($id_admin_room_911);
        if (isset($_COOKIE[$admin->username])){
            $employees = Employee::all();
            return view('admin.admin', ['employees' => $employees, 'id_admin_room_911' => $id_admin_room_911]);
        }
        else{
            return redirect('/');
        }
    }

    //POST Add new admin request
    public function store(Request $request, $id_admin_room_911){

        $request->validate([
            'username' => 'required|min:4',
            'password' => 'required|min:4'
        ]);

        $verify_admin = Admin_room_911::where('id_employee', $request->employeeid);
        if (is_null($verify_admin)){
            $admin = new Admin_room_911();
            $admin->id_employee = (int) $request->employeeid;
            $admin->username = $request->username;
            $admin->password = $request->password;

            $admin->save();
            $message = "Administrator of ROOM 911 was created succesfully";
            $alert = "success";
        }
        else{
            $message = "The employee is already an administrator";
            $alert = "danger";
        }
        
        return redirect()->route('admin', [$id_admin_room_911])->with('message', $message)->with("alert", $alert);
    }

    //POST Log in system request
    public function login(Request $request){
        $request->validate([
            'username' => 'required|min:3',
            'password' => 'required|min:3'
        ]);

        $message = "";
        $admin = Admin_room_911::where('username', $request->username)->where('password', $request->password)->first();
        if ($admin != null){
            setcookie($admin->username, "menu", time() + 300,'/'); #Set session for 5 minutes
            return redirect()->route("menu", [$admin->id_admin_room_911]);
        }
        else {
            $message = "Username or password incorrect";
            return redirect()->route("login")->with("message", $message);
        }
    }
}
