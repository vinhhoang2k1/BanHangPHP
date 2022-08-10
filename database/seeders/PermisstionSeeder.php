<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermisstionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::findByName('Nhân viên');
        $permisstion = Permission::create(['name' => 'Quản lý khách hàng']);
        $role->givePermissionTo($permisstion);
    }
}
