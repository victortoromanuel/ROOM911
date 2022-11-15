<?php

namespace App\Http\Controllers;

use App\Models\Access;
use App\Models\Admin_room_911;
use App\Models\Employee;
use App\Models\Department;
use Barryvdh\DomPDF\Facade\Pdf;
#use Barryvdh\DomPDF\PDF as DomPDFPDF;
use DateTime;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Gate;
use Svg\Tag\Rect;

#use PDF;

class MenuController extends Controller
{
    //
    public function index($key, $employees_filtered = null){
        $admin = Admin_room_911::find($key);
        #$gate = Gate::forUser($admin)->allows('admin-room-911', $admin);
        #echo $_COOKIE;
        #print_r($_COOKIE);
        #print_r(isset($_COOKIE[$admin->username]));
        #unset($_COOKIE);
        #setcookie($admin->username, 'menu', time() - 3600, '/');
        
        if (isset($_COOKIE[$admin->username])){
            $departments = Department::all();
            if ($employees_filtered == null){
                $employees = Employee::all();
            }
            else {
                $employees = $employees_filtered;
            }
            $id_admin_room_911 = $key;
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
                $info[6] = ($employees[$i]->access == 1) ? 'Accepted' : 'Denied';
                $info[7] = $i;
                $employees_array[$i] = $info;
            }
            
            return view('menu.menu', ['employees' => $employees, 
                                    'departments' => $departments, 
                                    'employees_array' => $employees_array,
                                    'admin_username' => $admin_username,
                                    'id_admin_room_911' => $id_admin_room_911]);
        }
        return redirect('/');
    }

    #This function apply the filter by search, department and date range
    public function filter(Request $request, $id_admin_room_911){ 
        $employees_filtered = Employee::all();
        $search_flag = is_null($request->employeeid);
        $department_flag = $request->department == "null";

        switch (true) {
            case (!$search_flag and $department_flag):
                $employees_filtered = Employee::where('firstname','like', '%' . $request->employeeid . '%')
                                                ->orWhere('lastname','like', '%' . $request->employeeid . '%')
                                                ->orWhere('id_number','=', $request->employeeid)->get();
                break;
            case ($search_flag and !$department_flag):
                $employees_filtered = Employee::where('id_department', $request->department)->get();
                break;
            case (!$search_flag and !$department_flag):
                $employees_filtered = Employee::where('id_department', $request->department)
                                                ->where('firstname','like', '%' . $request->employeeid . '%')
                                                ->orWhere('lastname','like', '%' . $request->employeeid . '%')
                                                ->orWhere('id_number','=', $request->employeeid)->get();
                break;
        }
        
        return $this->index($id_admin_room_911, $employees_filtered);
    }

    public function enable($id_employee, $id_admin_room_911){
        $employee = Employee::find($id_employee);
        $employee->access = 1;
        $employee->save();
        $message = "Access enable to " . $employee->firstname . " " . $employee->lastname;
        $alert = "success";
        return redirect()->route('menu', [$id_admin_room_911])->with("message", $message)->with("alert", $alert);
    }

    public function disable($id_employee, $id_admin_room_911){
        $employee = Employee::find($id_employee);
        $employee->access = 0;
        $employee->save();
        $message = "Access denied to " . $employee->firstname . " " . $employee->lastname;
        $alert = "warning";
        return redirect()->route('menu', [$id_admin_room_911])->with("message", $message)->with("alert", $alert);
    }

    public function delete($id_employee, $id_admin_room_911){
        $employee = Employee::find($id_employee);
        $employee->delete();
        $message = "Employee " . $employee->firstname . " " . $employee->lastname . "has been deleted";
        $alert = "warning";
        return redirect()->route('menu', [$id_admin_room_911])->with("message", $message)->with("alert", $alert);
    }

    public function historyView(Request $request, $id_admin_room_911, $id_employee){
        $admin = Admin_room_911::find($id_admin_room_911);
        if (isset($_COOKIE[$admin->username])){
            $employee = Employee::find($id_employee);
            $accesses = Access::where('id_employee', $id_employee)->get();

            $n_access = count($accesses->toArray());
            if($request->get("export")==1){
                $data = ['employee' => $employee, 'accesses' => $accesses, 'n_access' => $n_access];
                $pdf = Pdf::loadView('history.history', $data);
                ini_set('max_execution_time', '300'); //300 seconds = 5 minutes
                set_time_limit(300);
                return $pdf->download('accesses.pdf');
            }
            return view('history.history', ['employee' => $employee, 'accesses' => $accesses, 'n_access' => $n_access, 'id_admin_room_911' => $id_admin_room_911]);
        }
        else{
            return redirect('/');
        }
    }

    public $accesses_filtered = null;

    public function accessFilter(Request $request, $id_employee){
        $employee = Employee::find($id_employee);
        $accesses = Access::where('id_employee', $id_employee)->get();
        $date_flag = is_null($request->date1) and is_null($request->date2);
        $n_access = 0;
        if (!$date_flag){
            $accesses = Access::whereBetween('attempt_datetime', [$request->date1, $request->date2])->where('id_employee', $id_employee)->get();
            $n_access = count($accesses->toArray());
        }

        $this->accesses_filtered = $accesses;

        return view('history.history', ['employee' => $employee, 'accesses' => $accesses, 'n_access' => $n_access]);
        #return $this->historyView($request, $id_employee, $accesses_filtered);
    }
}
