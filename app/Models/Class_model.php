<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Class_model extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'class';
    protected $fillable = [
        'board_id', 'name', 'icon','status', 'created_by', 'updated_by'
    ];
    public function standards()
    {
        return $this->hasMany(Standard_model::class, 'class_id');
    }

    public function board()
    {
        return $this->belongsTo(board::class, 'board_id');
    }
}
