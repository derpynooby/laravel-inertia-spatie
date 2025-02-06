<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // create admin user 
         $user = User::create([
            'name'      => 'Syahrizaldev',
            'email'     => 'izaldev@gmail.com',
            'password'  => bcrypt('password'),
        ]);

        // get all permissions
        $permissions = Permission::all();

        // get admin role
        $role = Role::find(1);

    }
}
