<?php
function errorHandler($code_error) {
  switch ($code_error) {
    case '00000':
      echo 'Transaction approuvée. Opération réussie';
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
    case '00100':
      echo 'Transaction approuvée ou traitée avec succès';
      break;
    case '00101':
      echo 'Contacter l\'émetteur de carte';
      break;
    case '00102':
      echo 'Contacter l\'émetteur de carte';
      break;
    case '00103':
      echo 'Commerçant invalide';
      break;
    case '00104':
      echo 'Conserver la carte';
      break;
    case '00105':
      echo 'Ne pas honorer';
      break;
    case '00107':
      echo 'Conserver la carte, conditions spéciales';
      break;
    case '00108':
      echo 'Approuver après identification du porteur';
      break;
    case '00112':
      echo 'Transaction invalide';
      break;
    case '00113':
      echo 'Montant invalide';
      break;
    case '00114':
      echo 'Numéro de porteur invalide';
      break;
    case '00115':
      echo 'Emetteur de carte inconnu';
      break;
    case '00117':
      echo 'Annulation client';
      break;
    case '00119':
      echo 'Répéter la transaction ultérieurement';
      break;
    case '00120':
      echo 'Réponse erronée (erreur dans le domaine serveur)';
      break;
    case '00124':
      echo 'Mise à jour de fichier non supportée';
      break;
    case '00125':
      echo 'Impossible de localiser l\'enregistrement dans le fichier';
      break;
    case '00126':
      echo 'Enregistrement dupliqué, ancien enregistrement remplacé';
      break;
    case '00127':
      echo 'Erreur en « edit » sur champ de mise à jour fichier';
      break;
    case '00128':
      echo 'Accès interdit au fichier';
      break;
    case '00129':
      echo 'Mise à jour de fichier impossible';
      break;
    case '00130':
      echo 'Erreur de format';
      break;
    case '00133':
      echo 'Carte expirée';
      break;
    case '00138':
      echo 'Nombre d\'essais code confidentiel dépassé';
      break;
    case '00141':
      echo 'Carte perdue';
      break;
    case '00143':
      echo 'Carte volée';
      break;
    case '00151':
      echo 'Provision insuffisante ou crédit dépassé';
      break;
    case '00154':
      echo 'Date de validité de la carte dépassée';
      break;
    case '00155':
      echo 'Code confidentiel erroné';
      break;
    case '00156':
      echo 'Carte absente du fichier';
      break;
    case '00157':
      echo 'Transaction non permise à ce porteur';
      break;
    case '00158':
      echo 'Transaction interdite au terminal';
      break;
    case '00159':
      echo 'Suspicion de fraude';
      break;
    case '00160':
      echo 'L\'accepteur de carte doit contacter l\'acquéreur';
      break;
    case '00161':
      echo 'Dépasse la limite du montant de retrait';
      break;
    case '00163':
      echo 'Règles de sécurité non respectées';
      break;
    case '00168':
      echo 'Réponse non parvenue ou reçue trop tard';
      break;
    case '00175':
      echo 'Nombre d\'essais code confidentiel dépassé';
      break;
    case '00176':
      echo 'Porteur déjà en opposition, ancien enregistrement conservé';
      break;
    case '00189':
      echo 'Echec de l’authentification';
      break;
    case '00190':
      echo 'Arrêt momentané du système';
      break;
    case '00191':
      echo 'Emetteur de cartes inaccessible';
      break;
    case '00194':
      echo 'Demande dupliquée';
      break;
    case '00196':
      echo 'Mauvais fonctionnement du système';
      break;
    case '00197':
      echo 'Echéance de la temporisation de surveillance globale';
      break;
    case '99999':
      echo 'Opération en attente de validation par l\'émetteur du moyen de paiement';
      break;
    default:
      echo 'Erreur inconnue';
  }
}
?>
