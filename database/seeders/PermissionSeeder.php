<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Gunakan guard_name = 'member' agar cocok dengan model Member
        $role_admin = Role::updateOrCreate(
            ['name' => 'admin', 'guard_name' => 'member'],
            ['name' => 'admin', 'guard_name' => 'member']
        );

        $role_member = Role::updateOrCreate(
            ['name' => 'member', 'guard_name' => 'member'],
            ['name' => 'member', 'guard_name' => 'member']
        );

        $role_guest = Role::updateOrCreate(
            ['name' => 'guest', 'guard_name' => 'member'],
            ['name' => 'guest', 'guard_name' => 'member']
        );

        // Permission dengan guard member juga
        $permission = Permission::updateOrCreate(
            ['name' => 'view_home', 'guard_name' => 'member'],
            ['name' => 'view_home', 'guard_name' => 'member']
        );

        $permission2 = Permission::updateOrCreate(
            ['name' => 'view_chart_on_home', 'guard_name' => 'member'],
            ['name' => 'view_chart_on_home', 'guard_name' => 'member']
        );

        $role_admin->givePermissionTo($permission);
        $role_admin->givePermissionTo($permission2);
        $role_member->givePermissionTo($permission2);

        // Ambil member id ke-6
       // $member = Member::find(6);

      // if ($member) {
         //   $member->assignRole('admin'); // guard member
      //  } else {
       //     echo "Member dengan ID 6 tidak ditemukan.\n";
        //}
    }
}
