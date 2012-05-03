<?php
namespace pear2\Services\Test;

use pear2\Services\HuffPo;

class HuffPoTest extends \PHPUnit_Framework_TestCase
{
    public static function articleIdProvider()
    {
        return array(
            array('http://www.huffingtonpost.com/2012/04/20/vegan-is-love-book_n_1441699.html?ncid=edlinkusaolp00000003', 1441699),
            array('http://www.huffingtonpost.com/2012/05/03/daniel-chong-cell-four-days-survival-mode_n_1473753.html', 1473753),
            array('http://www.huffingtonpost.com/2012/05/02/cardinal-anthony-bevilacqua-punished-priest_n_1472169.html?ref=topbar', 1472169),
            array('http://www.huffingtonpost.com/2012/04/27/dentist-dropped-tool-down-throat-lena-david-wb-galbreath_n_1459745.html', 1459745),
            array('http://www.huffingtonpost.com/randy-fox/cleveland-ohio-and-its-accordion-king_b_1465943.html?ref=travel', 1465943),
        );
    }

    /**
     * @dataProvider articleIdProvider
     */
    public function testArticleId($url, $id)
    {
        $huffPo = new HuffPo($url);
        $this->assertSame($id, $huffPo->getArticleId());
    }
}
