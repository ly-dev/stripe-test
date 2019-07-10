<?php 

use App\Models\User;

class LoginAcCest extends AbstractCest
{
    public function iCanLogIn(AcceptanceTester $I)
    {
        $I->amLoggedInAsSampleAdmin();

        $I->assertTrue($I->hasLoggedIn());
    }

    public function iCantSeeLoginFormWhenLoggedIn(AcceptanceTester $I)
    {
        $I->amLoggedInAsSampleAdmin();
        $I->login->goToPage();

        // see home page
        $I->home->seePage();
    }

    public function iCanLogOut(AcceptanceTester $I)
    {
        $I->amLoggedInAsSampleAdmin();
        $I->amLoggedOut();

        $I->assertTrue($I->hasLoggedOut());
    }
}
