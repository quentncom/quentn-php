<?php
require __DIR__ . './vendor/autoload.php';
$quentn = new Quentn\Quentn([
    'api_key' => 'API_KEY',
    'base_url' => 'BASE_URL',
]);

//add additional headers
$quentn->setHeader('X-sender-source', 'mybusinessid');

//add multiple headers
$headers = [
    'X-sender-source' => 'mybusinessid',
    'X-sender-source-key' => 'cdTHikGOQQuiIqo2VcCmkyIqIPq82oUm7juC9wqnxY',
];
$quentn->setHeaders($headers);

//TEST API CREDENTIALS.
if (!$quentn->test()) {
    echo "key doesn't seem to work";
    exit;
}

/*
    //response include three main elements, data, status and rateLimits
    Array(
        [data] => Array(
        )
        [status] => (int)
        [rateLimits] => Array(
            [limit] => (int)
            [remaining] => (int)
            [reset] => (int)
        )
    )
*/

    /*
     * Find contact by id, fields are optional
     */
    try {
      $get_response = $quentn->contacts()->findContactById($contactId, 'first_name, mail');
      echo $get_response['data']['first_name']."\n";
      echo $get_response['data']['mail'];
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    /*
    * Find contact by mail, fields are optional, we may get more than one contacts by mail
    */
    try {
      $get_response = $quentn->contacts()->findContactByMail('john@example.com', 'first_name, mail');
      $contacts = $get_response['data'];
      foreach ($contacts as $contact) {
         echo $contact['first_name'];
      }
    } catch (Exception $e) {
        echo $e->getMessage();
    }


    /*
    * Create contact
    * we need to provide data in array, Contact object must contain either a valid mail field or a full address
    * including the following fields: first_name, family_name, ba_street, ba_city, ba_postal_code.
    */
    $data = [
        "first_name" => "Johnn",
        "family_name" => "Doe",
        "mail" => "johndoe@example.com",
    ];

    $args = [
        'duplicate_check_method' => 'email',
        'duplicate_merge_method' => 'update',
        'return_fields' => ['first_name', 'mail'],
        'flood_limit' => 7,
        'spam_protection' => true,
    ];

    try {
      $get_response = $quentn->contacts()->createContact($data, $args);
      $cid = $get_response['data']['id'];
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    /*
    * Create multiple contacts
    *
    * we need to provide list of multiple contacts
    */
    $data = [
        [
            "first_name" => "fisrt_name1",
            "family_name" => "last_name1",
            "mail" => "fname1@example.com",
            "request_ip" => "123.123.123.123",
        ],
        [
            "first_name" => "fisrt_name2",
            "family_name" => "last_name2",
            "mail" => "fname2@example.com",
            "request_ip" => "123.123.123.123",
        ],
        [
            "first_name" => "fisrt_name3",
            "family_name" => "last_name3",
            "mail" => "fname3@example.com",
            "request_ip" => "123.123.123.123",
        ],
        [
            "first_name" => "fisrt_name4",
            "family_name" => "last_name4",
            "mail" => "fname4@example.com",
            "request_ip" => "123.123.123.123",
        ],
    ];

    $args = [
        'duplicate_check_method' => 'email',
        'duplicate_merge_method' => 'update',
        'return_fields' => ['first_name', 'mail'],
        'flood_limit' => 7,
        'spam_protection' => true,
    ];

    try {
        $get_response = $quentn->contacts()->createContacts($data, $args);
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    /*
    * Update contact
    * we need to provide contact id, and data
    */
    $data = [
        "first_name" => "John",
        "family_name" => "Doe",
        "mail" => "johndoe_updated@example.com",
    ];
    try {
      $get_response = $quentn->contacts()->updateContact($contactId, $data);
      echo "Contact is updated successfully";
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    /*
    * Delete contact
    */
    try {
      $get_response = $quentn->contacts()->deleteContact($contactId);
      echo "Contact is deleted successfully";
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    /*
    * Get all terms of a contact
    */
    try {
       $get_response = $quentn->contacts()->getContactTerms($contactId);
       $terms = $get_response['data'];
       foreach ($terms as $term) {
            echo $term['name'];
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }


    /*
    * Overwrite all terms of a contact,
    */
    $terms_ids = [1,2,3];
    try {
       $get_response = $quentn->contacts()->setContactTerms($contactId,$terms_ids);
       echo "Terms updated successfully";
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    /*
    * add term to a contact
    */
    $terms_ids = [4,5,6];
    try {
      $get_response = $quentn->contacts()->addContactTerms($contactId,$terms_ids);
      echo "Terms updated successfully";
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    /*
    * delete term from a contact
    */
    $terms_ids = [1,2];
    try {
      $get_response = $quentn->contacts()->deleteContactTerms($contactId,$terms_ids);
      echo "Terms deleted successfully";
    } catch (Exception $e) {
        echo $e->getMessage();
    }