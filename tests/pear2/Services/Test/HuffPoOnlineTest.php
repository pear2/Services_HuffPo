<?php
namespace pear2\Services\Test;

use pear2\Services\HuffPo;

class HuffPoOnlineTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Simple integration test case until we mock the rest.
     *
     * @return void
     */
    public function testOnline()
    {
        $huffPo = new HuffPo('http://www.huffingtonpost.com/2012/04/20/vegan-is-love-book_n_1441699.html');
        $meta   = $huffPo->getMetaData();
        var_dump($meta);
    }
}
