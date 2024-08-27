<?php

namespace App\Models\Auth;

use App\Helpers\Traits\BaseModel;
use App\Helpers\Traits\UsesUuid;
use App\Models\Asset\AssetEmployee;
use App\Models\Master\Company;
use App\Models\Master\Department;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laratrust\Traits\LaratrustUserTrait;

class Employee extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable, UsesUuid;
    protected $connection = 'pecdb';

    protected $guard = 'employee';
    protected $table = 'employees';
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'empl_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function organization()
    {
        return $this->hasOne(Department::class, 'code', 'department_code');
    }

    public function company()
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

    public function assets()
    {
        return $this->hasMany(AssetEmployee::class, 'employee_uuid', 'uuid');
    }

    public function roleEmployee()
    {
        return $this->hasOne(RoleEmployee::class, 'employee_uuid', 'uuid');
    }

    public function rolesEmployee()
    {
        return $this->hasMany(RoleEmployee::class, 'employee_uuid', 'uuid');
    }

    public function parent()
    {
        return $this->belongsTo($this, 'parent_uuid');
    }
    // public static function roleChilds($parent_id)
    // {
    //     $retval = [];
    //     if ($parent_id != null) {
    //         $retval[] = Role::find($parent_id)->id;
    //         $roles = Role::where('parent_id', '=', $parent_id)->get();
    //         if ($roles) {
    //             foreach ($roles as $role) {
    //                 $childs = Employee::roleChilds($role->id);
    //                 if (count($childs) > 0) {
    //                     array_push($retval, ...$childs);
    //                 }
    //             }
    //         }
    //     }
    //     return $retval;
    // }
}
