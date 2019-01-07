<?php
namespace Quentn;

use GuzzleHttp\Client;
use Exception;
use Quentn\Exceptions\QuentnException;

/**
 * Description of QuentnPhpSdkClient
 * @author ckoen
 */
class QuentnPhpSdkClient implements QuentnPHPClientBase {

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
     * @param $endPoint
     * @param string $method
     * @param null $vars
     * @return array|string
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
     * @param $oauthBaseUrl
     * @param string $method
     * @param null $vars
     * @return array|string
     */
    public function callOauth($oauthBaseUrl, $method = "GET", $vars = null) {

        //build request
        $request_arr = [
            "headers" => [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ]
        ];

        if (!empty($vars)) {
            $request_arr["body"] = $vars;
        }

        //make oauth call
        try {
            $response = $this->httpClient->request(strtoupper($method), $oauthBaseUrl, $request_arr);
            //get Body
            $body = $response->getBody();
            if (!empty($body)) {
                $json_body = $body->getContents();
                $return = (array) json_decode($json_body, true);
            }
            return $return;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @return QuentnPhpSdkContactClient
     * @throws QuentnException
     */
    public function contacts() {
        if (!isset($this->apiKey)) {
            throw new QuentnException("API key is not set");
        }
        if (!isset($this->baseUrl)) {
            throw new QuentnException("Base URL is not set");
        }

        return ($this->contactClient ? $this->contactClient : $this->contactClient = new QuentnPhpSdkContactClient($this));
    }

    /**
     * @return QuentnPhpSdkTermClient
     * @throws QuentnException
     */
    public function terms() {
        if (!isset($this->apiKey)) {
            throw new QuentnException("API key is not set");
        }
        if (!isset($this->baseUrl)) {
            throw new QuentnException("Base URL is not set");
        }
        return ($this->termClient ? $this->termClient : $this->termClient = new QuentnPhpSdkTermClient($this));
    }

    /**
     * @return QuentnPhpSdkOAuthClient
     */
    public function oauth() {
        return ($this->oauthClient ? $this->oauthClient : $this->oauthClient = new QuentnPhpSdkOAuthClient($this));
    }

}
