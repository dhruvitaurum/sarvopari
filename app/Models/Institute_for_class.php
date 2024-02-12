<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institute_for_class extends Model
{
    use HasFactory;
    protected $table = 'institute_for_class';
    protected $fillable = [
        'name', 'status'
    ];
}
