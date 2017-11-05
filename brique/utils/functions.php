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
  $arr=str_split($string, 2);
  $day=array_slice($arr, 0, 1);
  $month=array_slice($arr, 1, 1);
  $year=array_slice($arr, 2, 2);

  return $day[0].$insert.$month[0].$insert.$year[0].$year[1];
}

function LoadKey( $keyfile, $pub=true, $pass='' ) {         // chargement de la cl� (publique par d�faut)
  $fp = $filedata = $key = FALSE;                         // initialisation variables
  $fsize =  filesize( $keyfile );                         // taille du fichier
  if( !$fsize ) return FALSE;                             // si erreur on quitte de suite
  $fp = fopen( $keyfile, 'r' );                           // ouverture fichier
  if( !$fp ) return FALSE;                                // si erreur ouverture on quitte
  $filedata = fread( $fp, $fsize );                       // lecture contenu fichier
  fclose( $fp );                                          // fermeture fichier
  if( !$filedata ) return FALSE;                          // si erreur lecture, on quitte
  if( $pub )
  $key = openssl_pkey_get_public( $filedata );        // recuperation de la cle publique
  else                                                    // ou recuperation de la cle privee
  $key = openssl_pkey_get_private( array( $filedata, $pass ));

  return $key;                                            // renvoi cle ( ou erreur )
}

function GetAllData( $qrystr, &$data ) {
  $pos = strrpos( $qrystr, '&' );
  $data = substr( $qrystr, 0, $pos );
}

function GetOnlyDataPbx( $qrystr, &$data ) {
  $pos_last = strrpos( $qrystr, '&SIGN' );
  $pos = strpos( $qrystr, 'DDN' );
  $pos = strpos( $qrystr, '&', $pos ) + 1;
  $data = substr( $qrystr, $pos, $pos_last-$pos );
}

function GetOnlySignature( $qrystr, &$sig ) {          // renvoi les donnes signees et la signature
  $pos = strrpos( $qrystr, '&' );                         // cherche dernier separateur
  $pos = strpos( $qrystr, '=', $pos ) + 1;                 // cherche debut valeur signature
  $sig = substr( $qrystr, $pos );                         // et voila la signature
  $sig = base64_decode( urldecode( $sig ));               // decodage signature
}

function PbxVerSign( $qrystr, $keyfile, $deep ) {                  // verification signature Paybox
  $key = LoadKey( $keyfile );                             // chargement de la cle
  if( !$key ) return -1;                                  // si erreur chargement cle
  //  penser � openssl_error_string() pour diagnostic openssl si erreur
  GetOnlySignature( $qrystr, $sig );
  switch ($deep) {
    case 'all':
      GetAllData( $qrystr, $data );
      break;
    case 'pbx':
      GetOnlyDataPbx( $qrystr, $data );
      break;
  }

  return openssl_verify( $data, $sig, $key );             // verification : 1 si valide, 0 si invalide, -1 si erreur
}

function IsAuthRequest() {
  $is_all_valid = PbxVerSign( $_SERVER['QUERY_STRING'], 'pubkey.pem', 'all');
  $is_pbx_valid = PbxVerSign( $_SERVER['QUERY_STRING'], 'pubkey.pem', 'pbx');
  if ( $is_all_valid || $is_pbx_valid ) {
    return 1;
  } else {
    $error = $is_all_valid < $is_pbx_valid ? $is_pbx_valid : $is_all_valid;
    return $error;
  }
}
?>
