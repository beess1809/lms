<?php

namespace App\Models\Auth;

use Laratrust\Models\LaratrustPermission;

class Permission extends LaratrustPermission
{
    public $guarded = [];
    protected $connection = 'pecdb';
}
