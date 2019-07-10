<?php
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestSeeder extends Seeder
{
    static $testUserMetas = [
        [
            'email' => 'a01@gitest.uk',
            'name' => 'admin01',
            'password' => 'a01@gitest.uk',
            'status' => User::STATUS_ACTIVE,
            'roles' => [
                User::ROLE_ADMIN,
            ],
        ],
        [
            'email' => 'm01@gitest.uk',
            'name' => 'moderator01',
            'password' => 'm01@gitest.uk',
            'status' => User::STATUS_ACTIVE,
            'roles' => [
                User::ROLE_MODERATOR,
            ],
        ],
        [
            'email' => 'u01@gitest.uk',
            'name' => 'user01',
            'password' => 'u01@gitest.uk',
            'status' => User::STATUS_ACTIVE,
            'roles' => [
                User::ROLE_USER,
            ],
        ],
    ];

    static $testUsers = [];

    /**
     * see users
     */
    private function seedUsers($metas)
    {
        foreach ($metas as $meta) {
            $model = User::where('email', $meta['email'])->first();
            if (!$model) {
                $model = new User();
                $model->name = $meta['name'];
                $model->email = $meta['email'];
                $model->password = (isset($meta['password']) ? bcrypt($meta['password']) : bcrypt(str_random(64)));
                $model->status = $meta['status'];

                DB::transaction(function () use (&$model, $meta) {
                    $model->save();
                    foreach ($meta['roles'] as $role) {
                        if (!$model->hasRole($role)) {
                            $model->assignRole($role);
                        }
                    }
                });

                echo "created use {$meta['email']}.\n";
            }
            self::$testUsers[$meta['email']] = $model;
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (config('app.env') === 'local') {
            echo "seed test users\n";
            $this->seedUsers(self::$testUserMetas);
        } else {
            echo "The seeder only applies to local enviroment for development and testing purpose\n";
        }
    }
}
