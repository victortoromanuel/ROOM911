<?php

namespace App\Http\Controllers;

use App\Models\Admin_room_911;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class AdminRoom911Controller extends Controller
{
    //
    public function index(){
        $employees = Employee::all();
        return view('admin.admin', ['employees' => $employees]);
    }

    public function store(Request $request){

        $request->validate([
            'username' => 'required|min:4',
            'password' => 'required|min:4'
        ]);

        $admin = new Admin_room_911();
        $admin->id_employee = (int) $request->employeeid;
        $admin->username = $request->username;
        $admin->password = $request->password;

        $admin->save();
        $message = "Administrator of ROOM 911 was created succesfully";
        return redirect()->route('admin')->with('message', $message);
    }

    public function login(Request $request){
        $request->validate([
            'username' => 'required|min:3',
            'password' => 'required|min:3'
        ]);

        $message = "";
        $admin = Admin_room_911::where('username', $request->username)->where('password', $request->username)->first();
        if ($admin != null){
            return redirect()->route("menu", [$admin->id_admin_room_911]);
        }
        else {
            $message = "Username or password incorrect";
            return redirect()->route("login")->with("message", $message);
        }
    }
}
