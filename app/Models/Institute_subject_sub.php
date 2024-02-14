<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institute_subject_sub extends Model
{
    use HasFactory;
    protected $table = 'institute_subject_sub';
    protected $fillable = [
        'user_id', 'institute_id', 'subject_id'
    ];
}
