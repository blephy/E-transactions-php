<?php
// Debug Mode
// Si true:
// - ajoute quelques echo de variables pour vérifier les données
// - enlève la redirection automatique codé en javascript
$debug = false;

// Force HTTPS et redirection codé en php
$force_https = false;

// Temps en millisecondes necessaire avant redirection automatique en JS
$redirect_time = 1500;

// Production ou Pre-prod (dev) environnement
// true = pre-prod environnement
// false = production environnement
// Changez par false lorsque tous vos tests sont passés
$env_dev = true;

// Traitement de la chaine montant pour conversion en centimes
// true = traiter la chaine montant
// false = ne pas traiter la chaine montant
$amount_processing = true;

// Protocole serveur client
$client_protocol = 'http://';

// URL du serveur client
$client_url_server = $client_protocol.'www.anapath.fr';

// Repertoire commun des fichiers .php de retour
$client_dir_php = '/test/brique';

// Repertoire contenant le fichier index.html de l'UI VueJs
$client_dir_ui_js = '/test';

// Nom des pages de communication dans le repertoire $client_dir_ui_js
$page_effectue = 'effectue.php';
$page_annule = 'annule.php';
$page_refuse = 'refuse.php';
$page_attente = 'attente.php';
$page_retour_ipn = 'retour.php';
$page_redirect = 'redirect-bank.php';

// URL des fichier .php de retour bancaire
$pbx_effectue = $client_url_server.$client_dir_php.'/'.$page_effectue;
$pbx_annule = $client_url_server.$client_dir_php.'/'.$page_annule;
$pbx_refuse = $client_url_server.$client_dir_php.'/'.$page_refuse;
$pbx_attente = $client_url_server.$client_dir_php.'/'.$page_attente;
$pbx_repondre_a = $client_url_server.$client_dir_php.'/'.$page_retour_ipn;

// Informations propre à l'abonnement e-transactions du client
$pbx_site = '1542364';
$pbx_rang = '01';
$pbx_identifiant = '651499961';

// Email de contact si problème lors de la transaction
$client_email = 'contact@anapath.fr';

// Variables demandées en retour à la banque (cf doc PBX_RETOUR)
$client_prv_ddn = 'DDN';
$client_prv_email = 'EMAIL';
$client_prv_error_trad = 'ERRORTRAD';
$client_pbx_montant = 'MONTANT';
$client_pbx_ref = 'REF';
$client_pbx_autorisation = 'AUTO';
$client_pbx_cb = 'CB';
$client_pbx_transaction = 'TRANSAC';
$client_pbx_error = 'ERRORCODE';
$client_pbx_sign = 'SIGN';
$client_pbx_date = 'DATE';
$client_pbx_heure = 'HEURE';
$client_pbx_type_paiement = 'TYPE';
$pbx_retour = $client_pbx_montant.':M;'.
              $client_pbx_ref.':R;'.
              $client_pbx_autorisation.':A;'.
              $client_pbx_cb.':j;'.
              $client_pbx_transaction.':S;'.
              $client_pbx_error.':E;'.
              $client_pbx_date.':W;'.
              $client_pbx_heure.':Q;'.
              $client_pbx_type_paiement.':P;'.
              $client_pbx_sign.':K';
?>
