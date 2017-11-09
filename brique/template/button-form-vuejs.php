<button onclick="window.location.href = '<?php echo $client_url_server.$client_dir_ui_js ?>';"><?php
if ( isPage($page_attente) || isPage($page_effectue) && $IS_AUTH_REQUEST ) {
  echo 'Trouver une autre facture';
} else {
  echo 'Retour au formulaire';
}
?></button>
