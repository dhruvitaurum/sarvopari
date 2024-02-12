<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institute_for extends Model
{
    use HasFactory;
    protected $table = 'institute_for';
    protected $fillable = [
        'name', 'status', 'created_by', 'updated_by'
    ];
}
