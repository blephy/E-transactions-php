<?php
header('Content-type: application/json; charset=utf-8');

include_once 'config/client.php';
include_once 'config/e-transactions.php';
include_once 'utils/auth.php';
include_once 'utils/functions.php';
include_once 'utils/error-handler.php';

// Restreindre l'accès à l'IPN par IP (cf config/e-transactions.php)
$CLIENT_IP = $_SERVER['REMOTE_ADDR'];

if ( in_array($CLIENT_IP, $serveur_etransactions_ip) ) {
  http_response_code(200);
} else {
  http_response_code(403);
  die('Forbidden');
}

// Paiement en attente: error 99999, autorisation != 0
// Paiement effectué: error 00000, autorisation != 0
// Paiement refusé: error 001XX, autorisation = 0
// Paiement annulé: la transaction n'est pas engagé, donc cette page n'est pas appelé (cf doc IPN)

// Vérification RSA de la requète - Securité !
$IS_AUTH_REQUEST = IsAuthRequest('pbx');

$response = array();

if ( $IS_AUTH_REQUEST ) {
  // Envoie de la requete sur l'API
  if ( isset($_GET[$client_prv_email]) && isset($_GET[$client_prv_ddn]) ) {
    $response[$client_prv_email] = verifBeforeGetQuery($client_prv_email);
    $response[$client_prv_ddn] = verifBeforeGetQuery($client_prv_ddn);
    $response[$client_pbx_ref] = verifBeforeGetQuery($client_pbx_ref);
    $response[$client_pbx_montant] = verifBeforeGetQuery($client_pbx_montant)/100;
    $response[$client_pbx_date] = convertDate(verifBeforeGetQuery($client_pbx_date), '/');
    $response[$client_pbx_heure] = verifBeforeGetQuery($client_pbx_heure);
    $response[$client_pbx_type_paiement] = verifBeforeGetQuery($client_pbx_type_paiement);
    $response[$client_pbx_cb] = verifBeforeGetQuery($client_pbx_cb);
    $response[$client_pbx_transaction] = verifBeforeGetQuery($client_pbx_transaction);
    $response[$client_pbx_error] = verifBeforeGetQuery($client_pbx_error);
    $response[$client_prv_error_trad] = errorHandler(verifBeforeGetQuery($client_pbx_error));
    $response[$client_pbx_autorisation] = verifBeforeGetQuery($client_pbx_autorisation);
    $response_json = json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    // Info pour debugging
    // on force false si env = prod car on doit rien renvoyer !
    if ($debug && $env_dev) {
      echo 'Requete format Json: '.$response_json.'\n';
    }

    // Send mail
    sendNotifIPN("Auth OK", $response_json);

  } else {
    // EMAIL et/ou DDN non présent, il faut donc absolument vérifier les LOG sur votre interface e-transactions !
    // Send mail
    mail('dolle.allan@gmail.com','Auth OK - DDN ou EMAIL Absent',"QUERY: ".$_SERVER['QUERY_STRING']."\r\nIP: ".$_SERVER['REMOTE_ADDR']);
  }
} else if ( $IS_AUTH_REQUEST === 0 ) {
  // Variables modifiées ou pubkey changée ou message ne venant pas directement de e-transactions
  // Send mail
  mail('dolle.allan@gmail.com','Auth FAIL',"QUERY: ".$_SERVER['QUERY_STRING']."\r\nIP: ".$_SERVER['REMOTE_ADDR']);
} else {
  // Problème interne de décodage
  // Send mail
  mail('dolle.allan@gmail.com','Auth INTERN ERROR',"QUERY: ".$_SERVER['QUERY_STRING']."\r\nIP: ".$_SERVER['REMOTE_ADDR']);
}
?>
