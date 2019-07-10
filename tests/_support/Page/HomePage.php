<?php

namespace Page;

class HomePage extends AbstractPage
{
    public function goToPage()
    {
        $this->tester->amOnPage('/');
    }

    public function seePage()
    {
        $this->tester->see('Welcome', 'h1');
    }
}
