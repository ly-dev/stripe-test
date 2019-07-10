<?php
use App\Models\User as UserModel;
use Codeception\Scenario;

/**
 * @property \Page\DataTableComponent $dataTable
 * @property \Page\HomePage $home
 * @property \Page\LoginPage $login
 * @property \Page\AuditLogPage $auditLog
 * @property \Page\PersonalAccountPage $personalAccount
 * @property \Page\ManageAccountPage $manageAccount
 */
abstract class BaseDriverTester extends AbstractTester
{
    // default wait before timeout
    public $defaultWait = 10;

    // current active user
    public $user;

    /**
     * construction
     *
     * @param Scenario $scenario
     */
    public function __construct(Scenario $scenario)
    {
        parent::__construct($scenario);

        $this->dataTable = new \Page\DataTableComponent($this);
        $this->home = new \Page\HomePage($this);
        $this->login = new \Page\LoginPage($this);
        $this->auditLog = new \Page\AuditLogPage($this);
        $this->personalAccount = new \Page\PersonalAccountPage($this);
        $this->manageAccount = new \Page\ManageAccountPage($this);
    }

    /**
     * Has element on page
     *
     * @param string $selector
     * @return boolean
     */
    public function hasElementOnPage($selector)
    {
        $elements = $this->getElementsOnPage($selector);
        return (!empty($elements));
    }

    /**
     * Has logged out
     *
     * @return boolean
     */
    public function hasLoggedOut()
    {
        return $this->hasElementOnPage('a[href$="/login"]');
    }

    /**
     * Has logged in
     *
     * @return boolean
     */
    public function hasLoggedIn()
    {
        return $this->hasElementOnPage('a#logout-link');
    }

    /**
     * Login
     */
    abstract public function amLoggedIn(UserModel $user);

    /**
     * Logout
     */
    abstract public function amLoggedOut();

    /**
     * Login as sample admin
     */
    public function amLoggedInAsSampleAdmin()
    {
        $user = $this->db->getSampleUserAdmin();
        $this->amLoggedIn($user);
    }

    /**
     * Login as sample moderator
     */
    public function amLoggedInAsSampleModerator()
    {
        $user = $this->db->getSampleUserModerator();
        $this->amLoggedIn($user);
    }

    /**
     * Login as sample user
     */
    public function amLoggedInAsSampleUser()
    {
        $user = $this->db->getSampleUserCommon();
        $this->amLoggedIn($user);
    }

    /**
     * Create a new user and login
     *
     * @param array $data
     */
    public function amRegisteredAndLoggedIn($data = [])
    {
        $user = $this->db->user->create($data);
        $this->amLoggedIn($user);
    }

    /**
     * check page alert message
     */
    public function seeStaticMessage($text, $selector = '.alert')
    {
        $this->waitForText($text, $this->defaultWait, $selector);
    }

    /**
     * Check page error message
     *
     * @param string $text
     */
    public function seeErrorStaticMessage($text)
    {
        $this->seeStaticMessage($text, '.alert.alert-danger');
    }

    /**
     * Check page warning message
     *
     * @param string $text
     */
    public function seeWarningStaticMessage($text)
    {
        $this->seeStaticMessage($text, '.alert.alert-warning');
    }

    /**
     * Check page success message
     *
     * @param string $text
     */
    public function seeSuccessStaticMessage($text)
    {
        $this->seeStaticMessage($text, '.alert.alert-success');
    }

    /**
     * Check input invalid feedback message
     *
     * @param string $text
     * @param string $selector
     */
    public function seeInputInvalidFeedback($text, $fieldId)
    {
        $selector = ".form-group.is-invalid input[name=\"{$fieldId}\"]+.invalid-feedback";
        $this->waitForText($text, $this->defaultWait, $selector);
    }

    /**
     * Check common input
     *
     * @param mixed $value
     * @param string $fieldId
     */
    public function seeInputValue($value, $fieldId)
    {
        $selector = "input[name=\"{$fieldId}\"][value=\"{$value}\"]";
        $this->waitForElement($selector, $this->defaultWait);
    }

    /**
     * Check textarea input
     *
     * @param mixed $value
     * @param string $fieldId
     */
    public function seeInputTextarea($value, $fieldId)
    {
        $selector = "textarea[name=\"{$fieldId}\"]";
        $this->waitForText($value, $this->defaultWait, $selector);
    }

    /**
     * Check select option
     *
     * @param mixed $value
     * @param string $fieldId
     */
    public function seeInputOptionSelected($value, $fieldId)
    {
        $selector = "select[name=\"{$fieldId}\"] option[value=\"{$value}\"][selected]";
        $this->waitForElement($selector, $this->defaultWait);
    }

    /**
     * Check checkbox or radio
     *
     * @param mixed $value
     * @param string $fieldId
     */
    public function seeInputOptionChecked($value, $fieldId)
    {
        $selector = "input[name=\"{$fieldId}\"][value=\"{$value}\"][checked]";
        $this->waitForElement($selector, $this->defaultWait);
    }
}
