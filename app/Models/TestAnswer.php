<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestAnswer extends Model
{
    protected $fillable = [
        'result_id',
        'question_id',
        'given_answer',
        'correct_answer',
        'is_correct'
    ];

    public function question() {
        return $this->belongsTo(Questions::class, 'question_id');
    }
    
}
