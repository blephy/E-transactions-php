<?php
// Function de traitement de la chaine montant
// Renvoie le montant de la transaction convertit en centimes
// Retourne FALSE si le montant est strictement inférieur à 1€
function checkAmount( $montant_query, $is_debug ) {
  if ( $is_debug ) { echo 'Processing checking amount... '.$montant_query.'<br>'; }
  $temp = str_replace(",", ".", $montant_query); // replace , par .
  if ( $is_debug ) { echo 'Replace , par . : '.$temp.'<br>'; }
  $temp = floatval( $temp ); // convert to float
  if ( $is_debug ) { echo 'Convert to float: '.$temp.'<br>'; }
  $temp = round($temp, 2); // arrondi supérieur avec 2 décimales
  if ( $is_debug ) { echo 'Round 2 decimals: '.$temp.'<br>'; }
  $temp = $temp * 100;
  if ( $is_debug ) { echo 'Multiply by 100: '.$temp.'<br>'; }
  $temp = str_replace(".", "", $temp);
  if ( $is_debug ) { echo 'Replace . by nothing in case of: '.$temp.'<br>'; }
  if ( $temp > 99 ) {
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
?>
