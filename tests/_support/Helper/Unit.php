<?php
namespace Helper;

class Unit extends \Codeception\Module
{
    public function getLaravel5Module()
    {
        return $this->getModule('Laravel5');
    }
}
