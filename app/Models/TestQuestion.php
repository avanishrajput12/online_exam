<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestQuestion extends Model
{
    protected $table = "test_questions";

    protected $fillable = ['test_id', 'question_id'];

    public function question()
    {
        return $this->belongsTo(Questions::class, 'question_id');
    }
}
