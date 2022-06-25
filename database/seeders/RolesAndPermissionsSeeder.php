<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'list-team']);
        Permission::create(['name' => 'create-team']);
        Permission::create(['name' => 'edit-team']);
        Permission::create(['name' => 'delete-team']);

        Permission::create(['name' => 'assign-team-schedule']);
        Permission::create(['name' => 'view-team-schedule']);
        Permission::create(['name' => 'edit-team-schedule']);
        Permission::create(['name' => 'delete-team-schedule']);

        Permission::create(['name' => 'list-team-member']);
        Permission::create(['name' => 'create-team-member']);
        Permission::create(['name' => 'edit-team-member']);
        Permission::create(['name' => 'delete-team-member']);
        Permission::create(['name' => 'view-team-member-stats']);


        Permission::create(['name' => 'list-contact-type']);
        Permission::create(['name' => 'create-contact-type']);
        Permission::create(['name' => 'edit-contact-type']);
        Permission::create(['name' => 'delete-contact-type']);

        Permission::create(['name' => 'list-task']);
        Permission::create(['name' => 'create-task']);
        Permission::create(['name' => 'edit-task']);
        Permission::create(['name' => 'delete-task']);

        Permission::create(['name' => 'view-dashboard-stats']);
        Permission::create(['name' => 'manual-distribution']);

        // create roles and assign created permissions

        // this can be done as separate statements
        Role::create(['name' => 'team-leader'])
            ->givePermissionTo([
                'list-team-member',
                'create-team-member',
                'edit-team-member',
                'view-team-member-stats',
                'list-team',
                'assign-team-schedule',
                'view-team-schedule',
                'edit-team-schedule',
                'delete-team-schedule',
                'view-dashboard-stats',
                'list-task',
                'edit-task',
            ]);

        // or may be done by chaining
        Role::create(['name' => 'moderator'])
            ->givePermissionTo([
                'list-team',
                'create-team',
                'edit-team',
                'list-team-member',
                'create-team-member',
                'edit-team-member',
                'view-team-member-stats',
                'assign-team-schedule',
                'view-team-schedule',
                'edit-team-schedule',
                'delete-team-schedule',
                'view-dashboard-stats',
                'list-task',
                'create-task',
                'edit-task',
                'list-contact-type',
                'create-contact-type',
                'edit-contact-type',
            ]);

        Role::create(['name' => 'admin'])->givePermissionTo(Permission::all());
    }
}
