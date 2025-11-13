<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminsModel extends Model
{
    protected $table="admins";
    protected $fillable=[
     'name','email','password'
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
