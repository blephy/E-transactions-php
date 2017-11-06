<?php
include 'config/client.php';
include 'utils/auth.php';


if ( IsAuthRequest('all') ) {
  // Envoie de la requete sur l'API
} else if (IsAuthRequest('all') === 0 ) {
  // Variables modifié ou pubkey changé ou message ne venant pas directement de e-transactions
} else {
  // Problème interne de décodage 
}
?>
