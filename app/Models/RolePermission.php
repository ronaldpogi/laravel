<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class RolePermission extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'role_id', 
        'permission_id'
    ];
}
