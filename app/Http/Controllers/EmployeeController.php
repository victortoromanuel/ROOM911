<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Admin_room_911;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EmployeesImport;
use League\Csv\Reader;

class EmployeeController extends Controller
{
    //GET Add new employee view
    public function index($id_admin_room_911){
        $admin = Admin_room_911::find($id_admin_room_911);
        if (isset($_COOKIE[$admin->username])){
            $departments = Department::all();
            return view('employee.employee', ['departments' => $departments, 'id_admin_room_911' => $id_admin_room_911]);
        }
        else{
            return redirect('/');
        }
    }

    //POST Add a new employee request
    public function store(Request $request, $id_admin_room_911){

        $request->validate([
            'employeeid' => 'required|min:7',
            'firstname' => 'required|min:3',
            'lastname' => 'required|min:3'
        ]);

        $verify_employee = Employee::where('id_employee', $request->employeeid);
        if (is_null($verify_employee)){
            $employee = new Employee();
            $employee->id_number = (int) $request->employeeid;
            $employee->firstname = $request->firstname;
            $employee->lastname = $request->lastname;
            $employee->id_department = (int) $request->department;
            $employee->access = (int) $request->access;

            $employee->save();
            $message = "Employee was created succesfully";
            $alert = "success";
        }
        else {
            $message = "The employee is already registered";
            $alert = "danger";
        }
        return redirect()->route('employee', [$id_admin_room_911])->with('message', $message)->with("alert", $alert);
    }

    //GET update employees view
    public function show($id_admin_room_911, $id_employee){
        $admin = Admin_room_911::find($id_admin_room_911);
        if (isset($_COOKIE[$admin->username])){
            $departments = Department::all();
            $employee = Employee::find($id_employee);
            $id_department = Department::find($employee->id_department);
            return view('update.update', ['departments' => $departments, 'employee' => $employee, 'id_department' => $id_department, 'id_admin_room_911' => $id_admin_room_911]);
        }
        else{
            return redirect('/');
        }
    }

    //PATCH Update employees data request
    public function update(Request $request, $id_admin_room_911, $id_employee){

        $request->validate([
            'employeeid' => 'required|min:7',
            'firstname' => 'required|min:3',
            'lastname' => 'required|min:3'
        ]);
        
        $employee = Employee::find($id_employee);
        $employee->id_number = (int) $request->employeeid;
        $employee->firstname = $request->firstname;
        $employee->lastname = $request->lastname;
        $employee->id_department = (int) $request->department;
        $employee->access = (int) $request->access;

        $employee->save();
        $message = "Employees was updated succesfully";
        return redirect()->route('update', [$id_admin_room_911, $id_employee])->with('message', $message);
    }

    //GET Import employees by csv file view
    public function importView($id_admin_room_911){
        $admin = Admin_room_911::find($id_admin_room_911);
        if (isset($_COOKIE[$admin->username])){
            return view('import.import', ['id_admin_room_911' => $id_admin_room_911]);
        }
        else{
            return redirect('/');
        }
    }

    //POST Import employees by csv file request
    public function uploadEmployees(Request $request, $id_admin_room_911){
        if ($request->file->isValid()){
            $import = new EmployeesImport(); #Imports/EmployeesImport.php
            Excel::import($import, $request->file); 
            $message = "Employees imported successfully";
        }
        else {
            $message = "An error occured";
        }
        
        return redirect()->route('import', [$id_admin_room_911])->with("message", $message);
    }
}
