<?php

use App\Models\User;

class LoginFuCest extends AbstractCest
{
    public function iCanLogIn(FunctionalTester $I)
    {
        $I->amLoggedInAsSampleAdmin();
    }

    public function iCantSeeLoginFormWhenLoggedIn(FunctionalTester $I)
    {
        $I->amLoggedInAsSampleAdmin();
        $I->login->goToPage();

        // see home page
        $I->home->seePage();
    }

    public function iCanLogOut(FunctionalTester $I)
    {
        $I->amLoggedInAsSampleAdmin();
        $I->amLoggedOut();

        // see login page
        $I->login->goToPage();
        $I->assertTrue($I->hasLoggedOut());
    }

    public function iCanRequestResetPasswordEmail(FunctionalTester $I)
    {
        $user = $I->db->user->create();

        $I->login->goToPage();
        $I->login->followResetPasswordLink();
        $I->login->seeResetPasswordPage();

        $data = [
            'email' => $user->email,
        ];
        $I->login->submitForm($data, 'form[action$="/password/email"]');
        $I->seeSuccessStaticMessage('We have e-mailed your password reset link!');
    }

    public function iCanRegister(FunctionalTester $I)
    {
        $I->login->goToPage();
        $I->login->followRegisterLink();
        $I->login->seeRegisterPage();

        $hash = $I->generateHash();

        $data = [
            'name' => "_user_$hash",
            'email' => "{$hash}@gitest.uk",
            'password' => $hash,
            'password_confirmation' => $hash,
        ];
        $I->login->submitForm($data, 'form[action$="/register"]');
        $I->seeAuthentication();
    }

}
