<?php
require __DIR__ . './../vendor/autoload.php';
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

    /**
    * get list of all terms
    */
    try {
        $get_response = $quentn->terms()->getTerms();
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
    * Find terms by ID
    */
    try {
        $get_response = $quentn->terms()->findTermById(7);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    if($get_response['status']=='200'){
        echo $get_response['data']['name'];
        echo $get_response['data']['description'];
    }
    else {
        echo 'Unable to proceed. Status Code:'.$get_response['status'];
    }

    /*
    * Find terms by Name
    */
    try {
        $get_response = $quentn->terms()->findTermByName('Tag AB');
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    if($get_response['status']=='200'){
        echo $get_response['data']['name'];
        echo $get_response['data']['description'];
    }
    else {
        echo 'Unable to proceed. Status Code:'.$get_response['status'];
    }

    /*
    * Create Term
    */
    $data = [
        "name" => "Example term Name",
        "description"=> "Example term description",
    ];
    try {
        $get_response = $quentn->terms()->createTerm($data);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    if($get_response['status']=='200'){
        $term_id = $get_response['data']['id'];
    }
    else {
        echo 'Unable to proceed. Status Code:'.$get_response['status'];
    }

    /*
     * Update term
     */
    $data = [
        "name" => "Example term updated Name",
        "description"=> "Example term updated description",
    ];
    try {
        $get_response = $quentn->terms()->updateTerm(13, $data);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    if($get_response['data']['success']) {
        echo "Term Updated successfully";
    }
    else {
        echo "Term updation failed";
    }

    /*
     * Delete term
     */
    try {
        $get_response = $quentn->terms()->deleteTerm(13, $data);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    if($get_response['data']['success']) {
        echo "Term Deleted successfully";
    }
    else {
        echo "Term deletion failed";
    }
