<?php

namespace App\Repositories;

use App\Interfaces\RbacRepositoryInterface;
use App\Models\Role;
use App\Models\RolePermission;

class RbacRepository implements RbacRepositoryInterface
{
    public function index() : mixed {
        return Role::all();
    }

    public function getById($id) : mixed{
       return Role::findOrFail($id);
    }

    public function store(array $data) : mixed {
      return Role::create($data);

    }

    public function update(array $data, $id) : mixed{
       return Role::whereId($id)->update($data);
    }
    
    public function delete($id) : mixed{
       return Role::destroy($id);
    }

    public function update_role_permission(array $attributes) : mixed
    {
        $role = Role::find($attributes['role_id']);

        if ($role) {

            if (isset($attributes['permission_id'])) {

            $permission = RolePermission::where('role_id', $attributes['role_id'])->where('permission_id', $attributes['permission_id'])->first();

                if ($permission) {
                    $role->permissions()->detach($permission->permission_id);
                    return "inactive";
                }
            } 

            $permission = RolePermission::create([
                'permission_id' => $attributes['permission_id'],
                'role_id' => $attributes['role_id']
            ]);
            
            return "active";
        }
    }
}
