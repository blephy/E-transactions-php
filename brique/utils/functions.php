<?php
include_once 'config/client.php';
include_once 'utils/error-handler.php';
// Function de traitement de la chaine montant
// Renvoie le montant de la transaction convertit en centimes
// Retourne FALSE si le montant est strictement inférieur à 1€
function amountToCentimes( $montant_query) {
  global $debug;
  if ( $debug ) { echo 'Processing checking amount... '.$montant_query.'<br>'; }
  $temp = str_replace(",", ".", $montant_query); // replace , par .
  if ( $debug ) { echo 'Replace , par . : '.$temp.'<br>'; }
  $temp = floatval( $temp ); // convert to float
  if ( $debug ) { echo 'Convert to float: '.$temp.'<br>'; }
  $temp = round($temp, 2); // arrondi supérieur avec 2 décimales
  if ( $debug ) { echo 'Round 2 decimals: '.$temp.'<br>'; }
  $temp = $temp * 100;
  if ( $debug ) { echo 'Multiply by 100: '.$temp.'<br>'; }
  $temp = str_replace(".", "", $temp);
  if ( $debug ) { echo 'Replace . by nothing in case of: '.$temp.'<br>'; }
  if ($temp > 99) {
    return $temp; // Retourne le montant formatté si > 1€
  } else {
    return false;
  }
}

function convertDate($string, $insert) {
  if ($string) {
    $arr=str_split($string, 2);
    $day=array_slice($arr, 0, 1);
    $month=array_slice($arr, 1, 1);
    $year=array_slice($arr, 2, 2);

    return $day[0].$insert.$month[0].$insert.$year[0].$year[1];
  } else {
    return $string;
  }
}

function verifBeforePrintOut($query, $class = '') {
  global $debug,
         $client_pbx_montant,
         $client_pbx_ref,
         $client_prv_email,
         $client_prv_ddn,
         $client_pbx_cb,
         $client_pbx_type_paiement,
         $client_pbx_autorisation,
         $client_pbx_transaction,
         $client_pbx_date,
         $client_pbx_heure,
         $client_pbx_error;
  if ( isset($_GET[$query]) ) {
    $temp = $_GET[$query];
    switch ($query) {
      case $client_pbx_montant:
        $temp = $temp/100;
        return '<p class="'.$class.'">Montant de la transaction: '.$temp.'€</p>';
        break;
      case $client_pbx_ref:
        return '<p class="'.$class.'">Référence de la facture: '.$temp.'</p>';
        break;
      case $client_prv_email:
        return '<p class="'.$class.'">Email renseigné: '.$temp.'</p>';
        break;
      case $client_prv_ddn:
        return '<p class="'.$class.'">Date de naissance renseignée: '.$temp.'</p>';
        break;
      case $client_pbx_cb:
        return '<p class="'.$class.'">Numéro carte bancaire: XXXX XXXX XXXX '.$temp.'</p>';
        break;
      case $client_pbx_type_paiement:
        return '<p class="'.$class.'">Type de paiement choisi: '.$temp.'</p>';
        break;
      case $client_pbx_autorisation:
        return '<p class="'.$class.'">Numéro d\'autorisation bancaire: '.$temp.'</p>';
        break;
      case $client_pbx_transaction:
        return '<p class="'.$class.'">Numéro de transaction bancaire: '.$temp.'</p>';
        break;
      case $client_pbx_date:
        $temp = convertDate($temp, '/');
        return '<p class="'.$class.'">Date de l\'opération: '.$temp.'</p>';
        break;
      case $client_pbx_heure:
        return '<p class="'.$class.'">Heure de l\'opération: '.$temp.'</p>';
        break;
      case $client_pbx_error:
        $temp = errorHandler($temp);
        return '<p class="'.$class.'">Status de l\'opération: '.$temp.'</p>';
        break;
    }
  } else {
    if ($debug) { return $query.' est absent de la requète<br>';}
  }
}

function verifBeforeGetQuery($query) {
  if ( isset($_GET[$query]) ) {
    return $_GET[$query];
  } else {
    return null;
  }
}

function getUrlPath() {
  return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
}

function isPage($page) {
  return strpos(getUrlPath(), $page);
}

