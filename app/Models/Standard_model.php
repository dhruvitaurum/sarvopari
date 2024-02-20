<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Standard_model extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'standard';
    protected $fillable = [
        'class_id', 'name', 'status', 'created_by', 'updated_by'
    ];
}
