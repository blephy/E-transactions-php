<?php
include 'config/client.php';
include 'utils/error-handler.php'
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Paiement refusé | Centre de Pathologie</title>
  <meta name="description" content="Votre paiement a été refusé !">
  <meta name="robots" content="noindex, nofollow, noodp">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<?php include 'assets/style.php'; ?>
<body>
  <?php
  if ( isset($_GET[$client_pbx_montant]) &&
       isset($_GET[$client_pbx_ref]) &&
       isset($_GET[$client_pbx_transaction]) &&
       isset($_GET[$client_pbx_cb]) &&
       isset($_GET[$client_pbx_error]) &&
       isset($_GET[$client_pbx_date])) {
    $montant=$_GET[$client_pbx_montant];
    $reference=$_GET[$client_pbx_ref];
    $transaction=$_GET[$client_pbx_transaction];
    $cb=$_GET[$client_pbx_cb];
    $error=$_GET[$client_pbx_error];
    $date=$_GET[$client_pbx_date];
    ?>
    <div class="entete">
      <h1>Transaction refusée</h1>
    </div>
    <div class="info">
      <p class="alert">Montant de la transaction: <?php echo $montant/100 ?>€</p>
      <p class="alert">Référence de la facture: <?php echo $reference ?></p>
      <p class="alert">Numéro de carte bancaire: XXXX XXXX XXXX <?php echo $cb ?></p>
      <p class="alert">Numéro de transaction: <?php echo $transaction ?></p>
      <p class="alert">Transaction du: <?php echo $date ?></p>
      <p class="alert">Motif: <?php errorHandler($error) ?></p>
      <button onclick="window.location.href = '<?php echo $client_url_server.$client_dir_ui_js ?>';">Réessayer</button>
    </div>
  <?php } else { ?>
    <div class="entete">
      <h1>Transaction refusée</h1>
    </div>
    <div class="info">
      <p class="alert">Récapitulatif non disponible.</p>
      <button onclick="window.location.href = '<?php echo $client_url_server.$client_dir_ui_js ?>';">Réessayer</button>
    </div>
  <?php } ?>
</body>
</html>
