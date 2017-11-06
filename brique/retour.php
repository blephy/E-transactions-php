<?php
include 'config/client.php';
include 'utils/auth.php';

$IS_AUTH_REQUEST = IsAuthRequest('pbx');
if ( $IS_AUTH_REQUEST ) {
  // Envoie de la requete sur l'API
  mail('dolle.allan@gmail.com','Auth OK',$_SERVER['QUERY_STRING']);
} else if ( $IS_AUTH_REQUEST === 0 ) {
  // Variables modifié ou pubkey changé ou message ne venant pas directement de e-transactions
  mail('dolle.allan@gmail.com','Auth FAIL',$_SERVER['QUERY_STRING']);
} else {
  // Problème interne de décodage
  mail('dolle.allan@gmail.com','Auth OK','oups');
}
?>
