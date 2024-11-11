<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
    ];

    public function scopeFilter($query, array $filters)
    {
        $search = request('search') ?? false;

        $query->when(
            request('search')  ?? false,
            function ($query) use ($search) {
                $search = '%' . $search . '%';
                $query->whereAny([
                    'name',
                    'description'
                ], 'LIKE', $search);
            }
        );
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }
}
