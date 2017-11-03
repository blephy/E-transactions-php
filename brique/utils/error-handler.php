<?php
function errorHandler($code_error) {
  switch ($code_error) {
    case '00000':
      echo 'Opération réussie';
      break;
    case '00001':
      echo 'La connexion au centre d\'autorisation a échoué';
      break;
    case '00003':
      echo 'Erreur de la plateforme bancaire';
      break;
    case '00004':
      echo 'Numéro de porteur ou cryptogramme visuel invalide';
      break;
    case '00006':
      echo 'Accès refusé';
      break;
    case '00008':
      echo 'Date de fin de validité incorrect';
      break;
    case '00009':
      echo 'Erreur de création d\'un abonnement';
      break;
    case '00010':
      echo 'Devise inconnue';
      break;
    case '00011':
      echo 'Montant incorrect';
      break;
    case '00015':
      echo 'Paiement déjà effectué';
      break;
    case '00016':
      echo 'Abonnement déjà existant';
      break;
    case '00021':
      echo 'Carte non autorisée';
      break;
    case '00029':
      echo 'Carte non conforme';
      break;
    case '00030':
      echo 'Temps d\'attente de plus de 15 minutes sur la page de paiements';
      break;
    case '00033':
      echo 'Code pays de l\'adresse IP du navigateur de l\'acheteur non autorisé';
      break;
    case '00040':
      echo 'Opération sans authentification 3-DSecure, bloquée par le filtre';
      break;
    case '99999':
      echo 'Opération en attente de validation par l\'émetteur du moyen de paiement';
      break;
    default:
      echo 'Erreur inconnue';
  }
}
?>
