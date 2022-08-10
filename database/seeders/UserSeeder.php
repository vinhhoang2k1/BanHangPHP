<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // admin full permission
        $role = Role::create(['name' => 'Quản trị viên']);

        $admin = User::create([
            'name' => 'Hoàng Vinh',
            'email' => 'hoangvinh@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $admin->assignRole('Quản trị viên');

        // staff

        $staffRole = Role::create(['name' => 'Nhân viên']);

        $staffPermissions = [
            'Quản lý danh mục',
            'Quản lý sản phẩm',
            'Quản lý slider',
            'Quản lý đơn hàng',
            'Báo cáo'
        ];

        foreach ($staffPermissions as $staffPermission) {
            $permission = Permission::create(['name' => $staffPermission]);
            $staffRole->givePermissionTo($permission);
        }

//        \App\Models\User::factory(15)->create();

    }
}
