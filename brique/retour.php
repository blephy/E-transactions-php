<?php
include 'utils/functions.php';


if ( PbxVerSign( $_SERVER['QUERY_STRING'], 'pubkey.pem', 'all' ) === 1 ) {            // Les valeurs sont identiques et provient bien de son destinataire
  echo 'cool';
} else if ( PbxVerSign( $_SERVER['QUERY_STRING'], 'pubkey.pem', 'all' ) === 0 ) {     // Les valeurs ont été modifié ou provient du mauvais destinataire !
  echo 'fuck';
} else {                                   // Erreur interne, problème de décryptage ? clé public changé ?
  echo 'WTFFFFF ????????????';
}

if ( PbxVerSign( $_SERVER['QUERY_STRING'], 'pubkey.pem', 'pbx' ) === 1 ) {            // Les valeurs sont identiques et provient bien de son destinataire
  echo 'cool';
} else if ( PbxVerSign( $_SERVER['QUERY_STRING'], 'pubkey.pem', 'pbx' ) === 0 ) {     // Les valeurs ont été modifié ou provient du mauvais destinataire !
  echo 'fuck';
} else {                                   // Erreur interne, problème de décryptage ? clé public changé ?
  echo 'WTFFFFF ????????????';
}
?>
