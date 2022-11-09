<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EmployeesImport;
use League\Csv\Reader;

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
        $message = "Employee was created succesfully";
        
        return redirect()->route('employee')->with('message', $message);
    }

    #View update
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
        $message = "Employee was updated succesfully";
        return redirect()->route('update', [$id_employee])->with('message', $message);
    }

    public function importView(){
        return view('import.import');
    }

    public function uploadEmployees(Request $request){
        if ($request->file->isValid()){
            $import = new EmployeesImport();
            Excel::import($import, $request->file);
        }
        $message = "Employees imported successfully";
        return redirect()->route('import')->with("message", $message);
    }
}
