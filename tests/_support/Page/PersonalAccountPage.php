<?php
namespace Page;

/**
 * @property \Codeception\Actor $tester
 */
class PersonalAccountPage extends AbstractPage
{
    const PATH_CHANGE_PASSWORD = '/account/change-password';
    public function goToChangePasswordPage()
    {
        $this->tester->amOnPage(self::PATH_CHANGE_PASSWORD);
    }

    public function seeChangePasswordPage()
    {
        $this->tester->see('Change Password', 'h1');
    }

    public function submitChangePasswordForm($data = [])
    {
        $this->submitForm($data, 'form[action$="' . self::PATH_CHANGE_PASSWORD . '"]');
    }
}
