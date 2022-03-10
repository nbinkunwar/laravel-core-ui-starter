<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Role::truncate();
        Permission::truncate();
        $role = Role::create(['name'=>'admin','guard_name'=>'sanctum']);
        $permissions = config('constants.permission_routes');

        $routes = config('constants.role_routes');
        

        foreach($routes as $route)
        {
            foreach($permissions as $permission)
            {
                $permissionModel = Permission::where('name',$permission.' '.$route)->first();
                if(!$permissionModel)
                {
                    $permissionModel = Permission::create(['name'=>$permission.' '.$route,'guard_name'=>'sanctum']);
                }
                // $permission = Permission::findOrCreate($permission.' '.$route);
                $permissionModel->assignRole($role);
            }
        }

        $role = Role::create(['name'=>'customer','guard_name'=>'sanctum']);

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
