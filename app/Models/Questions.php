<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
     protected $fillable = [
        'category_id',
        'question',
        'op_1',
        'op_2',
        'op_3',
        'op_4',
        'correct'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function questions()
{
    return $this->hasMany(Questions::class, 'category_id');
}
}
