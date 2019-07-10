<?php

use App\Modules\Auditlog\Models\Auditlog;

class AuditLogFuCest extends AbstractCest
{
   
    public function iCanLoadThePageAsAdmin(FunctionalTester $I)
    {
        $I->amLoggedInAsSampleAdmin();
        $I->auditLog->goToPage();
        $I->auditLog->seePage();
    }

    public function iCantLoadThePageAsNotAdmin(FunctionalTester $I)
    {
        $I->amLoggedInAsSampleModerator();
        $I->auditLog->goToPage();
        $I->login->seePage();
    }

    public function iCanSearch(FunctionalTester $I)
    {

        $I->amLoggedInAsSampleAdmin();

        $hash = $I->generateHash();
        Auditlog::info($hash);
        
        $req = $I->dataTable->getBaseRequest();

        // Basic
        $q = $req;
        $I->amOnPage("/audit-log/grid?" . http_build_query($q));
        $I->seeInSource('"draw":"1"');

        // Filter
        $q = $req;
        $q['search']['value'] = $hash;
        $I->amOnPage("/audit-log/grid?" . http_build_query($q));
        $I->seeInSource('"recordsTotal":1');
        $I->seeInSource('"category":"' . $hash);
    }

    public function iCanOrder(FunctionalTester $I)
    {
        $I->amLoggedInAsSampleAdmin();

        $hash = $I->generateHash();
        Auditlog::critical($hash, 'lorem');
        Auditlog::info($hash, 'ipsum');

        $req = $I->dataTable->getBaseRequest();

        // Order (by email) - ASC
        $q = $req;
        $q['search']['value'] = $hash;
        $q['order'][0]['column'] = 1;
        $q['order'][0]['dir'] = 'asc';
        $I->amOnPage("/audit-log/grid?" . http_build_query($q));
        $data = json_decode($I->grabPageSource());
        $I->assertEquals('lorem', $data->data[0]->activity);
        $I->assertEquals('ipsum', $data->data[1]->activity);

        // Order (by email) - DESC
        $q = $req;
        $q['search']['value'] = $hash;
        $q['order'][0]['column'] = 1;
        $q['order'][0]['dir'] = 'desc';
        $I->amOnPage("/audit-log/grid?" . http_build_query($q));
        $data = json_decode($I->grabPageSource());
        $I->assertEquals('ipsum', $data->data[0]->activity);
        $I->assertEquals('lorem', $data->data[1]->activity);
    }
}
