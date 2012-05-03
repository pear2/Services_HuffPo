<?php
/**
 * Copyright 2012, Till Klampaeckel
 *
 * PHP Version 5.3
 *
 * @category Services
 * @package  PEAR2\Services\HuffPo
 * @author   Till Klampaeckel <till@php.net>
 * @license  http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @version  Release: @package_version@
 * @link     https://github.com/pear2/Services_HuffPo
 */
namespace PEAR2\Services\HuffPo;

/**
 * PEAR2\Services\HuffPo
 *
 * @category Services
 * @package  PEAR2\Services\HuffPo
 * @author   Till Klampaeckel <till@php.net>
 * @license  http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @version  Release: @package_version@
 * @link     https://github.com/pear2/Services_HuffPo
 */
class Request
{
    /**
     * The API's version this wrapper supports!
     * @var string $apiVersion
     */
    protected $apiVersion = '1.0';

    /**
     * @var \HTTP_Request2
     */
    protected $client;

    /**
     * @var array
     */
    protected $id;

    /**
     * @var string
     */
    protected $url;

    /**
     * @param string         $url
     * @param mixed          $id
     * @param \HTTP_Request2 $client
     *
     * @return Request
     */
    public function __construct($url, $id, \HTTP_Request2 $client = null)
    {
        $this->url = $url;

        if (null !== $client) {
            $this->client = $client;
        } else {
            $this->client = new \HTTP_Request2;
        }

        if (is_array($id)) {
            $this->id = $id;
        } else {
            $this->id = array($id);
        }
    }

    /**
     * Issue the request!
     *
     * @param string $url
     *
     * @return \HTTP_Request2_Response
     */
    public function makeRequest()
    {
        $response = $this->client->setUrl($this->url)->setMethod(\HTTP_Request2::METHOD_GET)->send();
        return $response;
    }

    /**
     * Parse the response!
     *
     * @param \HTTP_Request2_Response $response
     *
     * @return \stdClass
     *
     * @throws \RuntimeException|\LogicException
     * @todo   Fix all these assumptions about the response!
     */
    public function parseResponse(\HTTP_Request2_Response $response)
    {
        $body = $response->getBody();
        $json = json_decode($body);

        if (false === ($json instanceof \stdClass)) {
            throw new \RuntimeException("Could not decode response.");
        }
        if ($json->version !== $this->apiVersion) {
            throw new \LogicException("HuffPo API evolved: {$json->version} (supported: {$this->apiVersion})");
        }
        if (0 !== $json->error->code) {
            throw new \RuntimeException("An error occurred: {$json->error->message}.", $json->error->code);
        }
        if (1 === count($this->id)) {
            return $json->response->{$this->id[0]};
        }
        return $json->response;
    }
}