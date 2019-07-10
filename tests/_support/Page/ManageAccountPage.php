<?php
namespace Page;

/**
 * @property \Codeception\Actor $tester
 */
class ManageAccountPage extends AbstractPage
{
    public function goToListPage()
    {
        $this->tester->amOnPage('/manage-account');
    }

    public function seeListPage()
    {
        $this->tester->see('Users', 'h1');
    }

    public function goToCreatePage()
    {
        $this->tester->amOnPage('/manage-account/view');
    }

    public function seeCreatePage()
    {
        $this->tester->see('Create User', 'h1');
    }

    public function clickCreateButton()
    {
        $this->clickElement("a[href$=\"/manage-account/view\"]");
    }

    public function goToEditPage($id)
    {
        $this->tester->amOnPage('/manage-account/view/' . $id);
    }

    public function seeEditPage()
    {
        $this->tester->see('Edit User', 'h1');
    }

    public function clickEditButton($id)
    {
        $this->clickElement("a[href$=\"/manage-account/view/{$id}\"]");
    }

    public function submitUserForm($data = [])
    {
        if (!empty($data['roles'])) {
            $roles = $data['roles'];
            $data['roles'] = [];
            foreach ($roles as $role) {
                if (is_integer($role)) {
                    $data['roles'][] = $role;
                } else {
                    $data['roles'][] = $this->tester->db->user->getRoleIdByName($role);
                }
            }
        }

        $this->submitForm($data, 'form#user-form');
    }
}
