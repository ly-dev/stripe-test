<?php

class HomeFuCest extends AbstractCest
{
    public function iCanGoHome(FunctionalTester $I)
    {
        $I->home->gotoPage();
        $I->home->seePage();
    }
}
