# quentn-php
Official Quentn PHP API Client

This is the official PHP library which provides a simple interface to Quentn API. It is easy to use and fully supported by Quentn.com GmbH

## Installation

You need to install [Composer](http://getcomposer.org) to manage dependencies.

You can install *quentn-php* by [downloading (.zip)](https://github.com//quentncom/quentn-php/archive/master.zip) or using the following command:

`git clone https://github.com/quentncom/quentn-php.git`

After download PHP SDK from GitHub, run the following command:

    composer isntall

##Examples

### Contact API examples

	require __DIR__ . './quentn-php/vendor/autoload.php'; 
    $quentn = new Quentn\QuentnPhpSdkClient([
        'api_key' => 'API_KEY',
        'base_url' => 'BASE_URL',
    ]);
    
    //create contact
    if ($quentn->test()) {
        try {            
            $data = [
                "first_name" => "Johnn",
                "family_name" => "Doe",
                "mail" => "johndoe@example.com",                
            ];
            $get_response = $quentn->contacts()->createContact($data);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    } else {
        echo "key doesn't seem to work";
    }
    
    //And in same way we can perform following tasks
    
    /**
    //find contact by id
    $get_response = $quentn->contacts()->findContactById($contactId, 'first_name, mail');         
    
    //find contact by email address
    $get_response = $quentn->contacts()->findContactByMail($contactMail);         
    
    //update contact
    $get_response = $quentn->contacts()->updateContact($contactId, $data);         
    
    //delete contact
    $get_response = $quentn->contacts()->deleteContact($contactId);     
    
    //get all terms of a contact
    $get_response = $quentn->contacts()->getContactTerms($contactId);
    
    //overwrite all terms of a contact
    $get_response = $quentn->contacts()->setContactTerms($contactId, $terms);  
    
    //add term for a contact
    $get_response = $quentn->contacts()->addContactTerms($contactId, $terms);
    
    //delete terms of a contact
    $get_response = $quentn->contacts()->deleteContactTerms($contactId, $terms);
    **/     
    
### Term API examples
   
        require __DIR__ . './quentn-php/vendor/autoload.php'; 
        $quentn = new Quentn\QuentnPhpSdkClient([
            'api_key' => 'API_KEY',
            'base_url' => 'BASE_URL',
        ]);
        
        //get list of all terms
        if ($quentn->test()) {
            try {
                $get_response = $quentn->terms()->getTerms();
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        } else {
            echo "key doesn't seem to work";
        }
        
        //get term by id
        if ($quentn->test()) {
            try {
                $get_response = $quentn->terms()->findTermById($termId);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        } else {
            echo "key doesn't seem to work";
        }
        
        /**
        //find term by name
        $get_response = $quentn->terms()->findTermByName($termName);
        
        //create new term
        $get_response = $quentn->terms()->createTerm($data);
        
        //update term
        $get_response = $quentn->terms()->updateTerm($termId, $data);
        
        //delete term
        $get_response = $quentn->terms()->deleteTerm($termId);
        **/

### OAuth examples
    
        require __DIR__ . './quentn-php/vendor/autoload.php'; 
        $quentn = new Quentn\QuentnPhpSdkClient();
        $quentn->oauth()->setApp([
            'client_id' => 'CLIENT_ID',
            'client_secret' => 'CLIENT_SECRET',
            'redirect_uri' => 'REDIRECT URL',   
        ]);
        
        if($quentn->oauth()->authorize()) {       
                //do stuff             
        }
        
        else {
          echo '<a href="' . $quentn->oauth()->getAuthorizationUrl() . '">Click here to get authorize</a>';   
        }       



## Full Quentn API Documentation

[Click here to view our full Quentn documentation.](https://docs.quentn.com/)

## License

![MIT](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)