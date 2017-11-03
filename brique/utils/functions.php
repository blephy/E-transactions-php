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
?>
