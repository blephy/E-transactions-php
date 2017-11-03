<!DOCTYPE html>
<html>
<head>
	<title>Redirection vers l'espace de paiement bancaire | Centre de Pathologie</title>
	<meta name="description" content="Page intermédiaire de redirection vers l'espace de paiement bancaire, afin de régler votre note d'honoraire">
	<meta name="robots" content="noindex, nofollow, noodp">
	<meta charset="utf-8">
</head>
<style>
html {
	font-size: 100%;
	font-family: 'Source Sans Pro', sans-serif;
}
body {
	background-color: #cccccc;
	color: #646464;
	font-size: 16px;
	font-size: 1rem;
	position: relative;
	width: 100%;
	min-height: 100vh;
	margin: 0;
	padding: 0;
}
.entete {
	text-align: center;
	box-sizing: border-box;
	padding: 10px;
}
h1 {
	margin: 20px 0;
	color: #383a6d;
	font-weight: bolder;
	text-transform: uppercase;
	letter-spacing: 1.5px;
	word-spacing: 7px;
}
.info {
	display: block;
	box-sizing: border-box;
	padding: 10px;
	font-size: 1.1rem;
	line-height: 30px;
	text-align: center;
}
p {
	box-sizing: border-box;
	width: 90%;
	margin: auto;
	padding: 10px;
	background-color: rgba(20, 150, 150, 0.3);
	border-radius: 5px;
	letter-spacing: 1.5px;
}
.alert {
	background-color: rgba(208, 129, 0, 0.3);
	margin-bottom: 10px;
}
@keyframes load {
	from {
		transform: scale(0.8);
	}

	to {
		transform: scale(1.3);
	}
}
span.loading {
	display: block;
	width: 50px;
	height: 50px;
	background-color: transparent;
	border: 4px green solid;
	border-radius: 50%;
	margin: 50px auto 50px auto;
	animation: load 0.6s infinite alternate;
}
input[type="submit"], button {
	cursor: pointer;
	background-color: #4CADC9;
	text-transform: uppercase;
	height: 50px;
	border: none;
	line-height: 50px;
	border-radius: 0;
	padding: 0 10px;
	box-sizing: border-box;
	font-size: 1.3rem;
	transition: all 0.3s ease-out;
	font-family: 'Source Sans Pro', sans-serif;
	line-height: 40px;
	box-shadow: 0px 0px 7px 2px rgba(0, 255, 255, 0.2);
}

input[type="submit"]:hover, button:hover {
	box-shadow: 0px 0px 15px 5px rgba(76,173,201,0.20);
}
a {
	text-decoration: none;
	color: inherit;
	font-weight: bold;
}
a:hover {

}
</style>
<body>
	<?php
	// Production ou preprod (dev)
	$env_dev = true;

	// Variables propre au client E-transactions
	$pbx_site = '1542364';
	$pbx_rang = '01';
	$pbx_identifiant = '651499961';

	// Variables de transaction client
	if ( isset($_GET['ref']) && isset($_GET['porteur']) && isset($_GET['montant']) ) {
		$pbx_cmd = $_GET['ref'];
		$pbx_porteur = $_GET['porteur'];
		$pbx_total = $_GET['montant'];

		// Suppression des points ou virgules dans le montant
		$pbx_total = str_replace(",", "", $pbx_total);
		$pbx_total = str_replace(".", "", $pbx_total);

		// URL de retour serveur
		$url_server = 'http://www.anapath.fr/';
		$dir_paiement = 'test/brique/';

		// Détails URL de redirection après paiement
		$pbx_effectue = $url_server.$dir_paiement.'accepte.php';
		$pbx_annule = $url_server.$dir_paiement.'annule.php';
		$pbx_refuse = $url_server.$dir_paiement.'refuse.php';
		$pbx_attente = $url_server.$dir_paiement.'attente.php';
		$pbx_repondre_a = $url_server.$dir_paiement.'retour.php';
		$pbx_retour = 'MONTANT:M;REF:R;AUTO:A;CB:J;TRANSAC:S;ERROR:E;SIGN:K';

		$key_prod = '00a13882045cc2f316e021ba1970b4159909339d28aca1be00f70366c63e76c9681a7d28d7c09e767406b8dbfdabb03abe92c6474237a76b6076ae7bc63eacf9';
		$key_dev = '05fc02827bc38bcbcf4c07e32d91ddb98b412fdd53ef1a0e759484bbc57c7acbc27ce0836fd6c6a3140ab93a1f4646e1de2ff35cbe2798f971a19bd4bb201662';

		// Choix de la clé HMAC en fonction de l'environnement
		$key_hmac = $env_dev ? $key_dev : $key_prod;

		$server_preprod = 'preprod-tpeweb.e-transactions.fr';
		$server_prod = 'tpeweb.e-transactions.fr';

		// Choix du serveur e-transactions en fonction de l'environnement
		$env_server = $env_dev ? $server_preprod : $server_prod;

		$server_etransactions = 'https://'.$env_server.'/cgi/MYchoix_pagepaiement.cgi';



		// --------------- TRAITEMENT DES VARIABLES ---------------

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
			<p>Cliquez sur <strong>Réessayer</strong> en cas de non redirection automatique après 2 secondes:</p>
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
	</body>
	<script>
	window.onload=function(){
		var auto = setTimeout(function(){ autoRefresh(); }, 100);

		function submitform(){
			document.forms[0].submit();
		}

		function autoRefresh(){
			clearTimeout(auto);
			auto = setTimeout(function(){ submitform(); autoRefresh(); }, 2000);
		}
	}
	</script>
<?php } else { ?>
	<div class="entete">
		<h1>Problème du formulaire</h1>
	</div>
	<div class="info">
		<p class="alert">Des variables sont manquantes ou erronées.</p>
		<p class="alert">Merci de contacter votre Centre de Pathologie pour signaler ce problème ou sur <a href="mailto:contact@anapath.fr" title="Envoyer un e-mail au Centre de Pathologie des Hauts de France">contact@anapath.fr</a></p>
		<button onclick="goBack()">Retour</button>
	</div>
	<script>
	function goBack() {
		window.history.back();
	}
	</script>
<?php } ?>
</html>
