# quentn-php
Official Quentn PHP API Client

This is the official PHP library which provides a simple interface to Quentn API. It is easy to use and fully supported by Quentn.com GmbH

## Installation

You need to install [Composer](http://getcomposer.org) to manage dependencies.

Run the following Composer command to install the latest stable version of Quentn PHP SDK.

    composer require quentn/php-sdk
## Examples
We need to add *autoload.php* at the top of each file
       
    require __DIR__ . './vendor/autoload.php';
Response include three main elements, data, status and rateLimits         
    
**Data:** Data depends on your request, it can be contact details like name, email etc, it can be
 request success status i.e true/false.

**Status:** HTTP Status Codes

**Rate Limits:** All calls within the Web API are allotted a specific number of requests per refresh period.     
 Each API response contains limit numbers, remaining and reset time.

### Contact API Example

	require __DIR__ . './vendor/autoload.php'; 
    $quentn = new Quentn\Quentn([
        'api_key' => 'API_KEY',
        'base_url' => 'BASE_URL',
    ]);
    
    //add additional headers    
    $headers = [
        'X-sender-source' => 'mybusinessid',
        'X-sender-source-key' => 'cdTHikGOQQuiIqo2VcCmkyIqIPq82oUm7juC9wqnxY',
    ];
    $quentn->setHeaders($headers);
    
    if (!$quentn->test()) {
        echo "key doesn't seem to work";
        exit;
    }
    //create contact       
    $data = [
            "first_name" => "Johnn",
            "family_name" => "Doe",
            "mail" => "johndoe@example.com",
        ];
        try {
            $get_response = $quentn->contacts()->createContact($data);
            //get id of newly created contact
            $contact_id = $get_response['data']['id'];
        } catch (Exception $e) {
            echo $e->getMessage();
        }
       
    // Get all terms of a contact
     try {
          $get_response = $quentn->contacts()->getContactTerms($contactId);
          $terms = $get_response['data'];
          foreach ($terms as $term) {
             echo $term['name']."\n";
          }
     } catch (Exception $e) {
            echo $e->getMessage();
     }                   
  
With Contact Api, you can perform following functions

**GET a Contact by Id**

User can find contact by ID
    
    findContactById((int) $contactId, (string)$fields = NULL);

**GET a Contact by Mail**

User can find contact by Email

    findContactByMail((string) $mail, (string)$fields = NULL);

**Create Contact**

User can create contact

    createContact((array)$data);
    
**Create Multiple Contacts**

User can create multiple contacts in one call

    createContacts((array)$data);

**Update Contact**

User can update contact

    updateContact((int)$contactId, (array)$data);

**Delete Contact**

User can delete contact

    deleteContact((int)$contactId); 

**GET Contact Terms**

User can Get all terms of a contact
           
    getContactTerms((int)$contactId)

**SET contact terms** **(DEPRECATED)**

User can **overwrite** all contact terms. By using this POST method you will overwrite the whole terms field.

**Attention:** This will delete all your existing terms. If you want to add terms please use *addContactTerms*.

    setContactTerms((int)$contactId, (array)$terms);

**Add Contact terms**

User can add term to a contact

    addContactTerms((int) $id, (array)$terms);

**Delete a contact term**

User can delete terms of a contact

    deleteContactTerms((int) $id, (array)$terms);


    
[Click here](https://github.com/quentncom/quentn-php/blob/master/examples/contact-examples.php/) to view full example of usage of contact API   

### Term API Example
   
        require __DIR__ . './vendor/autoload.php'; 
        $quentn = new Quentn\Quentn([
            'api_key' => 'API_KEY',
            'base_url' => 'BASE_URL',
        ]);
        
        /*
        * TEST API CREDENTIALS.
        */
        if (!$quentn->test()) {
            echo "key doesn't seem to work";
            exit;
        }
        
            /*
            * get list of all terms
            */
            try {
                $get_response = $quentn->terms()->getTerms();
                $terms = $get_response['data'];
                foreach ($terms as $term) {
                    echo $term['name']."\n";
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
                              
        //get term by id
         try {
                $get_response = $quentn->terms()->findTermById($termId);
                 echo $get_response['data']['name']."\n";
                 echo $get_response['data']['description'];
            } catch (Exception $e) {
                echo $e->getMessage();
            }
               
With Term Api, you can perform following functions

**GET Terms**

User can find a list of all terms

    getTerms((int)$offset = 0, (int)$limit = 500);

**GET Term by ID**

User can find term by Id

    findTermById((int)$termId);

**Get Term by Name**

User can find term by name
    
    findTermByName((string)$termName);

**Create Term**

User can create terms

    createTerm((array)$data);

**Update Term**

User can update term

    updateTerm((int)$id, (array)$data);

**Delete Term**

User can delelte term

    deleteTerm((int)$termId);


               
[Click here](https://github.com/quentncom/quentn-php/blob/master/examples/term-examples.php/) to view full example of usage of term API


### Custom Field API Example
   
        require __DIR__ . './vendor/autoload.php'; 
        $quentn = new Quentn\Quentn([
            'api_key' => 'API_KEY',
            'base_url' => 'BASE_URL',
        ]);
        
        /*
        * TEST API CREDENTIALS.
        */
        if (!$quentn->test()) {
            echo "key doesn't seem to work";
            exit;
        }
        
            /*
            * get list of all custom fields
            */
            try {
                  $get_response = $quentn->custom_fields()->getCustomFields();
                  $custom_fields = $get_response['data'];
                  foreach ($custom_fields as $custom_field) {
                     echo $custom_field['field_name']."\n";
                  }
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
                              
        //find custom field by ID
         try {
               $get_response = $quentn->custom_fields()->findCustomFieldById($customFieldId);
               echo $get_response['data']['field_name']."\n";
               echo $get_response['data']['label']."\n";
               echo $get_response['data']['description']."\n";
               echo $get_response['data']['type']."\n";
               echo $get_response['data']['required']."\n";
             } catch (Exception $e) {
                 echo $e->getMessage();
             }
               
With Contact Field Api, you can perform following functions

**GET Custom Fields**

User can find a list of all custom fields

    getCustomFields();

**GET Cutom Field by ID**

User can find Cutom Field by Id

    findCustomFieldById((int)$customFieldId);

**Get Cutom Field by Name**

User can find Cutom Field by name
    
    findCustomFieldByName((string)$cutomFieldName);

**Create Cutom Field**

User can create cutom field

    createCustomField((array)$data);

**Update Cutom Field**

User can update cutom field

    updateCustomField((string)$cutomFieldName, (array)$data);

**Delete Cutom Field**

User can delete cutom field

    deleteCustomField((string)$cutomFieldName);

[Click here](https://github.com/quentncom/quentn-php/blob/master/examples/custom-field-examples.php/) to view full example of usage of Cutom Field API    
## OAuth

To start your OAuth process, you need to register your app with the Quentn.
After registration your will get Client ID and Client Secret.

**Set OAuth Configuration**

Once you got Client ID and Client Secret, you need to call function *setApp*  with the following
variables 

**client_id:** The client ID you received when you created your app with Quentn

**client_secret:** The client ID you received when you created your app with Quentn  

**redirect_url:** Indicates the URI to return the user after authorization. Domain must be one of the domains you already registered with quentn. For example, if you registered *example.com*, then you can use *example.com/my/redirect/url*
    
    setApp([
            'client_id' => 'CLIENT_ID',
            'client_secret' => 'CLIENT_SECRET',
            'redirect_uri' => 'REDIRECT_URL',   
        ]);
 
**Get Authorization Url**

To get Authorization link to the user, you need to call the *getAuthorizationUrl()* 

    getAuthorizationUrl();

In return you will get authorization url, i.e

    https://my.quentn.com/public/api/v1/oauth/?client_id=CLIENT_ID&redirect_uri=REDIRECT_URI&response_type=code&scope=all&state=4a4c2ZD


**client_id:** As mentioned above, the client ID you received when you created your app with Quentn  

**redirect_uri:** As mentioned above, it indicates the URI to return the user after authorization. Domain must be one of the domains you already registered with quentn. For example, if you registered *example.com*, then you can use *example.com/my/redirect/url*

**scope:** It indicates the values which parts of the user's account you want to access, default is 'all'

**response_type:** It indicates that your server expects to receive an authorization code, default is code

**state:** A random string generated by your application, it will varify later


**Check if User is Successfully Authorized**

To check if user is successfully authorized, you can use following function.

    authorize() 
    
### OAuth example
    
        require __DIR__ . './vendor/autoload.php'; 
        $quentn = new Quentn\Quentn();        
        $quentn->oauth()->setApp([
            'client_id' => 'CLIENT_ID',
            'client_secret' => 'CLIENT_SECRET',
            'redirect_uri' => 'REDIRECT_URL',   
        ]);
        
        if($quentn->oauth()->authorize()) {                        
                /*
                do you stuff here
                You can access your App key and base url here
                     echo $quentn->getApiKey()."\n";
                     echo $quentn->getBaseUrl()."\n";
                */
                    try {
                        $get_response = $quentn->contacts()->findContactById($contactId, 'first_name, mail');
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }            
        }
        
        else {
          //to get the Authorization URL you can use getAuthorizationUrl() function
          echo '<a href="' . $quentn->oauth()->getAuthorizationUrl() . '">Click here to get authorize</a>';   
        }       



## Full Quentn API Documentation

[Click here to view our full Quentn documentation.](https://docs.quentn.com/api/requests/)

## License

![MIT](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)
