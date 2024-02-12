<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subject_chapter extends Model
{
    use HasFactory;
    protected $table = 'subject_chapters';
    protected $fillable = [
        'subject_id', 'chapter_no', 'chapter_name'
    ];
}
