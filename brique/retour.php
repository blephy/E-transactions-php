<?php
include 'config/client.php';
include 'utils/auth.php';


if ( IsAuthRequest('pbx') ) {
  // Envoie de la requete sur l'API
  mail('dolle.allan@gmail.com','Auth OK',$_SERVER['QUERY_STRING']);
} else if (IsAuthRequest('pbx') === 0 ) {
  // Variables modifié ou pubkey changé ou message ne venant pas directement de e-transactions
  mail('dolle.allan@gmail.com','Auth FAIL',$_SERVER['QUERY_STRING']);
} else {
  // Problème interne de décodage
  mail('dolle.allan@gmail.com','Auth OK','oups');
}
?>
