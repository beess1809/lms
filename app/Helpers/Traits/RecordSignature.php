<?php

namespace App\Helpers\Traits;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

trait RecordSignature
{
    use SoftDeletes;
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Auth::user()) {
                $model->created_by = Auth::user()->uuid;
            }
        });

        static::updating(function ($model) {
            if (Auth::user()) {
                $model->updated_by = Auth::user()->uuid;
            }
        });

        static::deleting(function ($model) {
            if (Auth::user()) {
                $model->deleted_by = Auth::user()->uuid;
            }
        });
    }
}
