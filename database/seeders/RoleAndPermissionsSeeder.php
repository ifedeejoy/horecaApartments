<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' =>  'view reservations']);
        Permission::create(['name' =>  'manage reservations']);
        Permission::create(['name' =>  'create reservations']);
        Permission::create(['name' =>  'delete reservations']);
        Permission::create(['name' =>  'view inhouse-guests']);
        Permission::create(['name' =>  'manage inhouse-guests']);
        Permission::create(['name' =>  'create inhouse-guests']);
        Permission::create(['name' =>  'delete inhouse-guests']);
        Permission::create(['name' =>  'view users']);
        Permission::create(['name' =>  'manage users']);
        Permission::create(['name' =>  'create users']);
        Permission::create(['name' =>  'delete users']);
        Permission::create(['name' =>  'view expense']);
        Permission::create(['name' =>  'manage expense']);
        Permission::create(['name' =>  'create expense']);
        Permission::create(['name' =>  'delete expense']);
        Permission::create(['name' =>  'view revenue']);
        Permission::create(['name' =>  'manage revenue']);
        Permission::create(['name' =>  'create revenue']);
        Permission::create(['name' =>  'delete revenue']);
        Permission::create(['name' =>  'view rate']);
        Permission::create(['name' =>  'manage rate']);
        Permission::create(['name' =>  'create rate']);
        Permission::create(['name' =>  'delete rate']);
        Permission::create(['name' =>  'view maintenance']);
        Permission::create(['name' =>  'manage maintenance']);
        Permission::create(['name' =>  'create maintenance']);
        Permission::create(['name' =>  'delete maintenance']);
        Permission::create(['name' =>  'view payroll']);
        Permission::create(['name' =>  'manage payroll']);
        Permission::create(['name' =>  'create payroll']);
        Permission::create(['name' =>  'delete payroll']);
        Permission::create(['name' =>  'view accounting']);
        Permission::create(['name' =>  'manage accounting']);
        Permission::create(['name' =>  'create accounting']);
        Permission::create(['name' =>  'delete accounting']);
        Permission::create(['name' =>  'view blacklist']);
        Permission::create(['name' =>  'manage blacklist']);
        Permission::create(['name' =>  'create blacklist']);
        Permission::create(['name' =>  'delete blacklist']);
        Permission::create(['name' =>  'view reports']);
        Permission::create(['name' =>  'manage reports']);
        Permission::create(['name' =>  'create reports']);
        Permission::create(['name' =>  'delete reports']);

        // create roles and assign created permissions
        $role = Role::create(['name' => 'agents'])->givePermissionTo(['view reservations', 'view inhouse-guests']);
        $role = Role::create(['name' => 'accountant'])->givePermissionTo(['view payroll', 'manage payroll', 'create payroll', 'delete payroll', 'view accounting', 'manage accounting', 'create accounting', 'delete accounting', 'view reports', 'create expense', 'view expense', 'manage expense', 'delete expense']);
        $role = Role::create(['name' => 'owner'])->givePermissionTo(['view reservations', 'view inhouse-guests', 'view expense', 'view revenue', 'view reports']);
        $role = Role::create(['name' => 'property manager'])->givePermissionTo(['view reservations', 'manage reservations', 'create reservations', 'delete reservations', 'view inhouse-guests', 'manage inhouse-guests', 'create inhouse-guests', 'delete inhouse-guests', 'view maintenance',  'manage maintenance',  'create maintenance',  'delete maintenance',  'view blacklist',  'create blacklist',  'view users',  'create users', 'view reports', 'create expense', 'view expense', 'create revenue', 'view revenue', 'manage revenue', 'delete revenue']);
        $role = Role::create(['name' => 'staff'])->givePermissionTo(['view reservations', 'manage reservations', 'create reservations', 'view inhouse-guests', 'manage inhouse-guests', 'create inhouse-guests', 'create expense', 'view expense', 'create revenue', 'view revenue', 'view reports']);

        // SuperAdmin Role
        $role = Role::create(['name' => 'super-admin'])->givePermissionTo(Permission::all());
    }
}
