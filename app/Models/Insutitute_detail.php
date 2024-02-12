<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insutitute_detail extends Model
{
    use HasFactory;
    protected $table = 'institute_detail';
    protected $fillable = [
        'institute_for_id', 'institute_board_id', 'institute_for_class_id', 'institute_medium_id', 'institute_work_id', 'subject_id', 'institute_name', 'address', 'contact_no', 'email'
    ];
}
