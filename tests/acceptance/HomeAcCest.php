<?php

class HomeAcCest extends AbstractCest
{
    public function iCanGoHome(AcceptanceTester $I)
    {
        $I->home->gotoPage();
        $I->home->seePage();
    }
}
