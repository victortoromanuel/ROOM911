<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    //
    public function index(){
        $departments = Department::all();
        return view('employee.employee', ['departments' => $departments]);
    }

    public function store(Request $request){

        $request->validate([
            'employeeid' => 'required|min:7',
            'firstname' => 'required|min:3',
            'lastname' => 'required|min:3'
        ]);

        $employee = new Employee();
        $employee->id_number = (int) $request->employeeid;
        $employee->firstname = $request->firstname;
        $employee->lastname = $request->lastname;
        $employee->id_department = (int) $request->department;
        $employee->access = (int) $request->access;

        $employee->save();
        
        return redirect()->route('employee')->with('success', 'Employee was created succesfully');
    }

    public function show($id_employee){
        $departments = Department::all();
        $employee = Employee::find($id_employee);
        $id_department = Department::find($employee->id_department);
    
        return view('update.update', ['departments' => $departments, 'employee' => $employee, 'id_department' => $id_department]);
    }

    public function update(Request $request, $id_employee){

        /*$request->validate([
            'employeeid' => 'required|min:7',
            'firstname' => 'required|min:3',
            'lastname' => 'required|min:3'
        ]);*/
        
        $employee = Employee::find($id_employee);
        $employee->id_number = (int) $request->employeeid;
        $employee->firstname = $request->firstname;
        $employee->lastname = $request->lastname;
        $employee->id_department = (int) $request->department;
        $employee->access = (int) $request->access;

        $employee->save();

        return redirect()->route('update', [$id_employee])->with('success', 'Employee was updated succesfully');
    }


}
