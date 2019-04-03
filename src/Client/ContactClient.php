<?php
namespace Quentn\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ClientException;

class ContactClient extends AbstractQuentnClient {
    
    private $contactEndPoint = "contact/";

    /**
     * Finds a contact by its ID and returns the specified fields. If no fields are specified, default fields will be returned.
     *
     * @param int $id The contact's ID in the Quentn system.
     * @param string $fields (optional) A comma separated list of field names, which you want to get returned.
     * @return array  Contact Data
     * @throws GuzzleException
     */
    public function findContactById($id, $fields = NULL){
        if($fields) {
            $fields = "?fields=".$fields;                   
        }
        try {
            return $this->client->call($this->contactEndPoint. $id . $fields);
        }catch (ClientException $e) {
            if($e->getCode() == 404){
                return $this->client->prepareResponse(array(), $e->getCode(), $e->getResponse()->getHeaders());
            }
           throw $e;
        }

    }
    
    
    /**
     * Finds a contact by its email address and returns the specified fields. If no fields are specified, default fields will be returned.
     *
     * @param string $mail The contact's email in the Quentn system.
     * @param string $fields (optional) A comma separated list of field names, which you want to get returned.
     * @return array  Contact Data
     * @throws GuzzleException
     */
    public function findContactByMail($mail, $fields = NULL) {
         if($fields) {             
            $fields = "?fields=".$fields;                   
        }
        try {
            return $this->client->call($this->contactEndPoint. $mail . $fields);
        }catch (ClientException $e) {
            if($e->getCode() == 404){
                return $this->client->prepareResponse(array(), $e->getCode(), $e->getResponse()->getHeaders());
            }
            throw $e;
        }
    }
    
    
    /**
     * Create a new contact
     *
     * @param array $data Contact data must contain either a valid mail field or a full address including the following fields: first_name, family_name, ba_street, ba_city, ba_postal_code.
     * @return array
     * @throws GuzzleException
     */
    public function createContact($data, $duplicate_check_method = 'email', $duplicate_merge_method = 'update'){
         $data['contact'] = $data;
         $data['duplicate_check_method'] = $duplicate_check_method;
         $data['duplicate_merge_method'] = $duplicate_merge_method;
         return $this->client->call($this->contactEndPoint, "POST", $data);
    }
    
    /**
     * Upeate a contact
     *
     * @param int $id Contact's id of quentn system which you want to update
     * @param array $data contact's fields which you want to update
     * @return array
     * @throws GuzzleException
     */
    public function updateContact($id, $data){
        return $this->client->call($this->contactEndPoint. $id, "PUT", $data);
    }
    
    /**
     * Delete a contact
     *
     * @param int $id Contact's id which you want to delete form quentn system
     * @return array
     * @throws GuzzleException
     */
    public function deleteContact($id){
        return $this->client->call($this->contactEndPoint. $id, "DELETE");
    }
      
    /**
     * Get all terms of a quentn contact
     *
     * @param int $id Contact's id which terms you want to get
     * @return array  Contact Terms
     * @throws GuzzleException
     */
      public function getContactTerms($id){
          try {
              return $this->client->call($this->contactEndPoint. $id . "/terms");
          }catch (ClientException $e) {
              if($e->getCode() == 404){
                  return $this->client->prepareResponse(array(), $e->getCode(), $e->getResponse()->getHeaders());
              }
              throw $e;
          }
      }
      
    /**
     * Overwrite all terms of contact, be careful while using this function, it will delete all existing terms for this contact
     *
     * @param int $id Contact's id whose terms you want to overwrite in quentn system
     * @param array $terms List of terms id from quentn system which you want to keep for this contact
     * @return array
     * @throws GuzzleException
     */
      public function setContactTerms($id, $terms){
        return $this->client->call($this->contactEndPoint. $id . "/terms", "POST", $terms);
      }

    /**
     * Add terms to a contact
     *
     * @param int $id Contact's id for which you want to add new terms
     * @param array $terms List of terms id from quentn system which you want to add to this contact
     * @return array
     * @throws GuzzleException
     */
      public function addContactTerms($id, $terms){
        return $this->client->call($this->contactEndPoint. $id . "/terms", "PUT", $terms);
      }

    /**
     * Delete terms from a contact
     *
     * @param int $id Contact's id from which you want to delete terms
     * @param array $terms list of terms you want to delete for this contact
     * @return array
     * @throws GuzzleException
     */
      public function deleteContactTerms($id, $terms){
        return $this->client->call($this->contactEndPoint. $id . "/terms", "DELETE", $terms);
      }

}
