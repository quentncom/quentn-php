<?php
namespace Quentn;

use GuzzleHttp\Client;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Quentn\Client\CustomFieldClient;
use Quentn\Exceptions\QuentnException;
use Quentn\Client\ContactClient;
use Quentn\Client\TermClient;
use Quentn\Client\OAuthClient;

/**
 * Description of QuentnPhpSdkClient
 * @author ckoen
 */
class Quentn implements QuentnBase {

    protected $httpClient;
    protected $apiKey;
    protected $baseUrl;
    private $contactClient;
    private $termClient;
    private $customFieldClient;
    private $oauthClient;

    /** $var array HTTP header collection */
    protected $headers = [];

    /**
     * QuentnPhpSdkClient constructor.
     * @param array $config
     */
    public function __construct($config = array()) {
        if (isset($config['api_key'])) {
            $this->apiKey = $config['api_key'];
        }

        if (isset($config['base_url'])) {
            $this->baseUrl = $config['base_url'];
        }

        $this->headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiKey,
        ];

        $this->httpClient = new Client();
    }

    /**
     * Varify app-key and base-url
     *
     * @return bool
     * @throws GuzzleException
     */
    public function test() {
        if (!isset($this->apiKey) || !isset($this->baseUrl)) {
            return false;
        }
        try {
            $response = $this->call("check-credentials");
            if (isset($response['data']['success']) && $response['data']['success']) {
                return true;
            }
        } catch (Exception $e) {
            return false;
        }
        return false;
    }

    /**
     * @return string
     */
    public function getBaseUrl() {
        return $this->baseUrl;
    }

    /**
     * @return string
     */
    public function getApiKey() {
        return $this->apiKey;
    }

    /**
     * @param string $key
     */
    public function setApiKey($key) {
        $this->apiKey = $key;
    }

    /**
     * @param string $url
     */
    public function setBaseUrl($url) {
        $this->baseUrl = $url;
    }

    /**
     *
     * Make a http request
     *
     * @param string $endPoint endpoint after base url e.g https://example.com/public/api/v1/{endpoint} , {endpoint} = terms
     * @param string $method http method e.g GET, POST, PUT, DELETE
     * @param array $vars (optional) data for http request e.g array("first_name" => "John")
     * @return array
     * @throws GuzzleException
     */
    public function call($endPoint, $method = "GET", $vars = null) {
        //build request
        $request_arr = [
            "headers" => $this->headers
        ];

        if (!empty($vars)) {
            $request_arr["json"] = $vars;
        }

        //make call
        $response = $this->httpClient->request(strtoupper($method), $this->baseUrl . $endPoint, $request_arr);

        //get Body
        $body = $response->getBody();
        if (!empty($body)) {
            $json_body = $body->getContents();
            $data = (array) json_decode($json_body, true);
        }
        return $this->prepareResponse($data, $response->getStatusCode(), $response->getHeaders());

        }


    /**
     * Make a oauth http request
     *
     * @param $oauthBaseUrl
     * @param array $vars data for http request
     * @return array
     * @throws GuzzleException
     */
    public function callOauth($oauthBaseUrl, $vars = null) {

        //build request
        $method = "POST";
        $request_arr = [
            "headers" => [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ]
        ];

        if (!empty($vars)) {
            $request_arr["body"] = $vars;
        }

        //make oauth call
            $response = $this->httpClient->request($method, $oauthBaseUrl, $request_arr);
            $return = [];
            //get Body
            $body = $response->getBody();
            if (!empty($body)) {
                $json_body = $body->getContents();
                $return = (array) json_decode($json_body, true);
            }
            return $return;
    }

    /**
     * Prepare Response
     *
     * @param array $data Response data
     * @param int $statusCode
     * @param array $headers Response headers
     * @return array
     */
    public function prepareResponse($data, $statusCode, $headers = []) {
        $return = [];

        $return['data'] = $data;
        $return['status'] = $statusCode;

        //get Rate limits
        if (!empty($headers)) {
            if (!empty($headers["X-Rate-Limit-Limit"])) {
                $return["rateLimits"]["limit"] = $headers["X-Rate-Limit-Limit"][0];
            }
            if (!empty($headers["X-Rate-Limit-Remaining"])) {
                $return["rateLimits"]["remaining"] = $headers["X-Rate-Limit-Remaining"][0];
            }
            if (!empty($headers["X-Rate-Limit-Reset"])) {
                $return["rateLimits"]["reset"] = $headers["X-Rate-Limit-Reset"][0];
            }
        }

        return $return;
    }


    /**
     * @return ContactClient
     * @throws QuentnException
     */
    public function contacts() {
        return ($this->contactClient ? $this->contactClient : $this->contactClient = new ContactClient($this));
    }

    /**
     * @return TermClient
     * @throws QuentnException
     */
    public function terms() {
        return ($this->termClient ? $this->termClient : $this->termClient = new TermClient($this));
    }

    /**
     * @return CustomFieldClient
     * @throws QuentnException
     */
    public function custom_fields() {
        return ($this->customFieldClient ? $this->customFieldClient : $this->customFieldClient = new CustomFieldClient($this));
    }

    /**
     * @return OAuthClient
     */
    public function oauth() {
        return ($this->oauthClient ? $this->oauthClient : $this->oauthClient = new OAuthClient($this));
    }

    /**
     * Set http header
     *
     * @param string $header
     * @param string $value
     */
    public function setHeader($header, $value) {
        $header = trim($header);
        $this->headers[$header] = trim($value);
    }

    /**
     * Set http headers
     *
     * @param array $headers
     */
    public function setHeaders($headers) {
        foreach ($headers as $header => $value) {
            $this->setHeader($header, $value);
        }
    }

    /**
     * Get http headers
     *
     * @return array
     */
    public function getHeaders() {
        return $this->headers;
    }

    /**
     * Delete header value
     *
     * @param string $header
     */
    public function deleteHeader($key) {
        unset($this->headers[$key]);
    }

}
