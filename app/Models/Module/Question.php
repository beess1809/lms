<?php

namespace App\Models\Module;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    public function answer()
    {
        return $this->hasMany(Answer::class, 'question_id', 'id');
    }

    public function correct()
    {
        return $this->hasOne(Answer::class, 'id', 'answer_id');
    }

    public function group()
    {
        return $this->hasOne(QuestionGroup::class, 'id', 'question_group_id');
    }
}
