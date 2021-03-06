<?php
header('Content-type: text/html; charset=utf-8');

include_once 'config/client.php';
include_once 'config/e-transactions.php';
include_once 'utils/auth.php';
include_once 'utils/functions.php';
include_once 'utils/error-handler.php';
include_once 'utils/notif-ipn.php';
include_once 'utils/curl.php';
include_once 'utils/ticket.php';

// Restreindre l'accès à l'IPN par IP (cf config/e-transactions.php)
$CLIENT_IP = $_SERVER['REMOTE_ADDR'];

if ( in_array($CLIENT_IP, $serveur_etransactions_ip) ) {
  http_response_code(200);
} else {
  http_response_code(403);
  sendNotifIPN('FILTER_IP');
  echo 'Vous n\'avez pas les autorisations pour accéder à cette page.<br>';
  echo 'Votre adresse IP publique nous sera communiquée: <span style="color: red;">'.$CLIENT_IP.'</span><br><br>';
  echo 'Si vous avez été invité à visiter cette page, merci de signaler auprès du Centre de Pathologie des Haut de France la personne vous ayant invitée à le faire.<br><br>';
  echo '<a href='.$client_url_server.'>'.'Aller sur www.anapath.fr</a><br><br>';
  customLog('WARNING: Accès IPN non autorisé !');
  die('<h1 style="color: red;">403 - Forbidden - You don\'t have permission to access this file.</h1>');
}

// Paiement en attente: error 99999, autorisation != 0
// Paiement effectué: error 00000, autorisation != 0
// Paiement refusé: error 001XX, autorisation = 0
// Paiement annulé: la transaction n'est pas engagé, donc cette page n'est pas appelé (cf doc IPN)

// Vérification RSA de la requête - Securité !
$IS_AUTH_REQUEST = IsAuthRequest('pbx');

$response = array();

if ( $IS_AUTH_REQUEST === 1 ) {
  // Envoie de la requete sur l'API
  if ( isset($_GET[$client_prv_email]) && isset($_GET[$client_prv_ddn]) && isset($_GET[$client_pbx_montant]) && isset($_GET[$client_pbx_ref]) ) {
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
    $response['action'] = 'update_invoice';
    $response['app'] = 'anapath';
    $response['ticket'] = cryptTicket($_GET[$client_pbx_ref]);

    $response_json = json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    // Info pour debugging
    // on force false si env = prod car on doit rien renvoyer !
    if ($debug && $env_dev) {
      echo 'Requete format Json: '.$response_json.'\n';
    }

    // Send json data to API
    try {
      // return true si pas d'erreur et status === 200
      $result = curl_post($client_url_api, $response_json);

      if ( $result ) {
        // Tout est OK
        sendNotifIPN('AUTH_OK', $response_json);
        customLog('Data envoyée à l\'API !');
      } else {
        // pas d'erreur de transfert mais status <> 200
        // (variables manquantes ou érronés, pas d'entrée trouvée dans la BDD etc ...)
        sendNotifIPN('ERR_RETOUR', $response_json);
        customLog('Erreur status <> 200 en retour API : '.$result);
      }
    } catch( Exception $e ) {
      // erreur de transfert / communication avec API SOTRAIG
      sendNotifIPN('ERR_CURL', $e);
      customLog('Problème CURL : '.$e);
    }
  } else {
    // EMAIL ou DDN ou REF ou MONTANT non présent
    // il faut donc absolument vérifier les LOG sur votre interface e-transactions !
    // Send mail
    sendNotifIPN('QUERY_FAIL');
    // Log the error
    customLog('Variables manquantes dans la query string.');
  }
} else if ( $IS_AUTH_REQUEST === 0 ) {
  // Variables modifiées ou pubkey changée ou message ne venant pas directement de e-transactions
  // Send mail
  sendNotifIPN('AUTH_FAIL');
  // Log the error
  customLog('Query string non signée.');
} else {
  // Problème interne de décodage
  // Send mail
  sendNotifIPN('CRITIQUE');
  // Log the error
  customLog('Problème interne de décodage signature.');
}
?>
