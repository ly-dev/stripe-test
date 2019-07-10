<?php
namespace Helper;

class Acceptance extends \Codeception\Module
{
    public function getWebDriverModule()
    {
        return $this->getModule('WebDriver');
    }

    public function getElementsOnPage($selector)
    {
        return  $this->getWebDriverModule()->_findElements($selector);
    }
}
