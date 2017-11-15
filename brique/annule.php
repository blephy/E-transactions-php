<?php
include_once 'config/client.php';
include_once 'utils/functions.php';
include_once 'utils/auth.php';

// Force HTTPS only if force_https = true (cf config/client.php)
if ( $force_https ) { include 'utils/force-https.php'; }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Règlement annulé | Centre de Pathologie des Hauts-de-France</title>
  <meta name="description" content="Votre règlement a été annulé !">
  <meta name="robots" content="noindex, nofollow, noodp">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="<?php echo $client_dir_ui_js ?>/static/favicon-anapath-amiens.png" />
</head>
<?php include 'assets/style.css.php'; ?>
<body>
  <?php
  // Vérification RSA de la requète - Securité !
  // Ici pas d'appel de la fonction avec une valeur 'all' car e-transactions crypte uniquement les variables
  // PBX alors que la documentation dit qu'e-transactions crypte sur toutes les variables. Donc on test les 2.
  $IS_AUTH_REQUEST = IsAuthRequest();

  if ( $IS_AUTH_REQUEST === 1 ) { // Si le corps de la requète n'est pas modifié et provient bien de e-transactions

    // Si toutes les variables necessaires existent
  	if ( isset($_GET[$client_pbx_ref]) && isset($_GET[$client_prv_email]) && isset($_GET[$client_prv_ddn]) ) {
  ?>
      <div class="entete">
        <a href="<?php echo $client_url_server ?>" title="Retour sur le site du Centre de Pathologie des Hauts-de-France"><img src="<?php echo $client_file_logo ?>" alt="Logo Laboratoire Anapathologie Amiens"></a>
        <h1>Transaction annulée</h1>
      </div>
      <div class="info">
        <?php
          echo verifBeforePrintOut($client_prv_email);
          echo verifBeforePrintOut($client_prv_ddn);
          echo verifBeforePrintOut($client_pbx_ref);
          echo verifBeforePrintOut($client_pbx_montant);
          echo verifBeforePrintOut($client_pbx_type_paiement);
          echo verifBeforePrintOut($client_pbx_cb);
          echo verifBeforePrintOut($client_pbx_transaction);
          echo verifBeforePrintOut($client_pbx_date);
          echo verifBeforePrintOut($client_pbx_heure);
          echo verifBeforePrintOut($client_pbx_autorisation);
          echo verifBeforePrintOut($client_pbx_error, 'error');
         ?>
        <?php include 'template/button-form-vuejs.php'; ?>
        <?php if ( isset($_GET[$client_pbx_montant]) ) { include 'template/button-form-bank.php'; } ?>
        <?php include 'template/button-print.php'; ?>
      </div>
    <?php
    } else { // Il manque des variables importantes et nécessaires
        include 'template/query-missing.php';
        customLog('Variables manquantes dans la query string.');
    }
  } else if ( $IS_AUTH_REQUEST === 0 ) { // Requète non sécurisée.
      include 'template/query-not-sign.php';
      customLog('Query string non signée.');
  } else { // Problème interne (dépendances, ouverture clé, etc ...)
      include 'template/query-sign-intern-error.php';
      customLog('Problème interne de décodage signature.');
  }
  ?>
</body>
</html>
