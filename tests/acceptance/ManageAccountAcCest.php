<?php

use App\Models\User;

class ManageAccountAcCest extends AbstractCest
{

    public function iCanViewListAsAdmin(AcceptanceTester $I)
    {
        $model = $I->db->getSampleUserModerator();

        $I->amLoggedInAsSampleAdmin();

        $I->manageAccount->goToListPage();
        $I->dataTable->searchFor($model->email);

        $I->dataTable->seeFirstItemInList($model->name);
        $I->dataTable->seeFirstItemInListInColumnNumber($model->email, 2);
    }

    public function iCanDelete(AcceptanceTester $I)
    {
        $I->amLoggedInAsSampleAdmin();

        $model = $I->db->user->create();

        $I->manageAccount->goToListPage();
        $I->dataTable->searchFor($model->email);
        $I->dataTable->seeFirstItemInListInColumnNumber($model->email, 2);

        $I->dataTable->clickDelete($model->id);
        $I->dismissSuccessStaticMessage('Deleted');

        $I->dataTable->searchForUnique($model->email);
        $I->dataTable->seeEmptyTable();
    }
}
