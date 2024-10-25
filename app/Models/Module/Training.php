<?php

namespace App\Models\Module;

use App\Models\module\TrainingSub;
use App\Models\Trainee\TraineeTraining;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Training extends Model
{
    use HasFactory, SoftDeletes;

    public function sub()
    {
        return $this->hasMany(TrainingSub::class, 'training_id', 'id');
    }
    public function trainee()
    {
        return $this->hasOne(TraineeTraining::class, 'training_id', 'id');
    }
    public function traineeEmployee()
    {
        return $this->hasOne(TraineeTraining::class, 'training_id', 'id')->where('employee_uuid', Auth::user()->uuid);
    }
    public function module()
    {
        return $this->hasOne(Module::class, 'id', 'module_id');
    }
}
