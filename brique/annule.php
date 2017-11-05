<?php
include 'config/client.php';
include 'utils/error-handler.php'

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
</head>
<?php include 'assets/style.css.php'; ?>
<body>
  <?php
  if ( isset($_GET[$client_pbx_ref]) &&
       isset($_GET[$client_pbx_transaction]) &&
       isset($_GET[$client_pbx_error]) &&
       isset($_GET[$client_prv_ddn]) &&
       isset($_GET[$client_prv_email])) {
    $reference=$_GET[$client_pbx_ref];
    $transaction=$_GET[$client_pbx_transaction];
    $error=$_GET[$client_pbx_error];
    $ddn=$_GET[$client_prv_ddn];
    $email=$_GET[$client_prv_email];
    ?>
    <div class="entete">
      <h1>Transaction annulée</h1>
    </div>
    <div class="info">
      <p class="error">Email rensseigné: <?php echo $email; ?></p>
      <p class="error">Date de naissance: <?php echo $ddn; ?></p>
      <p class="error">Référence de la facture: <?php echo $reference; ?></p>
      <p class="error">Numéro de transaction: <?php echo $transaction; ?></p>
      <p class="error">Motif: <?php errorHandler($error); ?></p>
      <button onclick="window.location.href = '<?php echo $client_url_server.$client_dir_ui_js ?>';">Réessayer</button>
    </div>
  <?php } else { ?>
    <div class="entete">
      <h1>Transaction annulée</h1>
    </div>
    <div class="info">
      <p class="error">Récapitulatif non disponible.</p>
      <button onclick="window.location.href = '<?php echo $client_url_server.$client_dir_ui_js ?>';">Réessayer</button>
    </div>
  <?php } ?>
</body>
</html>
