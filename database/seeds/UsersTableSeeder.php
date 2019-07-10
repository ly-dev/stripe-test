<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createPermissionsAndRoles();
        $this->createUsers();
    }

    /**
     * Create permissions and roles
     */
    private function createPermissionsAndRoles()
    {
        $cachePermission = [];

        // create permission
        $permissionNames = [
            User::PERMISSION_USER,
            User::PERMISSION_MODERATOR,
            User::PERMISSION_ADMIN,
        ];
        foreach ($permissionNames as $permissionName) {
            $permission = Permission::where('name', $permissionName)->first();
            if (!$permission) {
                $permission = Permission::create([
                    'name' => $permissionName,
                ]);
            }

            $cachePermission[$permissionName] = $permission;
        }

        // create role
        $roleNames = [
            User::ROLE_USER => [
                User::PERMISSION_USER,
            ],
            User::ROLE_MODERATOR => [
                User::PERMISSION_USER,
                User::PERMISSION_MODERATOR,
            ],
            User::ROLE_ADMIN => [
                User::PERMISSION_USER,
                User::PERMISSION_MODERATOR,
                User::PERMISSION_ADMIN,
            ],
        ];

        foreach ($roleNames as $roleName => $permissions) {
            $role = Role::where('name', $roleName)->first();
            if (!$role) {
                $role = Role::create([
                    'name' => $roleName,
                ]);
            }

            foreach ($permissions as $permission) {
                if (!$role->hasPermissionTo($cachePermission[$permission])) {
                    $role->givePermissionTo($cachePermission[$permission]);
                }
            }
        }
    }

    /**
     * Create users
     */
    private function createUsers()
    {
        // create anonymous user, id = 0
        $user = User::where('id', 0)->first();
        if (!$user) {
            $user = User::create([
                'id' => 0,
                'name' => 'anonymous',
                'email' => 'anonymous@gitest.uk',
                'password' => bcrypt(str_random(64)),
                'status' => User::STATUS_INACTIVE,
            ]);
            $user->id = 0;
            $user->save();
        }

        // create default users
        $defaultUsers = [
            // client admin user
            [
                'email' => 'admin@gitest.uk',
                'name' => 'admin',
                'roles' => [
                    User::ROLE_ADMIN,
                ],
            ],
        ];

        foreach ($defaultUsers as $defaultUser) {
            $user = User::where('email', $defaultUser['email'])->first();
            if (!$user) {
                $user = User::create([
                    'name' => $defaultUser['name'],
                    'email' => $defaultUser['email'],
                    'password' => bcrypt(str_random(64)),
                    'status' => User::STATUS_ACTIVE,
                ]);
                foreach ($defaultUser['roles'] as $userRole) {
                    if (!$user->hasRole($userRole)) {
                        $user->assignRole($userRole);
                    }
                }
            }
        }
    }
}
