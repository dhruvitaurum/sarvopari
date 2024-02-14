<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insutitute_detail extends Model
{
    use HasFactory;
    protected $table = 'institute_detail';
    protected $fillable = [
        'user_id', 'institute_name', 'address', 'contact_no', 'email'
    ];
}
