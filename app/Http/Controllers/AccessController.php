<?php

namespace App\Http\Controllers;

use App\Models\Access;
use App\Models\Employee;
use Illuminate\Http\Request;

class AccessController extends Controller
{
    //POST add new access request
    public function store(Request $request){

        $request->validate([
            'employeeid' => 'required|min:7',
        ]);

        $message = "";
        $access = new Access();
        $attempt_access = "";
        $attempt_datetime = date_create()->format('Y-m-d H:i:s');
        $employee = Employee::where('id_number', (int) $request->employeeid)->first();
        $access->attempt_datetime = $attempt_datetime;
        $access->id_number = (int) $request->employeeid;
        if ($employee != null){
            $access->is_registered = true;
            $access->id_employee = $employee->id_employee;
            if ($employee->access == 1){
                $attempt_access = "success";
                $access->attempt_access = "Accepted";
                $message = "Access accepted to employee " . $employee->firstname . " " . $employee->lastname;
            }
            elseif ($employee->access == 0) {
                $attempt_access = "danger";
                $access->attempt_access = "Denied";
                $message = "Access denied to employee " . $employee->firstname . " " . $employee->lastname;
            }
        }
        else {
            $access->id_employee = null;
            $access->attempt_access = "Denied";
            $access->is_registered = false;
            $attempt_access = "warning";
            $message = "Employee does not registered";
        }

        $access->save();

        return redirect()->route("access")->with("message", $message)->with("attempt_access", $attempt_access);
    }
}
