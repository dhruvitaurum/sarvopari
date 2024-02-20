<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class board extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'board';
    protected $fillable = [
        'institute_id', 'name', 'status', 'created_by', 'updated_by'
    ];
}
