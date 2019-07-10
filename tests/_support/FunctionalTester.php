<?php
use App\Models\User as UserModel;
use Codeception\Scenario;

class FunctionalTester extends BaseDriverTester
{
    use _generated\FunctionalTesterActions;

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
     * Mock waitForElement function
     */
    public function waitForElement($selector, $timeout = null)
    {
        $elements = $this->getElementsOnPage($selector);
        $this->assertTrue(($elements->count() > 0), "Element {$selector} not found.");
    }

    /**
     * Mock waitForText function
     */
    public function waitForText($text, $timeout = null, $selector = null)
    {
        $this->see($text, $selector);
    }
    
    /**
     * Login
     */
    public function amLoggedIn(UserModel $user)
    {
        $this->amLoggedAs($user);
        $this->seeAuthentication();
        
        // remember current active user
        $this->user = $user;
    }

    /**
     * Logout
     */
    public function amLoggedOut()
    {
        $this->home->goToPage();
        if ($this->hasLoggedIn()) {
            $this->invokeRequest('POST', '/logout');
        }
    }
}
