<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_employee';

    public function access(){
        return $this->hasMany(Employee::class, 'id_access', 'id_employee');
    }
}
