<?php
include 'config/client.php';
include 'utils/error-handler.php';
include 'utils/functions.php';

// Force HTTPS only if force_https = true (cf config/client.php)
if ( $force_https ) { include 'utils/force-https.php'; }
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
  if (IsAuthRequest()) { // Si le corps de la requète n'est pas modifié et provient bien de e-transactions

    if ( isset($_GET[$client_pbx_montant]) &&
         isset($_GET[$client_pbx_ref]) &&
         isset($_GET[$client_pbx_autorisation]) &&
         isset($_GET[$client_pbx_transaction]) &&
         isset($_GET[$client_pbx_cb]) &&
         isset($_GET[$client_pbx_error]) &&
         isset($_GET[$client_pbx_date]) &&
         isset($_GET[$client_pbx_heure]) &&
         isset($_GET[$client_pbx_type_paiement]) &&
         isset($_GET[$client_prv_ddn]) &&
         isset($_GET[$client_prv_email])) {
      $montant=$_GET[$client_pbx_montant];
      $reference=$_GET[$client_pbx_ref];
      $autorisation=$_GET[$client_pbx_autorisation];
      $transaction=$_GET[$client_pbx_transaction];
      $cb=$_GET[$client_pbx_cb];
      $error=$_GET[$client_pbx_error];
      $date=$_GET[$client_pbx_date];
      $heure=$_GET[$client_pbx_heure];
      $type=$_GET[$client_pbx_type_paiement];
      $ddn=$_GET[$client_prv_ddn];
      $email=$_GET[$client_prv_email];
      // convertit le format de la query DATE pour lisibilité
      $date=convertDate($date, '/');
      ?>
      <div class="entete">
        <h1>Transaction effectuée avec succès</h1>
      </div>
      <div class="info">
        <p>Email rensseigné: <?php echo $email; ?></p>
        <p>Date de naissance: <?php echo $ddn; ?></p>
        <p>Référence de la facture: <?php echo $reference; ?></p>
        <p>Montant de la transaction: <?php echo $montant/100; ?>€</p>
        <p>Numéro de carte bancaire: XXXX XXXX XXXX <?php echo $cb; ?></p>
        <p>Type de paiement choisi: <?php echo $type; ?></p>
        <p>Numéro d'autorisation: <?php echo $autorisation; ?></p>
        <p>Numéro de transaction: <?php echo $transaction; ?></p>
        <p>Transaction effectuée le: <?php echo $date; ?> à <?php echo $heure; ?></p>
        <p>Status: <?php errorHandler($error); ?></p>
        <button onclick="window.location.href = '<?php echo $client_url_server ?>';">Retour sur anapath.fr</button>
      </div>
    <?php
    } else {
      ?>
        <div class="entete">
          <h1>Transaction effectuée</h1>
        </div>
        <div class="info">
          <p class="error">Récapitulatif non disponible.</p>
          <button onclick="window.location.href = '<?php echo $client_url_server.$client_dir_ui_js ?>';">Réessayer</button>
        </div>
    <?php
    }
  } else if ( IsAuthRequest() === 0 ) { // Requète non sécurisé. Ne provient pas d'e-transactions ou les variables ont été modifiés après envoie.
    ?>
    <div class="entete">
      <h1>Requète non signée</h1>
    </div>
    <div class="info">
      <p class="alert">Il semble que les données envoyées n'ont pas pu être vérifié, ou qu'il s'agit d'une tentative de pishing contre vous.</p>
      <p class="alert">Une vérification de la clé publique est nécessaire.</p>
      <p class="alert">Merci de contacter votre Centre de Pathologie pour signaler ce problème ou sur <a href="mailto:<?php echo $client_email; ?>" title="Envoyer un e-mail au Centre de Pathologie des Hauts de France"><?php echo $client_email; ?></a></p>
      <button onclick="window.location.href = '<?php echo $client_url_server.$client_dir_ui_js ?>';">Réessayer</button>
    </div>
    <?php
  } else { // Problème interne (dépendances, ouverture clé, etc ...)
    ?>
    <div class="entete">
      <h1>Problème interne de décodage signature</h1>
    </div>
    <div class="info">
      <p class="error">Il semble qu'il y ai eu un problème interne de décodage signature pour s'assurer de l'intégrité de vos données. Une maintenance système est nécessaire.</p>
      <p class="error">Par mesure de sécurité, nous bloquons la requète.</p>
      <p class="error">Merci de contacter votre Centre de Pathologie pour signaler ce problème ou sur <a href="mailto:<?php echo $client_email; ?>" title="Envoyer un e-mail au Centre de Pathologie des Hauts de France"><?php echo $client_email; ?></a></p>
      <button onclick="window.location.href = '<?php echo $client_url_server.$client_dir_ui_js ?>';">Réessayer</button>
    </div>
    <?php
  }
    ?>
</body>
</html>
