<?php

namespace App\Http\Controllers;
use App\Models\Department;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    //
    public function index(){
        $departments = Department::all();
        return view('update.update', ['departments' => $departments]);
    }
}
