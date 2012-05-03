# PEAR2\Service\HuffPo

Look up meta-data for an article on huffingtonpost.com.

## Setup

    pear channel-discover easybib.github.com/pear
    pear install easybib/Services_HuffPo-alpha

## Usage

    use PEAR2\Services\HuffPo;

    $huffPo = new HuffPo('http://www.huffingtonpost.com/2012/04/20/vegan-is-love-book_n_1441699.html');
    var_dump($huffPo->getMetaData());


