<?php
namespace pear2\Services\Test;

use pear2\Services\HuffPo;
use pear2\Services\HuffPo\Request;

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

    public function testMultiple()
    {
        $request = new Request(
            'http://www.huffingtonpost.com/api/?t=entry&entry_ids=1441699,1441698',
            array(1441699,1441698)
        );

        $response = $request->makeRequest();
        $object   = $request->parseResponse($response);

        $this->assertObjectHasAttribute("1441699", $object);
        $this->assertObjectHasAttribute("1441698", $object);
    }
}
