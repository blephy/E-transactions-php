<?php
include 'config/client.php';
include 'config/e-transactions.php';
include 'config/hmac.php';
include 'utils/error-handler.php';
include 'utils/functions.php';
include 'utils/auth.php';

// Force HTTPS only if force_https = true (cf config/client.php)
if ( $force_https ) { include 'utils/force-https.php'; }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Paiement annulé | Centre de Pathologie</title>
  <meta name="description" content="Votre paiement a été annulé !">
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

  if ( $IS_AUTH_REQUEST ) { // Si le corps de la requète n'est pas modifié et provient bien de e-transactions

    // Si toutes les variables necessaires existent
  	if ( isset($_GET[$client_pbx_ref]) && isset($_GET[$client_prv_email]) && isset($_GET[$client_prv_ddn]) ) {
  ?>
      <div class="entete">
        <h1>Transaction annulée</h1>
      </div>
      <div class="info">
        <?php
          echo verifBeforePrintOut($client_prv_email, 'error');
          echo verifBeforePrintOut($client_prv_ddn, 'error');
          echo verifBeforePrintOut($client_pbx_ref, 'error');
          echo verifBeforePrintOut($client_pbx_montant, 'error');
          echo verifBeforePrintOut($client_pbx_type_paiement, 'error');
          echo verifBeforePrintOut($client_pbx_cb, 'error');
          echo verifBeforePrintOut($client_pbx_transaction, 'error');
          echo verifBeforePrintOut($client_pbx_date, 'error');
          echo verifBeforePrintOut($client_pbx_heure, 'error');
          echo verifBeforePrintOut($client_pbx_autorisation, 'error');
          echo verifBeforePrintOut($client_pbx_error, 'error');
         ?>
        <?php include 'template/button-form-vuejs.php'; ?>
        <?php if ( isset($_GET[$client_pbx_montant]) ) { include 'template/button-form-bank.php'; } ?>
        <?php include 'template/button-print.php'; ?>
      </div>
    <?php
    } else { // Il manque des variables importantes et nécessaires
    ?>
      <?php include 'template/query-missing.php'; ?>
    <?php
    }
    ?>
  <?php
  } else if ( $IS_AUTH_REQUEST === 0 ) { // Requète non sécurisé.
  ?>
    <?php include 'template/query-not-sign.php'; ?>
  <?php
  } else { // Problème interne (dépendances, ouverture clé, etc ...)
  ?>
    <?php include 'template/query-sign-intern-error.php'; ?>
  <?php
  }
  ?>
</body>
</html>
