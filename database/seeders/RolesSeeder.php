<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['admin', 'customer'];
        foreach ($roles as $role) {
            Role::updateOrCreate(['name' => $role]);
        }

        // $user = User::create([
        //     'name' => 'admin',
        //     'email' => 'admin@admin.com',
        //     'password' => Hash::make('12345678'),
        // ]);
        // $user->assignRole('admin');
        //

        $user = User::create([
            'name' => 'customer',
            'email' => 'customer@admin.com',
            'password' => Hash::make('12345678'),
        ]);
        $user->assignRole('customer');
        //
        $user = User::create([
            'name' => 'customer2',
            'email' => 'customer2@admin.com',
            'password' => Hash::make('12345678'),
        ]);
        $user->assignRole('customer');
    }
}
