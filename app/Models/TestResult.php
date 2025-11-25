<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    protected $fillable = [
        'test_id',
        'student_id',
        'score',
        'total_questions',
        'percentage',
        'submitted_at'
    ];

    public function answers() {
        return $this->hasMany(TestAnswer::class, 'result_id');
    }

    public function test() {
        return $this->belongsTo(Test::class);
    }
    public function student() {
    return $this->belongsTo(Students::class, 'student_id');
}

}
