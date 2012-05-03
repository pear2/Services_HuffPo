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
        $url    = 'http://www.huffingtonpost.com/2012/04/20/vegan-is-love-book_n_1441699.html';
        $huffPo = new HuffPo($url);
        $meta   = $huffPo->getMetaData();

        $this->assertEquals(1441699, $meta->entry_id);
        $this->assertSame($url, $meta->entry_url);
    }
}
