<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institute_medium_sub extends Model
{
    use HasFactory;
    protected $table = 'institute_medium_sub';
    protected $fillable = [
        'user_id', 'institute_id', 'institute_medium_id',
    ];
}
