<?php

namespace App\Models\module;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingSub extends Model
{
    use HasFactory, SoftDeletes;

    public function question()
    {
        return $this->hasOne(Question::class, 'training_sub_id', 'id');
    }
}
