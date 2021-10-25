<?php

use Illuminate\Database\Seeder;
use App\Modules\User\User;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserConfigsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        $su = Role::create(['name' => 'super-admin']);
        $admin = User::create([
            'username' => 'admin',
            'name' => 'Coldiac Admin',
            'password' => bcrypt('secret')
        ]);
        $admin->assignRole($su);
        $admin->markEmailasVerified();
    }
}
