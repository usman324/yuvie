<?php

namespace Database\Seeders;

// use App\Models\Role;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class AdminUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);
        // $role=Role::where('name','Super Admin')->first();
        // $permissions = Permission::all();
        // $role->syncPermissions([]);
        // foreach ($permissions as $key => $p) {
        //     $permission = Permission::find($key);
        //     if ($permission) {
        //         $role->givePermissionTo($permission);
        //     }
        // }
        $user->assignRole(1);
    }
}
