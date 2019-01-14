<?php
require __DIR__ . './../vendor/autoload.php';
if(empty(session_id())) {
    session_start();
}

$quentn = new Quentn\Quentn();
$quentn->oauth()->setApp([
    'client_id' => '10',
    'client_secret' => 'FnIDswFOfSAah_BC7i0NDBSCh_PYmXjqtg9olvDyVj0',
    'redirect_uri' => 'http://waqas.dev.quentn.com/sdk/quentn-php/examples/oauth-examples.php',
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
  echo '<a href="' . $quentn->oauth()->getAuthorizationUrl() . '">Click here to get authorize</a>';
}