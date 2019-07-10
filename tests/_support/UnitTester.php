<?php

use Codeception\Scenario;

/**
 *
 */
class UnitTester extends AbstractTester
{
    use _generated\UnitTesterActions;

    public function __construct(Scenario $scenario)
    {
        parent::__construct($scenario);
    }
}
