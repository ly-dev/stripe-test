<?php
namespace Helper;

class Functional extends \Codeception\Module
{
    public function getLaravel5Module()
    {
        return $this->getModule('Laravel5');
    }

    public function getElementsOnPage($selector)
    {
        return  $this->getLaravel5Module()->_findElements($selector);
    }

    public function invokeRequest(
        $method,
        $uri,
        $parameters = [],
        $files = [],
        $server = [],
        $content = null
    ) {
        return $this->getLaravel5Module()->_request(
            $method,
            $uri,
            $parameters,
            $files,
            $server,
            $content
        );
    }
}
