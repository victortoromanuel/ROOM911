<?php

namespace App\Http\Controllers;

use App\Models\Access;
use App\Models\Admin_room_911;
use App\Models\Employee;
use App\Models\Department;
use DateTime;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    //
    public function index($key, $employees_filtered = null){
        $departments = Department::all();
        if ($employees_filtered == null){
            $employees = Employee::all();
        }
        else {
            $employees = $employees_filtered;
        }
        $id_admin_room_911 = $key;
        $admin = Admin_room_911::find($key);
        $admin_username = strtoupper($admin->username);
        $employees_array = [];
        for ($i = 0; $i < count($employees); $i++) { 
            $info = [];
            $get_department = Department::find($employees[$i]->id_department);
            $access = Access::where('id_employee', $employees[$i]->id_employee)->get()->toArray();
            $info[0] = $employees[$i]->id_employee;
            $info[1] = $employees[$i]->id_number;
            $info[2] = $employees[$i]->firstname;
            $info[3] = $employees[$i]->lastname;
            $info[4] = $get_department->department_name;
            $info[5] = count($access);
            $info[6] = $i;
            $employees_array[$i] = $info;
        }
        
        return view('menu.menu', ['employees' => $employees, 
                                  'departments' => $departments, 
                                  'employees_array' => $employees_array,
                                  'admin_username' => $admin_username,
                                  'id_admin_room_911' => $id_admin_room_911]);
    }

    #This function apply the filter by search, department and date range
    public function filter(Request $request, $id_admin_room_911){ 
        $employees_filtered = Employee::all();
        $search_flag = is_null($request->employeeid);
        $department_flag = $request->department == "null";
        $date_flag = is_null($request->date1) and is_null($request->date2);

        switch (true) {
            case (!$search_flag and $department_flag and $date_flag):
                $employees_filtered = Employee::where('firstname','like', '%' . $request->employeeid . '%')
                                                ->orWhere('lastname','like', '%' . $request->employeeid . '%')
                                                ->orWhere('id_number','=', $request->employeeid)->get();
                break;
            case ($search_flag and !$department_flag and $date_flag):
                $employees_filtered = Employee::where('id_department', $request->department)->get();
                break;
            case ($search_flag and $department_flag and !$date_flag):
                $access = Access::whereBetween('attempt_datetime', [$request->date1, $request->date2])->whereNotNull('id_employee')->get('id_employee')->toArray();
                $ids_employees = array_values($access);
                $employees_filtered = Employee::whereIn('id_employee', $ids_employees)->get();
                break;
            case (!$search_flag and !$department_flag and $date_flag):
                $employees_filtered = Employee::where('id_department', $request->department)
                                                ->where('firstname','like', '%' . $request->employeeid . '%')
                                                ->orWhere('lastname','like', '%' . $request->employeeid . '%')
                                                ->orWhere('id_number','=', $request->employeeid)->get();
                break;
            case ($search_flag and !$department_flag and !$date_flag):
                $access = Access::whereBetween('attempt_datetime', [$request->date1, $request->date2])->whereNotNull('id_employee')->get('id_employee')->toArray();
                $ids_employees = array_values($access);
                $employees_filtered = Employee::whereIn('id_employee', $ids_employees)
                                                ->where('id_department', $request->department)->get();
                break;
            case (!$search_flag and $department_flag and !$date_flag):
                $access = Access::whereBetween('attempt_datetime', [$request->date1, $request->date2])->whereNotNull('id_employee')->get('id_employee')->toArray();
                $ids_employees = array_values($access);
                $employees_filtered = Employee::whereIn('id_employee', $ids_employees)
                                                ->where('firstname','like', '%' . $request->employeeid . '%')
                                                ->orWhere('lastname','like', '%' . $request->employeeid . '%')
                                                ->orWhere('id_number','=', $request->employeeid)->get();
                break;
        }
        
        return $this->index($id_admin_room_911, $employees_filtered);
    }
}
