<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class permissions extends Model
{
    use HasRoles, HasFactory;


     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table= 'permissions';
    protected $fillable = [
        'module_id', 'user_id', 'add', 'edit', 'delete', 'view'
    ];
}
