<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institute_subject extends Model
{
    use HasFactory;
    protected $table = 'institute_subject';
    protected $fillable = [
        'name', 'status'
    ];
}
