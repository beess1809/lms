<?php

namespace App\Models\Auth;

use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
    public $guarded = [];
    protected $connection = 'pecdb';
}
