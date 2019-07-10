<?php
namespace Fixture;

/**
 * @property \Fixture\UserFix $user
 */
class Database
{

    public function __construct()
    {
        $this->user = new UserFix();
    }

    public function getSampleUserAdmin()
    {
        return ($this->getSampleUser(0));
    }

    public function getSampleUserModerator()
    {
        return ($this->getSampleUser(1));
    }

    public function getSampleUserCommon()
    {
        return ($this->getSampleUser(2));
    }

    private function getSampleUser($idx)
    {
        $user = (object) (\TestSeeder::$testUserMetas[$idx]);
        $this->user->rememberUserPassword($user->email, $user->password);

        return $this->user->getUserModel($user->email);
    }
}
