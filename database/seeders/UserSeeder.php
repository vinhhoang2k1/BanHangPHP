<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(15)->create();
        $data = [
            'name' => 'Kiên Nguyễn',
            'email' => 'nguyenvankien1302@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'admin'
        ];

        User::create($data);
    }
}
