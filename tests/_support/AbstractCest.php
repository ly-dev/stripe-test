<?php

abstract class AbstractCest
{
    public function _before($I)
    {
        // do something
    }

    public function _after($I)
    {
        // make sure logged out
        if ($I instanceof AcceptanceTester) {
            $I->amLoggedOut();
        }
    }
}
