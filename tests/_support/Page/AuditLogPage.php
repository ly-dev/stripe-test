<?php

namespace Page;

class AuditLogPage extends AbstractPage
{
    public function goToPage()
    {
        $this->tester->amOnPage('/audit-log');
    }

    public function seePage()
    {
        $this->tester->see('Audit Logs', 'h1');
    }
}
