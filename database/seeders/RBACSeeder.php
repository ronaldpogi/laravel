<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Route;
use App\Models\RolePermission;
use App\Models\PermissionGroup;
use Illuminate\Database\Seeder;

class RBACSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Role::truncate();

        $r = new Role();
        $r->name = 'Admin';
        $r->slug = 'Admin';
        $r->description = 'Admin';
        $r->save();

        $r = new Role();
        $r->name = 'User';
        $r->slug = 'User';
        $r->description = 'Users';
        $r->save();

        $routes = Route::getRoutes()->getRoutesByName();

        Permission::Truncate();
        PermissionGroup::Truncate();

        $roles = Role::all();

        $actions = [
            'logs' => 'Allow Logs',
            'restore' => 'Allow Restore',
            'export' => 'Allow Export',
            'index' => 'Allow List',
            'store' => 'Allow Create',
            'show' => 'Allow Show',
            'update' => 'Allow Edit',
            'destroy' => 'Allow Delete',
            'approve' => 'Allow Approve',
            'disable' => 'Allow Disable',
            'history' => 'Allow History Logs',
            'TransactionPreview' => 'Allow transaction preview',
            'TransactionSite' => 'Allow transaction per site',
            'TransactionEquipment' => 'Allow transaction per equipment',
            'closure' => 'Allow For Closure'
        ];

        foreach ($roles as $role) {
            foreach ($routes as $key => $route) {      
                $parts = str_replace('_',' ', $key);
                $parts = explode('.', $parts);

                $group_name = ucfirst($parts['0']) . " Management";
                $group_name =  $group_name == 'Statuses Management' ? 'Status Management': $group_name;
                
                $route_action = end($parts);
                $route_action = $actions[$route_action] ?? $route_action;

                if (count($parts) > 2) {
                    $group_name = "";
                    foreach ($parts as $index => $part) {
                        if ((count($parts) - 1) > (int) $index) {
                            if ($group_name) {
                                $group_name = $group_name . " " . ucfirst($part);
                            } else {
                                $group_name = ucfirst($part);
                            }
                        }
                    }
                    $group_name = $group_name . " Management";
                }

                $group = PermissionGroup::updateOrCreate([
                    'name' => str_replace('.', ' ', $group_name),
                    'description' => str_replace('.', ' ', $group_name),
                    'slug' => $group_name
                ]);

                if ($group_name !== 'Ignition Management' && $group_name !== 'Sanctum Management') {
                    $permission = Permission::updateOrCreate([
                        'name' => $group_name,
                        'description' => $route_action,
                        'route' => $key,
                        'permission_group_id' => $group->id,
                        'slug' => $group_name
                    ]);
                }
            }
        }

        RolePermission::truncate();

        $roles = Role::all();

        foreach ($roles as $role) {
            $permissions = Permission::all();
            foreach ($permissions as $permission) {
                RolePermission::create([
                    'role_id' => $role->id,
                    'permission_id' => $permission->id
                ]);
            }
        }
    }
}
