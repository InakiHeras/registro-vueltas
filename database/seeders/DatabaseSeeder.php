<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
        ]);

        User::create([
            'name' => 'Iñaki',
            'email' => 'inaki@email.com',
            'password' => Hash::make('1234'),
        ]);

        $roles = [
            'admin',
            'user'
        ];

        $home = Permission::create(['name' => 'HOME']);
        
        foreach ($roles as $roleName) {
            $role = Role::create(['name' => $roleName]);
            $role->givePermissionTo($home);
        }
        
        $user->assignRole('admin');
    }
}
