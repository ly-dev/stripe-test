<?php
use Codeception\Scenario;

/**
 * @property \Fixture\Database $db
 */
abstract class AbstractTester extends \Codeception\Actor
{

    /**
     * construction
     *
     * @param Scenario $scenario
     */
    public function __construct(Scenario $scenario)
    {
        parent::__construct($scenario);

        $this->db = new \Fixture\Database();
    }

    /**
     * Gerenate hash
     *
     * @return string
     */
    public function generateHash()
    {
        return substr(md5(microtime() . mt_rand()), 0, 8);
    }
}