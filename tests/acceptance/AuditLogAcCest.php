<?php

class AuditLogAcCest extends AbstractCest
{

    public function iCanViewAnAuditItem(AcceptanceTester $I)
    {
        // generated audit log
        $I->amLoggedInAsSampleModerator();

        // allow difference from login log
        sleep(1);
        $I->amLoggedOut();
        $email = $I->user->email;

        // check the audit log
        $I->amLoggedInAsSampleAdmin();

        $I->auditLog->goToPage();
        $I->dataTable->searchFor($email);

        $I->dataTable->seeFirstItemInListInColumnNumber('Logged out', 4);
        $I->dataTable->seeFirstItemInListInColumnNumber($email, 6);
    }

}
