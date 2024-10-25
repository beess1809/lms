<?php

namespace App\Models\Trainee;

use App\Models\Auth\Employee;
use App\Models\Module\Training;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TraineeTraining extends Model
{
    use HasFactory, SoftDeletes;

    public function training()
    {
        return $this->hasOne(Training::class, 'id', 'training_id');
    }
    public function trainee()
    {
        return $this->hasOne(Employee::class, 'uuid', 'employee_uuid');
    }
}
