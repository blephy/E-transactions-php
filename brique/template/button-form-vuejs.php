<?php
include_once 'config/client.php';
include_once 'utils/functions.php';
?>
<button onclick="window.location.href = '<?php echo $client_url_server.$client_dir_ui_js ?>';"><?php
if ( isPage($page_attente) && $IS_AUTH_REQUEST || isPage($page_effectue) && $IS_AUTH_REQUEST ) {
  echo 'Régler une autre facture';
} else {
  echo 'Retour au formulaire';
}
?></button>
