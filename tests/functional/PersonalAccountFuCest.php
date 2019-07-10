<?php

use App\Models\User;

class PersonalAccountFuCest extends AbstractCest
{
    public function iCanChangePassword(FunctionalTester $I)
    {
        $I->amRegisteredAndLoggedIn();

        $user = $I->user;
        $password = $I->db->user->getUserPassword($user);
        $newPassword = $I->generateHash();

        $I->personalAccount->goToChangePasswordPage();
        $I->personalAccount->seeChangePasswordPage();

        $data = [
            'old_password' => $password,
            'new_password' => $newPassword,
            'new_password_confirmation' => $newPassword,

        ];
        $I->personalAccount->submitChangePasswordForm($data);
        $I->seeSuccessStaticMessage('New password saved.');
    }
}
