<?php
require __DIR__ . './../vendor/autoload.php';
$quentn = new Quentn\Quentn([
    'api_key' => 'API_KEY',
    'base_url' => 'BASE_URL',
]);


//TEST API CREDENTIALS.
if (!$quentn->test()) {
    echo "key doesn't seem to work";
    exit;
}

/**
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
/*
     * Find contact by id, fields are optional
     */
    try {
        $get_response = $quentn->contacts()->findContactById($contactId, 'first_name, mail');
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    if($get_response['status']=='200'){
        echo $get_response['data']['first_name'];
        echo $get_response['data']['mail'];
    }
    else {
        echo 'Unable to proceed. Status Code:'.$get_response['status'];
    }

    /*
    * Find contact by mail, fields are optional, we may get more than one contacts by mail
    */
    try {
        $get_response = $quentn->contacts()->findContactByMail('john@example.com', 'first_name, mail');
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    if($get_response['status']=='200'){
        $contacts = $get_response['data'];
        foreach ($contacts as $contact) {
            echo $contact['first_name'];
        }
    }
    else {
        echo 'Unable to proceed. Status Code:'.$get_response['status'];
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
    try {
    $get_response = $quentn->contacts()->createContact($data);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    if($get_response['status']=='200'){
        //get id of newly created contact
        $cid = $get_response['data']['id'];
    }
    else {
        echo 'Unable to proceed. Status Code:'.$get_response['status'];
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
        $get_response = $quentn->contacts()->updateContact($cid, $data);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    if($get_response['data']['success']) {
        echo "Contact is updated successfully";
    }
    else {
        echo "Contact updation failed";
    }

    /*
    * Delete contact
    */
    try {
        $get_response = $quentn->contacts()->deleteContact($cid);
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    if($get_response['data']['success']) {
        echo "Contact is deleted successfully";
    }
    else {
        echo "Contact deletion failed";
    }

    /*
    * Get all terms of a contact
    */
    try {
        $get_response = $quentn->contacts()->getContactTerms($contactId);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    if($get_response['status']=='200'){
        $terms = $get_response['data'];
        foreach ($terms as $term) {
            echo $term['name'];
        }
    }
    else {
        echo 'Unable to proceed. Status Code:'.$get_response['status'];
    }

    /*
    * Overwrite all terms of a contact,
    */
    $terms_ids = [1,2,3];
    try {
        $get_response = $quentn->contacts()->setContactTerms($contactId,$terms_ids);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    if($get_response['data']['success']) {
        echo "Terms updated successfully";
    }
    else {
        echo "Terms updation failed";
    }

    /*
    * add term to a contact
    */
    $terms_ids = [4,5,6];
    try {
        $get_response = $quentn->contacts()->addContactTerms($contactId,$terms_ids);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    if($get_response['data']['success']) {
        echo "Terms updated successfully";
    }
    else {
        echo "Terms updation failed";
    }

    /*
    * delete term from a contact
    */
    $terms_ids = [1,2];
    try {
        $get_response = $quentn->contacts()->deleteContactTerms($contactId,$terms_ids);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    if($get_response['data']['success']) {
        echo "Terms deleted successfully";
    }
    else {
        echo "Terms deletion failed";
    }



