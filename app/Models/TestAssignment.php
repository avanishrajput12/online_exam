<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestAssignment extends Model
{
      protected $table="test_assignments";
    protected $fillable = [
        'test_id',
        'student_id',
        'status'
    ];
}
