<?php
namespace Quentn\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Quentn\Exceptions\QuentnException;

class CustomFieldClient extends AbstractQuentnClient {
    
    private $CustomFieldEndPoint = "custom-fields/";

    /**
     * Get list of all custom fields
     *
     * @return array List of all custom fields
     * @throws GuzzleException
     */
    public function getCustomFields(){
        return $this->client->call($this->CustomFieldEndPoint);
    }

    /**
     * Finds a custom field by its ID
     *
     * @param int $id The custom fields's ID in the Quentn system.
     * @return array|string custom field data having its id, name, label, type, required and description
     * @throws GuzzleException
     */
    public function findCustomFieldById($id) {
        try {
            return $this->client->call($this->CustomFieldEndPoint. $id);
        }catch (ClientException $e) {
            if($e->getCode() == 404){
                return $this->client->prepareResponse(array(), $e->getCode(), $e->getResponse()->getHeaders());
            }
            throw $e;
        }

    }
    
    /**
     * Finds a custom field by its ID
     *
     * @param string $name The custom fields's name in the Quentn system.
     * @return array|string custom field data having its id, name, label, type, required and description
     * @throws GuzzleException
     */
    public function findCustomFieldByName($name) {
        try {
            return $this->client->call($this->CustomFieldEndPoint. $name);
        }catch (ClientException $e) {
            if($e->getCode() == 404){
                return $this->client->prepareResponse(array(), $e->getCode(), $e->getResponse()->getHeaders());
            }
            throw $e;
        }

    }

    /**
     * Create new custom field
     *
     * @param array $data Custom field data.
     * @return array
     * @throws GuzzleException
     */
    public function createCustomField($data){
        return $this->client->call($this->CustomFieldEndPoint, "POST", $data);
    }

    /**
     * Update custom field
     *
     * @param string $field custom field
     * @param array $data custom field data
     * @return array
     * @throws GuzzleException
     */
    public function updateCustomField($field_name, $data){
        return $this->client->call($this->CustomFieldEndPoint. $field_name, "PUT", $data);
    }

    /**
     * Delete custom field
     *
     * @param string $field Custom field name which you want to delete from quentn system
     * @return array
     * @throws GuzzleException
     */
    public function deleteCustomField($field_name){
        return $this->client->call($this->CustomFieldEndPoint. $field_name, "DELETE");
    }
}
