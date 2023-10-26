<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sa = Role::create(['name' => 'Super-Admin']); //ID 1
        $clt = Role::create(['name' => 'Client']); //ID 2

        foreach (config('permissions') as $key => $resource) {
            if (in_array($key, ['users', 'products'])) {
                foreach ($resource as $permission) {
                    $sa->givePermissionTo($permission);
                }
            }

            if (in_array($key, ['roles'])) {
                foreach ($resource as $permission) {
                    if ($key == 'roles' && in_array($permission, ['view-any-Product', 'view-product'])) {
                        $clt->givePermissionTo($permission);
                    }
                }
            }
        }
    }
}
