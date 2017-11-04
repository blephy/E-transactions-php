<?php
include 'config/client.php';
include 'config/e-transactions.php';
include 'utils/functions.php';
include 'config/hmac.php';

// Force HTTPS only if force_https = true (cf config/client.php)
if ( $force_https ) { include 'utils/force-https.php'; }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Redirection vers l'espace de paiement bancaire | Centre de Pathologie</title>
	<meta name="description" content="Page intermédiaire de redirection vers l'espace de paiement bancaire, afin de régler votre note d'honoraire">
	<meta name="robots" content="noindex, nofollow, noodp">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<?php include 'assets/style.php'; ?>
<body>
<?php
	// Si toutes les variables necessaires existent
	if ( isset($_GET['ref']) && isset($_GET['porteur']) && isset($_GET['montant']) ) {
		$pbx_cmd = $_GET['ref'];
		$pbx_porteur = $_GET['porteur'];
		// Traiement de la chaine montant en centimes, peut être désactivé (config/client.php)
		$pbx_total = $amount_processing ? checkAmount($_GET['montant'], $debug) : $_GET['montant'];

		// Si on est en mode debug (config/client.php), afficher les variables
		if ($debug) {
			echo 'Reference: '.$pbx_cmd.'<br>';
			echo 'Porteur: '.$pbx_porteur.'<br>';
			echo 'Montant: '.$pbx_total.' centimes d\'euro<br>';
		}

		// Si le montant n'est pas null ou false (cf checkAmount)
		if ($pbx_total) {

			// Choix de la clé HMAC en fonction de l'environnement
			$key_hmac = $env_dev ? $key_dev : $key_prod;

			// Choix du serveur e-transactions en fonction de l'environnement
			$env_server = $env_dev ? $server_preprod : $server_prod;
			$server_etransactions = $server_protocol.$env_server.$server_file;

			// Construction de l'URI et du formulaire POST pour redirection sur la banque
			$dateTime = date("c");
			$msg = "PBX_SITE=".$pbx_site.
			"&PBX_RANG=".$pbx_rang.
			"&PBX_IDENTIFIANT=".$pbx_identifiant.
			"&PBX_TOTAL=".$pbx_total.
			"&PBX_DEVISE=978".
			"&PBX_CMD=".$pbx_cmd.
			"&PBX_PORTEUR=".$pbx_porteur.
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
	<div class="entete">
		<h1>Redirection en cours ...</h1>
	</div>
	<span class="loading"></span>
	<div class="info">
		<p>Vous allez automatiquement être redirigé sur le siteweb sécurisé de notre banque.</p>
		<p>Cliquez sur <strong>Réessayer</strong> en cas de non redirection automatique après <?php echo ($redirect_time/1000)+7 ?> secondes:</p>
	</div>
	<form id="form" style="text-align: center; margin: 20px auto;" method="POST" action="<?php echo $server_etransactions; ?>">
		<input type="hidden" name="PBX_SITE" value="<?php echo $pbx_site; ?>">
		<input type="hidden" name="PBX_RANG" value="<?php echo $pbx_rang; ?>">
		<input type="hidden" name="PBX_IDENTIFIANT" value="<?php echo $pbx_identifiant; ?>">
		<input type="hidden" name="PBX_TOTAL" value="<?php echo $pbx_total; ?>">
		<input type="hidden" name="PBX_DEVISE" value="978">
		<input type="hidden" name="PBX_CMD" value="<?php echo $pbx_cmd; ?>">
		<input type="hidden" name="PBX_PORTEUR" value="<?php echo $pbx_porteur; ?>">
		<input type="hidden" name="PBX_REPONDRE_A" value="<?php echo $pbx_repondre_a; ?>">
		<input type="hidden" name="PBX_RETOUR" value="<?php echo $pbx_retour; ?>">
		<input type="hidden" name="PBX_EFFECTUE" value="<?php echo $pbx_effectue; ?>">
		<input type="hidden" name="PBX_ANNULE" value="<?php echo $pbx_annule; ?>">
		<input type="hidden" name="PBX_REFUSE" value="<?php echo $pbx_refuse; ?>">
		<input type="hidden" name="PBX_HASH" value="SHA512">
		<input type="hidden" name="PBX_TIME" value="<?php echo $dateTime; ?>">
		<input type="hidden" name="PBX_HMAC" value="<?php echo $hmac; ?>">
		<input type="submit" value="Réessayer">
	</form>
	    <?php if (!$debug) { include 'assets/auto-redirect.js.php';} } else { ?>
	<div class="entete">
		<h1>Erreur de montant</h1>
	</div>
	<div class="info">
		<p class="alert">Le montant est inférieur à 1€ après conversion en centimes d'euro. Transaction impossible.</p>
		<p class="alert">Si votre facture était de plus de 1€ à l'écran précédent, merci de contacter votre Centre de Pathologie sur <a href="mailto:<?php echo $client_email; ?>" title="Envoyer un e-mail au Centre de Pathologie des Hauts de France"><?php echo $client_email; ?></a> afin de signaler ce bug de développement informatique lié à la conversion du montant en centimes d'euro.</p>
		<button onclick="window.location.href = '<?php echo $client_url_server.$client_dir_ui_js ?>';">Retour</button>
	</div>
	<?php }	?>
	<?php } else { ?>
	<div class="entete">
		<h1>Problème du formulaire</h1>
	</div>
	<div class="info">
		<p class="alert">Des variables sont manquantes ou erronées.</p>
		<p class="alert">Merci de contacter votre Centre de Pathologie pour signaler ce problème ou sur <a href="mailto:<?php echo $client_email; ?>" title="Envoyer un e-mail au Centre de Pathologie des Hauts de France"><?php echo $client_email; ?></a></p>
		<button onclick="window.location.href = '<?php echo $client_url_server.$client_dir_ui_js ?>';">Retour</button>
	</div>
	<?php } ?>
</body>
</html>
