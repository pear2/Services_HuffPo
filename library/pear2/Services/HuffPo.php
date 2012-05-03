<?php
namespace pear2\Services;

class HuffPo
{
    /**
     * The API's version this wrapper supports!
     * @var string $apiVersion
     */
    protected $apiVersion = '1.0';

    /**
     * Article's numeric ID.
     * @var int
     */
    protected $articleId;

    /**
     * A \HTTP_Request2 object to run remote connects.
     * @var \HTTP_Request2
     */
    protected $client;

    /**
     * API Endpoint
     * @var string
     */
    protected $endpoint = 'http://www.huffingtonpost.com/api/';

    /**
     * An aritcle's URL.
     * @var string
     */
    protected $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getApiRequestUrl()
    {
        $request = sprintf('%s?t=entry&entry_ids=%d', $this->endpoint, $this->getArticleId());
        return $request;
    }

    /**
     * Return the aricle's ID from the URL, or parse it on demand.
     *
     * @return int
     * @throws \InvalidArgumentException|\RuntimeException
     */
    public function getArticleId()
    {
        if (null === $this->articleId) {
            $uri = parse_url($this->url);
            if (!isset($uri['host']) || !isset($uri['path']) || empty($uri['path'])) {
                throw new \InvalidArgumentException("Url '{$this->url}' seems to be invalid.");
            }
            if (false === strpos($uri['host'], 'huffingtonpost.com')) {
                throw new \InvalidArgumentException("Url '{$this->url}' is not from huffingtonpost.com.");
            }
            if (1 !== ($c = preg_match('/(.*)\_(n|b)\_([0-9]{3,})\.html/', $this->url, $matches))) {
                throw new \InvalidArgumentException("Url '{$this->url}' contains no ID.");
            }
            if (!isset($matches[3])) {
                throw new \RuntimeException("Failed parsing ID from '{$this->url}'.");
            }
            $this->articleId = (int) $matches[3];
        }
        return $this->articleId;
    }

    /**
     * Return a client object.
     *
     * @return \HTTP_Request2
     */
    public function getClient()
    {
        if (null === $this->client) {
            $this->client = new \HTTP_Request2;
        }
        return $this->client;
    }

    /**
     * @param \HTTP_Request2 $client
     * @return HuffPo
     */
    public function setClient(\HTTP_Request2 $client)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    public function getMetaData($url = null)
    {
        if (null !== $url) {
            $this->setUrl($url);
            $this->articleId = null;
        }
        $request  = $this->getApiRequestUrl();
        $response = $this->makeRequest($request);
        $this->parseResponse($response);
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Issue the request!
     *
     * @param string $url
     *
     * @return \HTTP_Request2_Response
     */
    protected function makeRequest($url)
    {
        $client   = $this->getClient();
        $response = $client->setUrl($url)->setMethod(\HTTP_Request2::METHOD_GET)->send();
        return $response;
    }

    /**
     * Parse the response!
     *
     */
    protected function parseResponse(\HTTP_Request2_Response $response)
    {
        $body = $response->getBody();
        $json = json_decode($body);

        var_dump($json);
    }
}
