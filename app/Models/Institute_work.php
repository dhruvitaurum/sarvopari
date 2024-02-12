<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institute_work extends Model
{
    use HasFactory;
    protected $table = 'institute_work';
    protected $fillable = [
        'name', 'status'
    ];
}
