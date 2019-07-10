<?php
namespace Fixture;

use App\Models\User as UserModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Spatie\Permission\Models\Role;

class UserFix extends AbstractFixture
{

    protected $passwords = [];

    /**
     * Get user model instance based on email
     *
     * @param string $email
     * @return \App\Models\User
     */
    public function getUserModel($email)
    {
        return UserModel::where('email', $email)->first();
    }

    /**
     * Get clear text password
     */
    public function getUserPassword(UserModel $user)
    {
        if (empty($this->passwords[$user->email])) {
            throw new \Exception("Never heard of user [{$user->email}]");
        }

        return isset($this->passwords[$user->email]) ? $this->passwords[$user->email] : $user->password;
    }

    /**
     * Remember clear text password
     */
    public function rememberUserPassword($email, $password)
    {
        $this->passwords[$email] = $password;
    }

    public function make($data = [])
    {
        $hash = $this->generateHash();

        $data = $data + [
            'name' => "_user_$hash",
            'email' => "{$hash}@gitest.uk",
            'password' => $hash,
            'status' => UserModel::STATUS_ACTIVE,
        ];

        $this->rememberUserPassword($data['email'], $data['password']);
        $data['password'] = bcrypt($data['password']);

        $model = new UserModel($data);
        $model->password = $data['password'];

        return $model;
    }

    public function create($data = [])
    {
        $user = $this->make($data);

        DB::transaction(function () use (&$user, &$data) {
            $user->save();

            // default role
            if (empty($data['role'])) {
                $data['role'] = UserModel::ROLE_USER;
            }

            $this->addRole($user, $data['role']);
        });

        return $user->fresh();
    }

    public function getPasswordResetToken($email)
    {
        $user = UserModel::where('email', $email)->first();
        $broker = Password::broker(null);
        return $broker->createToken($user);
    }

    private function addRole(UserModel $user, $role)
    {
        // convert role id to name
        if (is_numeric($role)) {
            $role = $this->getRoleNameById($role);
        }

        $user->assignRole($role);
    }

    public function getRoleNameById($roleId, $guardName = null)
    {
        $role = Role::findById($roleId, $guardName);
        return (empty($role) ? null : $role->name);
    }

    public function getRoleIdByName($roleName, $guardName = null)
    {
        $role = Role::findByName($roleName, $guardName);
        return (empty($role) ? null : $role->id);
    }
}
