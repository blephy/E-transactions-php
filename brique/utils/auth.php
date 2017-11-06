<?php
function LoadKey( $keyfile, $pub=true, $pass='' ) {         // chargement de la clé (publique par défaut)
  $fp = $filedata = $key = FALSE;                         // initialisation variables
  $fsize =  filesize( $keyfile );                         // taille du fichier
  if( !$fsize ) return FALSE;                             // si erreur on quitte de suite
  $fp = fopen( $keyfile, 'r' );                           // ouverture fichier
  if( !$fp ) return FALSE;                                // si erreur ouverture on quitte
  $filedata = fread( $fp, $fsize );                       // lecture contenu fichier
  fclose( $fp );                                          // fermeture fichier
  if( !$filedata ) return FALSE;                          // si erreur lecture, on quitte
  if( $pub )
  $key = openssl_pkey_get_public( $filedata );            // recuperation de la cle publique
  else                                                    // ou recuperation de la cle privee
  $key = openssl_pkey_get_private( array( $filedata, $pass ));

  return $key;                                            // renvoi cle ( ou erreur )
}

function GetAllData( $qrystr, &$data ) {                  // retourne toutes la chaine query string
  global $client_pbx_sign;
  $pos_last = strrpos( $qrystr, '&'.$client_pbx_sign );
  $data = substr( $qrystr, 0, $pos_last );
}

function GetOnlyDataPbx( $qrystr, &$data) {              // retourne seulement les variables e-transactions
  global $client_pbx_sign, $pbx_retour;                  // Définition des variables globales
  $pos_last = strrpos( $qrystr, '&'.$client_pbx_sign );
  $first_pbx_var = substr( $pbx_retour, 0, strpos( $pbx_retour, ':'));
  $pos = strpos( $qrystr, $first_pbx_var );
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
  if( !$key ) return -1;                                  // si erreur chargement cle penser à openssl_error_string() pour diagnostic openssl si erreur
  GetOnlySignature( $qrystr, $sig );
  switch ($deep) {
    case 'all':
      GetAllData( $qrystr, $data );
      break;
    case 'pbx':
      GetOnlyDataPbx( $qrystr, $data);
      break;
  }

  return openssl_verify( $data, $sig, $key );             // verification : 1 si valide, 0 si invalide, -1 si erreur
}

function IsAuthRequest($deep = 'all') { // $deep = 'all' ou 'pbx' (all pour vérifier toutes les données. pbx pour vérifier seulement les données propres à e-transactions). E-transactions précise que pour l'IPN, la vérification doit se faire uniquement sur les variables pbx, alors que pour les autres URL de retour sur l'ensemble des variables envoyées.
  $is_valid = PbxVerSign( $_SERVER['QUERY_STRING'], 'pubkey.pem', $deep);
  return $is_valid;
}
?>
