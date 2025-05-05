<?php

namespace Database\Seeders;

use App\Models\User;
use App\PermissionsEnum;
use App\RolesEnum;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $userRole = Role::create(['name' => RolesEnum::User->value]);
        $adminRole = Role::create(['name' => RolesEnum::Admin->value]);
        $commentorRole = Role::create(['name' => RolesEnum::Commenter->value]);

        $manageFeaturesPermission = Permission::create(['name' => PermissionsEnum::ManageFeatures->value]);
        $manageUsersPermission = Permission::create(['name' => PermissionsEnum::ManageUsers->value]);
        $manageCommentsPermission = Permission::create(['name' => PermissionsEnum::ManageComments->value]);
        $upvoteDownvotePermission = Permission::create(['name' => PermissionsEnum::UpvoteDownvote->value]);

        $userRole->syncPermissions([
            $upvoteDownvotePermission,
        ]);

        $commentorRole->syncPermissions([
            $manageCommentsPermission,
            $upvoteDownvotePermission,
        ]);

        $adminRole->syncPermissions([
            $manageFeaturesPermission,
            $manageUsersPermission,
            $manageCommentsPermission,
            $upvoteDownvotePermission,
        ]);

        User::factory()->create([
            'name' => 'User User',
            'email' => 'user@example.com',
        ])->assignRole(RolesEnum::User);

        User::factory()->create([
            'name' => 'Commenter Commenter',
            'email' => 'comennter@example.com',
        ])->assignRole(RolesEnum::Commenter);

        User::factory()->create([
            'name' => 'Admin Admin',
            'email' => 'admin@example.com',
        ])->assignRole(RolesEnum::Admin);
    }
}
