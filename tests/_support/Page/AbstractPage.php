<?php

namespace Page;

abstract class AbstractPage
{
    protected $tester;

    public function __construct(\Codeception\Actor $tester)
    {
        $this->tester = $tester;
    }

    public function submitForm($data, $selector, $selectorButton = null)
    {
        if (!isset($selectorButton)) {
            $selectorButton = "{$selector} button[type=\"submit\"]";
        }
        
        $this->tester->waitForElement($selector);
        $this->tester->waitForElement($selectorButton);

        $this->tester->submitForm(
            $selector,
            $data,
            $selectorButton
        );
    }

    public function clickElement($selector)
    {
        $this->tester->waitForElement($selector);
        $this->tester->click($selector);

    }
}
