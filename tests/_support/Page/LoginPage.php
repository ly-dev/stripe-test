<?php
namespace Page;

/**
 * @property \Codeception\Actor $tester
 */
class LoginPage extends AbstractPage
{
    public function goToPage()
    {
        $this->tester->amOnPage('/login');
    }

    public function seePage()
    {
        $this->tester->see('Login', 'h1');
    }

    public function submitLoginForm($email, $password)
    {
        $this->goToPage();
        $this->seePage();
        $this->submitForm([
            'email' => $email,
            'password' => $password,
        ], 'form#login-form');
    }

    public function followResetPasswordLink()
    {
        $this->clickElement('a[href$="/password/reset"]');
    }

    public function seeResetPasswordPage()
    {
        $this->tester->see('Reset Password', 'h1');
    }

    public function followRegisterLink()
    {
        $this->clickElement('a[href$="/register"]');
    }

    public function seeRegisterPage()
    {
        $this->tester->see('Register', 'h1');
    }
}
