<?php
include 'config/client.php';
include 'utils/error-handler.php';
include 'utils/functions.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Paiement accepté | Centre de Pathologie</title>
  <meta name="description" content="Votre paiement a été accepté !">
  <meta name="robots" content="noindex, nofollow, noodp">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<?php include 'assets/style.css.php'; ?>
<body>
  <?php
  if ( isset($_GET[$client_pbx_montant]) &&
       isset($_GET[$client_pbx_ref]) &&
       isset($_GET[$client_pbx_autorisation]) &&
       isset($_GET[$client_pbx_transaction]) &&
       isset($_GET[$client_pbx_cb]) &&
       isset($_GET[$client_pbx_error]) &&
       isset($_GET[$client_pbx_date]) &&
       isset($_GET[$client_pbx_heure]) &&
       isset($_GET[$client_pbx_type_paiement])) {
    $montant=$_GET[$client_pbx_montant];
    $reference=$_GET[$client_pbx_ref];
    $autorisation=$_GET[$client_pbx_autorisation];
    $transaction=$_GET[$client_pbx_transaction];
    $cb=$_GET[$client_pbx_cb];
    $error=$_GET[$client_pbx_error];
    $date=$_GET[$client_pbx_date];
    $heure=$_GET[$client_pbx_heure];
    $type=$_GET[$client_pbx_type_paiement];
    // convertit le format de la query DATE pour lisibilité
    $date=convertDate($date, '/');
    ?>
    <div class="entete">
      <h1>Transaction effectuée avec succès</h1>
    </div>
    <div class="info">
      <p>Montant de la transaction: <?php echo $montant/100; ?>€</p>
      <p>Référence de la facture: <?php echo $reference; ?></p>
      <p>Numéro de carte bancaire: XXXX XXXX XXXX <?php echo $cb; ?></p>
      <p>Type de paiement choisi: <?php echo $type; ?></p>
      <p>Numéro d'autorisation: <?php echo $autorisation; ?></p>
      <p>Numéro de transaction: <?php echo $transaction; ?></p>
      <p>Transaction effectuée le: <?php echo $date; ?> à <?php echo $heure; ?></p>
      <p>Status: <?php errorHandler($error); ?></p>
      <button onclick="window.location.href = '<?php echo $client_url_server.$client_dir_ui_js ?>';">Retour sur anapath.fr</button>
    </div>
  <?php } else { ?>
    <div class="entete">
      <h1>Transaction effectuée avec succès</h1>
    </div>
    <div class="info">
      <p class="alert">Récapitulatif non disponible, vérifiez vos e-mails.</p>
      <button onclick="window.location.href = '<?php echo $client_url_server.$client_dir_ui_js ?>';">Retour sur anapath.fr</button>
    </div>
  <?php } ?>
</body>
</html>
