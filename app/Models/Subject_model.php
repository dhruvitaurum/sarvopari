<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject_model extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'subject';
    protected $fillable = [
        'standard_id', 'stream_id', 'name', 'status', 'created_by', 'updated_by',
    ];
    public function stream()
    {
        return $this->belongsTo(Stream_model::class, 'stream_id');
    }
}
