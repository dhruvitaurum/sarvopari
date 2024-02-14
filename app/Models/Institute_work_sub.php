<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institute_work_sub extends Model
{
    use HasFactory;
    protected $table = 'institute_work_sub';
    protected $fillable = [
        'user_id', 'institute_id', 'institute_work_id'
    ];
}
