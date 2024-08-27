<?php

namespace App\Models\Trainee;

use App\Models\Auth\Employee;
use App\Models\Module\Module;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TraineeModule extends Model
{
    use HasFactory;
    public function module()
    {
        return $this->hasOne(Module::class, 'id', 'module_id');
    }
    public function trainee()
    {
        return $this->hasOne(Employee::class, 'uuid', 'employee_uuid');
    }
}
