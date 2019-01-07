<?php
namespace Quentn;
use Quentn\Exceptions\QuentnException;

class QuentnPhpSdkTermClient extends AbstractQuentnApi {
    
    private $termEndPoint = "terms/";

    /**
     * Get all terms
     * @param int $offset The number of records to skip
     * @param int $limit The number of records to return
     * @return array List of all terms
     */
    public function getTerms($offset = 0, $limit = 500){                             
        return $this->client->call($this->termEndPoint. "?offset=". $offset. "&limit=". $limit);
    }

    /**
     * @param int $id Term id
     * @return array
     */
    public function findTermById($id) {        
        return $this->client->call($this->termEndPoint. $id);
    }
    
    /**
     * @param string name Term name
     * @return array
     */
    public function findTermByName($name) {        
        return $this->client->call($this->termEndPoint. $name);
    }
    
    
    /**
     * @param array $data Unique term name and description
     * @return int $id
     */
    public function createTerm($data){                
         return $this->client->call($this->termEndPoint, "POST", $data);
    }
    
    /**
     * @param int $id
     * @param array $data
     * @return $boolean
     */
    public function updateTerm($id, $data){                
        return $this->client->call($this->termEndPoint. $id, "PUT", $data);
    }

    /**        
     * @param int $id   contact id
     * @param array $terms term id's
     * @return boolean
     */
      public function deleteTerm($id){
        return $this->client->call($this->termEndPoint. $id . "/terms", "DELETE");
      }    
}
