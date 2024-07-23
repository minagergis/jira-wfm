<?php

namespace App\Modules\Shifts\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ShiftsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->allPermission();
        $this->assignPermissionsToRole();
    }

    public function allPermission()
    {
        Permission::firstOrCreate(['name' => 'list-shifts']);
        Permission::firstOrCreate(['name' => 'create-shift']);
        Permission::firstOrCreate(['name' => 'edit-shift']);
        Permission::firstOrCreate(['name' => 'delete-shift']);
        Permission::firstOrCreate(['name' => 'schedule-shift-to-members']);
    }

    public function assignPermissionsToRole()
    {
        Role::where('name', 'admin')->first()->givePermissionTo([
            'list-shifts',
            'create-shift',
            'edit-shift',
            'delete-shift',
            'schedule-shift-to-members',
        ]);

        Role::where('name', 'moderator')->first()->givePermissionTo([
            'list-shifts',
            'create-shift',
            'edit-shift',
            'schedule-shift-to-members',
        ]);

        Role::where('name', 'team-leader')->first()->givePermissionTo([
            'list-shifts',
            'create-shift',
            'edit-shift',
            'delete-shift',
            'schedule-shift-to-members',
        ]);
    }
}
