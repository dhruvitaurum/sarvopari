<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institute_board extends Model
{
    use HasFactory;
    protected $table = 'institute_board';
    protected $fillable = [
        'name', 'status'
    ];
}
