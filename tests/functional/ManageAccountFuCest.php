<?php

use App\Models\User;

class ManageAccountFuCest extends AbstractCest
{

    public function iCanLoadThePageAsAdmin(FunctionalTester $I)
    {
        $I->amLoggedInAsSampleAdmin();
        $I->manageAccount->goToListPage();
        $I->manageAccount->seeListPage();
    }

    public function iCantLoadThePageAsNotAdmin(FunctionalTester $I)
    {
        $I->amLoggedInAsSampleModerator();
        $I->manageAccount->goToListPage();
        $I->login->seePage();
    }

    public function iCanCreate(FunctionalTester $I)
    {
        $I->amLoggedInAsSampleAdmin();
        $I->manageAccount->goToListPage();

        $I->manageAccount->clickCreateButton();
        $I->manageAccount->seeCreatePage();

        $hash = $I->generateHash();
        $data = [
            'name' => "_name_{$hash}",
            'email' => "{$hash}@gitest.uk",
            'status' => User::STATUS_INACTIVE,
            'roles' => [User::ROLE_USER],
        ];

        $I->manageAccount->submitUserForm($data);
        $I->seeSuccessStaticMessage('Created');

        $model = User::where('email', $data['email'])->first();
        $I->assertNotNull($model);
        $I->assertEquals($data['name'], $model->name);
        $I->assertEquals($data['email'], $model->email);
        $I->assertEquals($data['status'], $model->status);
        $I->assertTrue($model->hasRole($data['roles'][0]));
    }

    public function iCanEdit(FunctionalTester $I)
    {
        $I->amLoggedInAsSampleAdmin();

        $model = $I->db->user->create();

        $I->manageAccount->goToEditPage($model->id);
        $I->manageAccount->seeEditPage();

        $hash = $I->generateHash();
        $data = [
            'name' => "_name_{$hash}",
            'email' => "{$hash}@gitest.uk",
            'status' => User::STATUS_INACTIVE,
            'roles' => [User::ROLE_MODERATOR],
        ];

        $I->manageAccount->submitUserForm($data);
        $I->seeSuccessStaticMessage('Updated');

        $updatedModel = $model->fresh();
        $I->assertEquals($data['name'], $updatedModel->name);
        $I->assertEquals($data['email'], $updatedModel->email);
        $I->assertEquals($data['status'], $updatedModel->status);
        $I->assertTrue($model->hasRole($data['roles'][0]));
    }

}
