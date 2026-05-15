<?php

namespace Database\Seeders;

use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employeeRole = Role::create(['name'=>RolesEnum::Employee]);
        $adminRole = Role::create(['name'=>RolesEnum::Admin]);

        $approveEmployees = Permission::create(['name' => PermissionsEnum::ApproveEmployees]);
        $addBlog = Permission::create(['name' => PermissionsEnum::AddBlog]);

        $employeeRole->syncPermissions([$addBlog]);
        $adminRole->syncPermissions([$approveEmployees]);
    }
}
