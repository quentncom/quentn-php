<?php
require __DIR__ . './vendor/autoload.php';
if(empty(session_id())) {
    session_start();
}

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
  echo '<a href="' . $quentn->oauth()->getAuthorizationUrl() . '">Click here to get authorize</a>';
}