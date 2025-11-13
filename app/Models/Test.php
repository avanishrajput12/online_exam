<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $table = "tests";

    protected $fillable = [
        'title',
        'total_questions'
    ];

    // 1) Test → TestQuestion (Intermediate Table)
    public function testQuestions()
    {
        return $this->hasMany(TestQuestion::class, 'test_id');
    }

    // 2) Test → Questions (Actual Questions using belongsToMany)
    public function questions()
    {
        return $this->belongsToMany(Questions::class, 'test_questions', 'test_id', 'question_id');
    }
}
