<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuRole extends Model
{
    // use HasFactory;

    protected $table = 'menu_role';
    public $timestamps = false;
    protected $connection = 'pecdb';
}
