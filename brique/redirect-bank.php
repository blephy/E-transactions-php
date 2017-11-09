<?php
include_once 'config/client.php';
include_once 'utils/functions.php';

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
	<link rel="icon" type="image/png" href="<?php echo $client_dir_ui_js ?>/static/favicon-anapath-amiens.png" />
</head>
<?php include 'assets/style.css.php'; ?>
<body>
<?php
	// Si toutes les variables necessaires existent
	if ( isset($_GET[$client_pbx_ref]) && isset($_GET[$client_prv_email]) && isset($_GET[$client_prv_ddn]) && isset($_GET[$client_pbx_montant]) ) {
	?>
		<div class="entete">
			<img src="<?php echo $client_file_logo ?>" alt="Logo Laboratoire Anapathologie Amiens">
			<h1>Redirection en cours ...</h1>
		</div>
		<div class="info">
			<p>Vous allez automatiquement être redirigé sur le siteweb sécurisé de notre banque.</p>
			<p>Cliquez sur <strong>Réessayer</strong> en cas de non redirection automatique après <?php echo ($redirect_time/1000)+7; ?> secondes:</p>
		</div>
		<span class="loading"></span>
		<?php include 'template/button-form-bank.php'; ?>
	<?php
	} else { // Il manque des variables importantes et nécessaires
 			include 'template/query-missing.php';
	}
	?>
</body>
</html>
