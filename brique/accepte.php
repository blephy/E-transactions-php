<?php
include 'config/client.php';
include 'utils/error-handler.php'
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
<?php include 'assets/style.php'; ?>
<body>
  <?php
  if ( isset($_GET[$client_pbx_montant]) && isset($_GET[$client_pbx_ref]) && isset($_GET[$client_pbx_autorisation]) && isset($_GET[$client_pbx_transaction]) && isset($_GET[$client_pbx_cb]) && isset($_GET[$client_pbx_error]) && isset($_GET[$client_pbx_date])) {
    $montant=$_GET[$client_pbx_montant];
    $reference=$_GET[$client_pbx_ref];
    $autorisation=$_GET[$client_pbx_autorisation];
    $transaction=$_GET[$client_pbx_transaction];
    $cb=$_GET[$client_pbx_cb];
    $error=$_GET[$client_pbx_error];
    $date=$_GET[$client_pbx_date];
    ?>
    <div class="entete">
      <h1>Transaction effectuée avec succès</h1>
    </div>
    <div class="info">
      <p>Montant de la transaction: <?php echo $montant/100 ?>€</p>
      <p>Référence de la facture: <?php echo $reference ?></p>
      <p>Numéro de carte bancaire: XXXX XXXX XXXX <?php echo $cb ?></p>
      <p>Code d'autorisation: <?php echo $autorisation ?></p>
      <p>Numéro de transaction: <?php echo $transaction ?></p>
      <p>Transaction effectuée le: <?php echo $date ?></p>
      <p>Status: <?php errorHandler($error) ?></p>
    </div>
  <?php } else { ?>
    <div class="entete">
      <h1>Transaction effectuée avec succès</h1>
    </div>
    <div class="info">
      <p>Récapitulatif non disponible, vérifiez vos e-mails.</p>
    </div>
  <?php } ?>
</body>
</html>
