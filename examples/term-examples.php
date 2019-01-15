<?php
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
      $terms = $get_response['data'];
      foreach ($terms as $term) {
         echo $term['name']."\n";
      }
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    /*
    * Find terms by ID
    */
    try {
      $get_response = $quentn->terms()->findTermById($termId);
      echo $get_response['data']['name']."\n";
      echo $get_response['data']['description'];
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    /*
    * Find terms by Name
    */
    try {
      $get_response = $quentn->terms()->findTermByName($termName);
      echo $get_response['data']['name']."\n";
      echo $get_response['data']['description'];
    } catch (Exception $e) {
        echo $e->getMessage();
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
      $term_id = $get_response['data']['id'];
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    /*
     * Update term
     */
    $data = [
        "name" => "Example term updated Name",
        "description"=> "Example term updated description",
    ];
    try {
      $get_response = $quentn->terms()->updateTerm($termId, $data);
      echo "Term Updated successfully";
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    /*
     * Delete term
     */
    try {
      $get_response = $quentn->terms()->deleteTerm($termId, $data);
      echo "Term Deleted successfully";
    } catch (Exception $e) {
        echo $e->getMessage();
    }