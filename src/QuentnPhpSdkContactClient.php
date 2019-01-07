<?php
namespace Quentn;
use Quentn\Exceptions\QuentnException;

class QuentnPhpSdkContactClient extends AbstractQuentnApi {
    
    private $contactEndPoint = "contact/";

    /**
     * @param int $id
     * @param string $fields User Info
     * @return array  Contact Data
     */
    public function findContactById($id = NULL, $fields = NULL){
        if($fields) {
            $fields = "?fields=".$fields;                   
        }
        return $this->client->call($this->contactEndPoint. $id . $fields);
    }
    
    
    /**
     * @param string $mail
     * @param string $fields user info
     * @return array  Contact Data
     */
    public function findContactByMail($mail = NULL, $fields = NULL) {         
         if($fields) {             
            $fields = "?fields=".$fields;                   
        }       
        return $this->client->call($this->contactEndPoint. $mail . $fields);
    }
    
    
    /**
     * @param array $data add contact data
     * @return int $id
     */
    public function createContact($data){
         $data['contact'] = $data;
         return $this->client->call($this->contactEndPoint, "POST", $data);
    }
    
    /**
     * @param int $id
     * @param array $data
     * @return $boolean
     */
    public function updateContact($id, $data){
        return $this->client->call($this->contactEndPoint. $id, "PUT", $data);
    }
    
    /**
     * @param int $id
     * @return boolean
     */
    public function deleteContact($id){
        return $this->client->call($this->contactEndPoint. $id, "DELETE");
    }
      
    /**
     * @param int $id*
     * @return array  Contact Terms
     */
      public function getContactTerms($id){
        return $this->client->call($this->contactEndPoint. $id . "/terms", "GET");
      }
      
    /**
     * By using this method you will overwrite the whole terms field
     * @param int $id contact id
     * @param array $terms terms id's
     * @return boolean
     */
      public function setContactTerms($id, $terms){
        return $this->client->call($this->contactEndPoint. $id . "/terms", "POST", $terms);
      }

    /**
     * By using this method you will add contact tags
     * @param int $id contact id
     * @param array $terms term id's
     * @return boolean
     */
      public function addContactTerms($id, $terms){
        return $this->client->call($this->contactEndPoint. $id . "/terms", "PUT", $terms);
      }

    /**
     * @param int $id   contact id*
     * @param array $terms term id's*
     * @return boolean
     */
      public function deleteContactTerms($id, $terms){
        return $this->client->call($this->contactEndPoint. $id . "/terms", "DELETE", $terms);
      }

}
