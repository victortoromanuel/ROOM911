<?php

namespace App\Imports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeesImport implements ToModel, WithHeadingRow
{
    public $data;
    public function __construct()
    {
        $this->data = collect();
    }
    public function printEmployee(){
        echo var_dump($this->data);
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $model = Employee::firstOrCreate([
            "id_number" => $row['id_number'],
            "firstname" => $row['firstname'],
            "lastname" => $row['lastname'],
            "access" => $row['access'],
            "id_department" => $row['id_department']
        ]);
        $this->data->push($model);

        return $model;
    }
}
