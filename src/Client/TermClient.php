<?php
namespace Quentn\Client;
use Quentn\Exceptions\QuentnException;

class TermClient extends AbstractQuentnClient {
    
    private $termEndPoint = "terms/";

    /**
     * Get list of all terms
     *
     * @param int $offset The number of records to skip
     * @param int $limit The number of records to return
     * @return array List of all terms
     */
    public function getTerms($offset = 0, $limit = 500){                             
        return $this->client->call($this->termEndPoint. "?offset=". $offset. "&limit=". $limit);
    }

    /**
     * Finds a term by its ID
     *
     * @param int $id The terms's ID in the Quentn system.
     * @return array Term data having its id, name and description
     */
    public function findTermById($id) {        
        return $this->client->call($this->termEndPoint. $id);
    }
    
    /**
     * Finds a term by its ID
     *
     * @param string $name The terms's name in the Quentn system.
     * @return array Term data having its id, name and description
     */
    public function findTermByName($name) {        
        return $this->client->call($this->termEndPoint. $name);
    }
    
    
    /**
     * Create new term
     *
     * @param array $data Term names must be unique (case-insenitive). If the submitted term name already exists, the ID of the existing term will be returned.
     * @return int $id
     */
    public function createTerm($data){                
         return $this->client->call($this->termEndPoint, "POST", $data);
    }
    
    /**
     * Update term
     *
     * @param int $id Term's id which you want to update
     * @param array $data term data
     * @return $boolean
     */
    public function updateTerm($id, $data){                
        return $this->client->call($this->termEndPoint. $id, "PUT", $data);
    }

    /**
     * Delete term
     *
     * @param int $id Term id which you want to delete from quentn system
     * @return boolean
     */
      public function deleteTerm($id){
        return $this->client->call($this->termEndPoint. $id . "/terms", "DELETE");
      }    
}
