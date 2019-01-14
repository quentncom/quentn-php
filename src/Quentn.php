<?php
namespace Quentn;

use GuzzleHttp\Client;
use Exception;
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
    private $oauthClient;

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
        $this->httpClient = new Client();
    }

    /**
     * Varify app-key and base-url
     *
     * @return bool
     */
    public function test() {
        try {
            $response = $this->call("check-credentials");
            return true;
        } catch (Exception $e) {
            return false;
        }
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
     * @param $endPoint endpoint after base url e.g https://example.com/public/api/v1/{endpoint} , {endpoint} = terms
     * @param string $method http method e.g GET, POST, PUT, DELETE
     * @param array $vars (optional) data for http request e.g array("first_name" => "John")
     * @return array
     */
    public function call($endPoint, $method = "GET", $vars = null) {

        //build request       
        $request_arr = [
            "headers" => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->apiKey,
            ]
        ];
        if (!empty($vars)) {
            $request_arr["json"] = $vars;
        }

        //make call
            $response = $this->httpClient->request(strtoupper($method), $this->baseUrl . $endPoint, $request_arr);
            $return = [
                "data" => [],
                "status" => $response->getStatusCode(),
                "rateLimits" => [],
            ];

            //get Body
            $body = $response->getBody();
            if (!empty($body)) {
                $json_body = $body->getContents();
                $return["data"] = (array) json_decode($json_body, true);
            }

            //get Rate limits            
            $header = $response->getHeaders();
            if (!empty($header)) {
                if (!empty($header["X-Rate-Limit-Limit"])) {
                    $return["rateLimits"]["limit"] = $header["X-Rate-Limit-Limit"][0];
                }
                if (!empty($header["X-Rate-Limit-Remaining"])) {
                    $return["rateLimits"]["remaining"] = $header["X-Rate-Limit-Remaining"][0];
                }
                if (!empty($header["X-Rate-Limit-Reset"])) {
                    $return["rateLimits"]["reset"] = $header["X-Rate-Limit-Reset"][0];
                }
            }
            return $return;
        }


    /**
     * Make a oauth http request
     *
     * @param $oauthBaseUrl
     * @param array $vars data for http request
     * @return array
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
     * @return ContactClient
     * @throws QuentnException
     */
    public function contacts() {
        if (!isset($this->apiKey)) {
            throw new QuentnException("API key is not set");
        }
        if (!isset($this->baseUrl)) {
            throw new QuentnException("Base URL is not set");
        }

        return ($this->contactClient ? $this->contactClient : $this->contactClient = new ContactClient($this));
    }

    /**
     * @return TermClient
     * @throws QuentnException
     */
    public function terms() {
        if (!isset($this->apiKey)) {
            throw new QuentnException("API key is not set");
        }
        if (!isset($this->baseUrl)) {
            throw new QuentnException("Base URL is not set");
        }
        return ($this->termClient ? $this->termClient : $this->termClient = new TermClient($this));
    }

    /**
     * @return OAuthClient
     */
    public function oauth() {
        return ($this->oauthClient ? $this->oauthClient : $this->oauthClient = new OAuthClient($this));
    }

}
