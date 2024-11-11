<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'route',
        'permission_group_id'
    ];

    public function permissionGroup(): BelongsTo
    {
        return $this->belongsTo(PermissionGroup::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }

    public function newQuery($excludeDeleted = true): Builder
    {
        return parent::newQuery($excludeDeleted)->whereNotIn('name', config('exclude'));
    }
}
