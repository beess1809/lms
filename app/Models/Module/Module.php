<?php

namespace App\Models\Module;

use App\Models\Master\Category;
use App\Models\Trainee\TraineeModule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Module extends Model
{
    use HasFactory, SoftDeletes;

    public function trainee()
    {
        return $this->hasMany(TraineeModule::class, 'module_id', 'id');
    }

    public function training()
    {
        return $this->hasMany(Training::class, 'module_id', 'id');
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function moduleEmployee()
    {
        return $this->hasOne(TraineeModule::class, 'module_id', 'id')->where('employee_uuid', Auth::user()->uuid);
    }
}
