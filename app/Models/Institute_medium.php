<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institute_medium extends Model
{
    use HasFactory;
    protected $table = 'institute_for';
    protected $fillable = [
        'name', 'status'
    ];
}
