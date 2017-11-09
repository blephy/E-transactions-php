<?php
$pbx_cmd = $_GET[$client_pbx_ref];
$prv_query_email = $_GET[$client_prv_email];
$prv_query_ddn = $_GET[$client_prv_ddn];

// Requetes à ajouter
$prv_query = '?'.$client_prv_email.'='.
             urlencode($prv_query_email).'&'.
             $client_prv_ddn.'='.
             urlencode($prv_query_ddn);
// ajout des requetes perso pour la reponse e-transactions
$pbx_annule .= $prv_query;
$pbx_attente .= $prv_query;
$pbx_effectue .= $prv_query;
$pbx_refuse .= $prv_query;
$pbx_repondre_a .= $prv_query;

// Traiement de la chaine montant en centimes, peut être désactivé (config/client.php)
$pbx_total = $amount_processing && isPage($page_redirect) ? checkAmount($_GET[$client_pbx_montant]) : $_GET[$client_pbx_montant];

// Si on est en mode debug (config/client.php), afficher les variables
if ($debug) {
  echo 'Reference: '.$pbx_cmd.'<br>';
  echo 'Email: '.$prv_query_email.'<br>';
  echo 'Date de naissance: '.$prv_query_ddn.'<br>';
  echo 'Montant: '.$pbx_total.' centimes d\'euro<br>';
}

  // Choix de la clé HMAC en fonction de l'environnement
  $key_hmac = $env_dev ? $key_dev : $key_prod;

  // Choix du serveur e-transactions en fonction de l'environnement
  $env_server = $env_dev ? $server_preprod : $server_prod;

  // Choix de l'url de redirection si mobile ou desktop (pour responssivité)
  $detect = new Mobile_Detect;
  if ($debug) { echo 'Détection mobile ou tablet: '.$detect->isMobile(); }
  $server_file = $detect->isMobile() ? $server_file_mobile : $server_file_desktop;

  // Construction de l'url à appeler
  $server_etransactions = $server_protocol.$env_server.$server_file;

  // Construction de l'URI et du formulaire POST pour redirection sur la banque
  $dateTime = date("c");
  $msg = "PBX_SITE=".$pbx_site.
  "&PBX_RANG=".$pbx_rang.
  "&PBX_IDENTIFIANT=".$pbx_identifiant.
  "&PBX_TOTAL=".$pbx_total.
  "&PBX_DEVISE=978".
  "&PBX_CMD=".$pbx_cmd.
  "&PBX_PORTEUR=".$prv_query_email.
  "&PBX_REPONDRE_A=".$pbx_repondre_a.
  "&PBX_RETOUR=".$pbx_retour.
  "&PBX_EFFECTUE=".$pbx_effectue.
  "&PBX_ANNULE=".$pbx_annule.
  "&PBX_REFUSE=".$pbx_refuse.
  "&PBX_HASH=SHA512".
  "&PBX_TIME=".$dateTime;
  $binKey = pack("H*", $key_hmac);
  $hmac = strtoupper(hash_hmac('sha512', $msg, $binKey));
  ?>
<form id="form" class="<?php if ( !isPage($page_redirect) ) { echo 'inline'; } ?>" method="POST" action="<?php echo $server_etransactions; ?>">
<input type="hidden" name="PBX_SITE" value="<?php echo $pbx_site; ?>">
<input type="hidden" name="PBX_RANG" value="<?php echo $pbx_rang; ?>">
<input type="hidden" name="PBX_IDENTIFIANT" value="<?php echo $pbx_identifiant; ?>">
<input type="hidden" name="PBX_TOTAL" value="<?php echo $pbx_total; ?>">
<input type="hidden" name="PBX_DEVISE" value="978">
<input type="hidden" name="PBX_CMD" value="<?php echo $pbx_cmd; ?>">
<input type="hidden" name="PBX_PORTEUR" value="<?php echo $prv_query_email; ?>">
<input type="hidden" name="PBX_REPONDRE_A" value="<?php echo $pbx_repondre_a; ?>">
<input type="hidden" name="PBX_RETOUR" value="<?php echo $pbx_retour; ?>">
<input type="hidden" name="PBX_EFFECTUE" value="<?php echo $pbx_effectue; ?>">
<input type="hidden" name="PBX_ANNULE" value="<?php echo $pbx_annule; ?>">
<input type="hidden" name="PBX_REFUSE" value="<?php echo $pbx_refuse; ?>">
<input type="hidden" name="PBX_HASH" value="SHA512">
<input type="hidden" name="PBX_TIME" value="<?php echo $dateTime; ?>">
<input type="hidden" name="PBX_HMAC" value="<?php echo $hmac; ?>">
<input type="submit" value="<?php
  if ( isPage($page_redirect) ) {
    echo 'Réessayer';
  } else {
    echo 'Retour au paiement';
  }
?>">
</form>
<?php if (!$debug && isPage($page_redirect)) { include 'assets/auto-redirect.js.php';} ?>