function sendNotifIPN($case, $message_json) {
  global $client_email_contact,
         $client_email_ipn,
         $client_email_ipn_from,
         $client_prv_email,
         $client_prv_ddn,
         $client_pbx_ref,
         $client_pbx_montant,
         $client_pbx_date,
         $client_pbx_heure,
         $client_pbx_type_paiement,
         $client_pbx_cb,
         $client_pbx_transaction,
         $client_pbx_error,
         $client_prv_error_trad,
         $client_pbx_autorisation;

 $new_line = " \r\n";
 $tabulation = "\t ";
 $date = date("r (T)");
 $ip = $_SERVER['REMOTE_ADDR'];
 $qs = $_SERVER['QUERY_STRING'];
 $headers = "From: Retour Bancaire IPN <".$client_email_ipn_from.">".$new_line.
            "Return-Path: ".$client_email_contact.$new_line.
            "Reply-To: ".$client_email_ipn_from.$new_line.
            "Date: ".$date.$new_line.
            "X-Mailer: PHP/".phpversion();

  switch ($case) {
    case 'AUTH_OK':
      $sujet = '-> Requète autorisée, transaction signée.';
      $message_obj = json_decode($message_json);
      $message = "Une nouvelle transaction signée et autorisée vient de parvenir:".$new_line.$new_line.
                 "---------------------------------------------------------------------------".$new_line.
                 "Email client: ".$message_obj->$client_prv_email.$new_line.
                 "Date de naissance: ".$message_obj->$client_prv_ddn.$new_line.
                 "Référence facture: ".$message_obj->$client_pbx_ref.$new_line.
                 "Montant facture: ".$message_obj->$client_pbx_montant." €".$new_line.
                 "Date transaction: ".$message_obj->$client_pbx_date.$new_line.
                 "Heure transaction: ".$message_obj->$client_pbx_heure.$new_line.
                 "Type de paiement: ".$message_obj->$client_pbx_type_paiement.$new_line.
                 "4 derniers chiffres CB: ".$message_obj->$client_pbx_cb.$new_line.
                 "Numéro de transaction: ".$message_obj->$client_pbx_transaction.$new_line.
                 "Code retour: ".$message_obj->$client_pbx_error.$new_line.
                 "Traduction code retour: ".$message_obj->$client_prv_error_trad.$new_line.
                 "Numéro d'autorisation bancaire: ".$message_obj->$client_pbx_autorisation.$new_line.
                 "IP du server appelant: ".$ip.$new_line.$new_line.
                 "---------------------------------------------------------------------------".$new_line.
                 "Informations utiles pour la compréhension:".$new_line.
                 $tabulation."- Cas d'un paiement effectué:".$new_line.
                 $tabulation.$tabulation."- Le code retour doit avoir la valeur 00000".$new_line.
                 $tabulation.$tabulation."- Le numéro d'autorisation bancaire doit être différent de 0 ou null".$new_line.
                 $tabulation."- Cas d'un paiement en attente (paypal):".$new_line.
                 $tabulation.$tabulation."- Le code retour doit avoir la valeur 99999".$new_line.
                 $tabulation.$tabulation."- Le numéro d'autorisation bancaire doit être différent de 0 ou null".$new_line.
                 $tabulation."- Cas d'un paiement refusé:".$new_line.
                 $tabulation.$tabulation."- Le code retour sera différent de 00000 ou de 99999".$new_line.
                 $tabulation.$tabulation."- Le numéro d'autorisation bancaire vaut 0 ou null".$new_line.
                 $tabulation."- Transaction de TEST (pré-production): le numéro d'autorisation sera toujours XXXXXX";
      break;
    case 'QUERY_FAIL':
      $sujet = "!! LISEZ !! Un problème sérieux vient d'être détecté";
      $message = "Un problème nécessitant des investigations vient d'arriver:".$new_line.$new_line.
                 "La transaction a été envoyée par l'IP autorisée suivante: ".$ip.$new_line.
                 "La signature de la requète est bien signée, mais il manque des variables:".$new_line.
                 $tabulation."- Soit le montant de la transaction".$new_line.
                 $tabulation."- Soit la référence de la transaction".$new_line.
                 $tabulation."- Soit la date de naissance".$new_line.
                 $tabulation."- Soit l'adresse email du patient".$new_line.$new_line.
                 "Ce qui n'est pas normal, car une requète signée ne peux théoriquement pas".$new_line.
                 "ne pas contenir toutes les variables.".$new_line.$newline.
                 "Merci d'en informer votre responsable informatique: ".$client_email_ipn.$new_line.
                 "et de lui fournir cette information supplémentaire (query string):".$new_line.
                 $qs;
      break;
    case 'AUTH_FAIL':
      $sujet = "!! URGENT !! ";
      $message = "Le server appelant ".$ip." a été autorisé avec succès mais la signature".$new_line.
                 "de la requète n'est pas authentifiée !".$new_line.$new_line.
                 "Ceci est forcément du à un changement de la clé publique d'e-transactions".$new_line.
                 "ou alors d'un problème d'e-transaction dans l'envoie des données.".$new_line.$new_line.
                 "Appelez e-transactions au 0810 812 810 pour leur faire part de l'erreur.".$new_line.
                 "Avertissez votre responsable informatique car une transaction client acceptée".$new_line.
                 "par la banque n'a peut-être pas pu être enregistrée sur vos server locaux.".$new_line.$new_line.
                 "Merci d'en informer votre responsable informatique: ".$client_email_ipn.$new_line.
                 "et de lui fournir cette information supplémentaire (query string):".$new_line.
                 $qs;
      break;
    case 'CRITIQUE':
      $sujet = "!! CRITIQUE !! Problème interne de décodage signature";
      $message = "Le server appelant ".$ip." a été autorisé avec succès mais la signature".$new_line.
                 "de la requète n'a pas pu être vérifié en raison d'un problème interne !".$new_line.$new_line.
                 "Cela peut-être du à un problème de votre hébergeur, un problème unique et temporaire".$new_line.
                 "de surcharge du server ou encore d'une dépendance PHP défaillante.".$new_line.$new_line.
                 "Merci d'en informer votre responsable informatique: ".$client_email_ipn.$new_line.
                 "et de lui fournir cette information supplémentaire (query string):".$new_line.
                 $qs;
      break;
    case 'FILTER_IP':
      $sujet = "!! FRAUDE !! Changement IP e-transactions ou fraude potentielle";
      $message = "Le server appelant ".$ip." a essayé de communiquer avec vos serveurs".$new_line.
                 "mais il ne fait pas partie des IP restreintes d'e-transactions.".$new_line.$new_line.
                 "Soit les serveurs d'e-transactions ont de nouvelles IP donc il faut".$new_line.
                 "mettre à jour le code source.".$new_line.
                 "Appelez e-transactions au 0810 812 810 pour leur demander si c'est le cas.".$new_line.$new_line.
                 "Soit il s'agit d'une tentative de fraude: ".$new_line.
                 "Dans ce cas merci d'en informer votre responsable informatique: ".$client_email_ipn.$new_line.
                 "et de lui fournir cette information supplémentaire (query string):".$new_line.
                 $qs;
      break;
  }
  return mail($client_email_ipn, $sujet, $message, $headers);
}
?>
