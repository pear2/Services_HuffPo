<?php
$status = (include_once 'HTTP/Request2.php');
if (false === $status) {
    echo "You need `pear install HTTP_Request2`." . PHP_EOL;
    exit(1);
}

require_once dirname(__DIR__) . '/library/PEAR2/Services/HuffPo.php';
require_once dirname(__DIR__) . '/library/PEAR2/Services/HuffPo/Request.php';
