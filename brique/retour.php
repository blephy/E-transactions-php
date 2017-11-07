<?php
include 'config/client.php';
include 'utils/auth.php';
include 'utils/functions.php';
include 'utils/error-handler.php';

// Paiement en attente: error 99999, autorisation != 0
// Paiement effectué: error 00000, autorisation != 0
// Paiement refusé: error 001XX, autorisation = 0
// Paiement annulé: le paiement n'est pas engagé, donc cette page c'est pas appelé (cf doc IPN)

$IS_AUTH_REQUEST = 1;
$response = null;





// A FAIRE:
// SMTP pour envoie mail d'erreur sur compta@anapath.fr
// CURL pour envoie sur API local
// RESTREINDRE les IP autorisée à e-transactions





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
    if ($debug && $env_dev) { echo($response_json); } // on force si env = prod car on doit rien renvoyer !
    mail('dolle.allan@gmail.com','Auth OK',$_SERVER['QUERY_STRING'].$_SERVER['REMOTE_ADDR']);
  } else {
    // EMAIL et/ou DDN non présent, il faut donc absolument vérifier les LOG sur votre interface e-transactions !
    mail('dolle.allan@gmail.com','Auth OK - DDN ou EMAIL Absent',$_SERVER['QUERY_STRING'].$_SERVER['REMOTE_ADDR']);
  }
} else if ( $IS_AUTH_REQUEST === 0 ) {
  // Variables modifié ou pubkey changé ou message ne venant pas directement de e-transactions
  mail('dolle.allan@gmail.com','Auth FAIL',$_SERVER['QUERY_STRING'].$_SERVER['REMOTE_ADDR']);
} else {
  // Problème interne de décodage
  mail('dolle.allan@gmail.com','Auth INTERN ERROR',$_SERVER['QUERY_STRING'].$_SERVER['REMOTE_ADDR']);
}
?>
