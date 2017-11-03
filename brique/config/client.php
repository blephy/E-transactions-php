<?php
// Debug Mode
$debug = true;

// Temps en millisecondes necessaire avant redirection automatique en JS
$redirect_time = 2000;

// Production ou Preprod (dev) environnement
// true = pre-prod environnement
// false = production environnement
// Changez par false lorsque tous vos tests sont passés
$env_dev = true;

// Traitement de la chaine montant pour conversion en centimes
// true = traiter la chaine montant
// false = ne pas traiter la chaine montant
$amount_processing = true;

// URL du serveur client
$url_server = 'http://www.anapath.fr/';

// Repertoire commun des fichiers .php de retour
$dir_paiement = 'test/brique/';

// URL des fichier .php de retour bancaire
$pbx_effectue = $url_server.$dir_paiement.'accepte.php';
$pbx_annule = $url_server.$dir_paiement.'annule.php';
$pbx_refuse = $url_server.$dir_paiement.'refuse.php';
$pbx_attente = $url_server.$dir_paiement.'attente.php';
$pbx_repondre_a = $url_server.$dir_paiement.'retour.php';

// Variables demandées en retour à la banque (cf doc)
$client_pbx_montant = 'MONTANT';
$client_pbx_ref = 'REF';
$client_pbx_autorisation = 'AUTO';
$client_pbx_cb = 'CB';
$client_pbx_transaction = 'TRANSAC';
$client_pbx_error = 'ERROR';
$client_pbx_sign = 'SIGN';
$client_pbx_date = 'DATE';
$pbx_retour = $client_pbx_montant.':M;'.
              $client_pbx_ref.':R;'.
              $client_pbx_autorisation.':A;'.
              $client_pbx_cb.':j;'.
              $client_pbx_transaction.':S;'.
              $client_pbx_error.':E;'.
              $client_pbx_date.':W;'.
              $client_pbx_sign.':K';
?>
