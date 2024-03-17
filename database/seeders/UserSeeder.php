<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $buyerRole = Role::create(['name' => 'buyer']);

        // Define permissions
        $adminPermissions = [
            'create-events',
            'edit-events',
            'delete-events',
            'view-events',
        ];

        $buyerPermissions = [
            'view-events',
        ];

        // Assign permissions to roles
        foreach ($adminPermissions as $permissionName) {
            $permission = Permission::firstOrCreate(['name' => $permissionName]);
            if (!$adminRole->hasPermissionTo($permission)) {
                $adminRole->givePermissionTo($permission);
            }
        }

        foreach ($buyerPermissions as $permissionName) {
            $permission = Permission::firstOrCreate(['name' => $permissionName]);
            if (!$buyerRole->hasPermissionTo($permission)) {
                $buyerRole->givePermissionTo($permission);
            }
        }

        // Create users and assign roles
        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'), // You can change the password as needed
        ]);
        $adminUser->syncRoles([$adminRole->id]);

        $buyerUser = User::create([
            'name' => 'Buyer User',
            'email' => 'buyer@example.com',
            'password' => bcrypt('password'), // You can change the password as needed
        ]);
        $buyerUser->syncRoles([$buyerRole->id]);
    }
}
