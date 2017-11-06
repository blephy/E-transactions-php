<?php
include 'config/client.php';
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
  <title>Paiement refusé | Centre de Pathologie</title>
  <meta name="description" content="Votre paiement a été refusé !">
  <meta name="robots" content="noindex, nofollow, noodp">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="<?php echo $client_dir_ui_js ?>/static/favicon-anapath-amiens.png" />
</head>
<?php include 'assets/style.css.php'; ?>
<body>
  <?php
  // Vérification RSA de la requète - Securité !
  $IS_AUTH_REQUEST = IsAuthRequest('all');

  if ( $IS_AUTH_REQUEST ) { // Si le corps de la requète n'est pas modifié et provient bien de e-transactions

    if ( isset($_GET[$client_pbx_montant]) &&
         isset($_GET[$client_pbx_ref]) &&
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
        <h1>Transaction refusée</h1>
      </div>
      <div class="info">
        <p class="alert">Email renseigné: <?php echo $email; ?></p>
        <p class="alert">Date de naissance: <?php echo $ddn; ?></p>
        <p class="alert">Référence de la facture: <?php echo $reference; ?></p>
        <p class="alert">Montant de la transaction: <?php echo $montant/100; ?>€</p>
        <p class="alert">Numéro de carte bancaire: XXXX XXXX XXXX <?php echo $cb; ?></p>
        <p class="alert">Type de paiement choisi: <?php echo $type; ?></p>
        <p class="alert">Numéro de transaction: <?php echo $transaction; ?></p>
        <p class="alert">Transaction du: <?php echo $date; ?> à <?php echo $heure; ?></p>
        <p class="alert">Motif: <?php errorHandler($error); ?></p>
        <button onclick="window.location.href = '<?php echo $client_url_server.$client_dir_ui_js ?>';">Réessayer</button>
        <button onclick="window.print();">Imprimer ce rapport</button>
      </div>
      <?php
      } else {
        ?>
          <div class="entete">
            <h1>Transaction refusée</h1>
          </div>
          <div class="info">
            <p class="error">Récapitulatif non disponible.</p>
            <button onclick="window.location.href = '<?php echo $client_url_server.$client_dir_ui_js ?>';">Réessayer</button>
            <button onclick="window.print();">Imprimer ce rapport</button>
          </div>
      <?php
      }
    } else if ( $IS_AUTH_REQUEST === 0 ) { // Requète non sécurisé. Ne provient pas d'e-transactions ou les variables ont été modifiés après envoie.
      ?>
      <div class="entete">
        <h1>Requète non signée</h1>
      </div>
      <div class="info">
        <p class="alert">Il semble que les données envoyées n'ont pas pu être vérifié, ou qu'il s'agit d'une tentative de pishing contre vous.</p>
        <p class="alert">Une vérification de la clé publique est nécessaire.</p>
        <p class="alert">Merci de contacter votre Centre de Pathologie pour signaler ce problème ou sur <a href="mailto:<?php echo $client_email; ?>" title="Envoyer un e-mail au Centre de Pathologie des Hauts de France"><?php echo $client_email; ?></a></p>
        <button onclick="window.location.href = '<?php echo $client_url_server.$client_dir_ui_js ?>';">Réessayer</button>
        <button onclick="window.print();">Imprimer ce rapport</button>
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
        <button onclick="window.print();">Imprimer ce rapport</button>
      </div>
      <?php
    }
      ?>
</body>
</html>
