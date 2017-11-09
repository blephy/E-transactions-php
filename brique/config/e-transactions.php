<?php
// Variables propres au serveur E-transactions
$server_protocol = 'https://';
$server_preprod = 'preprod-tpeweb.e-transactions.fr';
$server_prod = 'tpeweb.e-transactions.fr';

// Changer par votre choix, cf doc
$server_file_desktop = '/php/';
$server_file_mobile = '/cgi/ChoixPaiementMobile.cgi';

// IP des serveurs e-transactions
// Permet de limiter l'appel de ipn.php à e-transactions
$serveur_ip = array(
  '194.2.122.158',
  '194.2.122.190',
  '195.101.99.76',
  '195.25.67.22',
  '195.25.7.166'
);
?>
