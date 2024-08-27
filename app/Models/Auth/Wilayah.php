<?php

namespace App\Models\Auth;

use App\Models\Master\Branch;
use App\Models\Master\Customer;
use App\Models\Master\Vendor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    // use HasFactory;

    protected $table = 'wilayah';
    public $timestamps = false;
    protected $connection = 'pecdb';

    public function branch()
    {
        return $this->hasMany(Branch::class, 'wilayah_id', 'id');
    }

    public function user()
    {
        return $this->hasMany(User::class, 'wilayah_id', 'id');
    }

    public function vendor()
    {
        return $this->hasMany(Vendor::class, 'wilayah_id', 'id');
    }

    public function customer()
    {
        return $this->hasMany(Customer::class, 'wilayah_id', 'id');
    }
}
