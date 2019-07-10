<?php
use App\Models\User as UserModel;
use Codeception\Scenario;

class AcceptanceTester extends BaseDriverTester
{
    use _generated\AcceptanceTesterActions;

    /**
     * construction
     *
     * @param Scenario $scenario
     */
    public function __construct(Scenario $scenario)
    {
        parent::__construct($scenario);
    }

    /**
     * Login
     */
    public function amLoggedIn(UserModel $user)
    {
        $password = $this->db->user->getUserPassword($user);

        $this->login->submitLoginForm(
            $user->email,
            $password
        );

        // remember current active user
        $this->user = $user;
    }

    /**
     * Logout
     */
    public function amLoggedOut()
    {
        if ($this->hasLoggedIn()) {
            $this->click('a#user-account-dropdown');
            $this->click('a#logout-link');
        }
    }

    /**
     * Assert checkbox checked
     *
     * @param string $selector
     * @return boolean
     */
    public function assertChecked($selector)
    {
        $checked = $this->executeJS("return $('$selector').is(':checked')");
        $this->assertTrue($checked);
    }

    /**
     * Assert checkbox not checked
     *
     * @param string $selector
     * @return boolean
     */
    public function assertNotChecked($selector)
    {
        $checked = $this->executeJS("return $('$selector').is(':checked')");
        $this->assertFalse($checked);
    }

    /**
     * Select yes for confirm dialog
     */
    public function alertConfirmPreemptYes()
    {
        $this->executeJS('window.confirm = function(){return true;}');
    }

    /**
     * Select no for confirm dialog
     */
    public function alertConfirmPreemptNo()
    {
        $this->executeJS('window.confirm = function(){return false;}');
    }

    /**
     * Check alert static message
     *
     * @param string $text
     */
    public function dismissStaticMessage($status, $text = null)
    {
        $selector = ".alert.alert-{$status}";
        if (isset($text)) {
            $this->seeStaticMessage($text, $selector);
        }

        $this->click("{$selector} button.close");
    }

    /**
     * Check page success message and dismiss it
     *
     * @param string $text
     */
    public function dismissErrorStaticMessage($text = null)
    {
        $this->dismissStaticMessage('error', $text);
    }

    /**
     * Check page success message and dismiss it
     *
     * @param string $text
     */
    public function dismissWarningStaticMessage($text = null)
    {
        $this->dismissStaticMessage('warning', $text);
    }

    /**
     * Check page success message and dismiss it
     *
     * @param string $text
     */
    public function dismissSuccessStaticMessage($text = null)
    {
        $this->dismissStaticMessage('success', $text);
    }

}
