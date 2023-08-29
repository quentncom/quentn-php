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

    /*
    * Find custom field by ID
    */
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

    /*
    * Find custom field by Name
    */
    try {
      $get_response = $quentn->custom_fields()->findCustomFieldByName($customFieldName);
      echo $get_response['data']['field_name']."\n";
      echo $get_response['data']['description'];
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    /*
    * Create custom field
    */
    $data = [
        "label" => "My new textfield",
        "description" => "Example description",
        "field_type" => "text",
        "max_length" => 128,
    ];

    try {
        $get_response = $quentn->custom_fields()->createCustomField($data, $args);
        $field_name = $get_response['data']['field_name'];
        $field_id = $get_response['data']['field_id'];
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    /*
    * Update custom field
    * we need to provide field name, and data
    */
    $field_name = 'field_my_new_textfield';
    $data = [
        "label" => "My renamed textfield",
        "description" => "Example description",
        "size" => 10,
    ];
    try {
        $get_response = $quentn->custom_fields()->updateCustomField($field_name, $data);
        echo "Field is updated successfully";
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    /*
    * Delete custom field
    */
    try {
        $get_response = $quentn->custom_fields()->deleteCustomField($field_name);
        echo "Field is deleted successfully";
    } catch (Exception $e) {
        echo $e->getMessage();
    }