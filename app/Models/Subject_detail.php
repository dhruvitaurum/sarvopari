<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject_detail extends Model
{
    use HasFactory;
    protected $table = 'subject_details';
    protected $fillable = [
        'subject_chapter_id', 'topic_no', 'topic_name', 'topic_video'
    ];
}
