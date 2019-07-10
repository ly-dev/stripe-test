<?php
namespace Fixture;

abstract class AbstractFixture
{

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
