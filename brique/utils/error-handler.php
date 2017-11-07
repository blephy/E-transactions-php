<?php
function errorHandler($code_error) {
  switch ($code_error) {
    case '00000':
      return 'Transaction approuvée. Opération réussie.';
      break;
    case '00001':
      return 'La connexion au centre d\'autorisation a échoué, ou le client a annulé.';
      break;
    case '00003':
      return 'Erreur de la plateforme bancaire.';
      break;
    case '00004':
      return 'Numéro de porteur ou cryptogramme visuel invalide.';
      break;
    case '00006':
      return 'Accès refusé.';
      break;
    case '00008':
      return 'Date de fin de validité incorrecte.';
      break;
    case '00009':
      return 'Erreur de création d\'un abonnement.';
      break;
    case '00010':
      return 'Devise inconnue.';
      break;
    case '00011':
      return 'Montant incorrect.';
      break;
    case '00015':
      return 'Paiement déjà effectué.';
      break;
    case '00016':
      return 'Abonnement déjà existant.';
      break;
    case '00021':
      return 'Carte non autorisée.';
      break;
    case '00029':
      return 'Carte non conforme.';
      break;
    case '00030':
      return 'Temps d\'attente de plus de 15 minutes sur la page de paiements.';
      break;
    case '00033':
      return 'Code pays de l\'adresse IP du navigateur de l\'acheteur non autorisé.';
      break;
    case '00040':
      return 'Opération sans authentification 3-DSecure, bloquée par le filtre.';
      break;
    case '00100':
      return 'Transaction approuvée ou traitée avec succès.';
      break;
    case '00101':
      return 'Contacter l\'émetteur de carte.';
      break;
    case '00102':
      return 'Contacter l\'émetteur de carte.';
      break;
    case '00103':
      return 'Commerçant invalide.';
      break;
    case '00104':
      return 'Conserver la carte.';
      break;
    case '00105':
      return 'Ne pas honorer.';
      break;
    case '00107':
      return 'Conserver la carte, conditions spéciales.';
      break;
    case '00108':
      return 'Approuver après identification du porteur.';
      break;
    case '00112':
      return 'Transaction invalide.';
      break;
    case '00113':
      return 'Montant invalide.';
      break;
    case '00114':
      return 'Numéro de porteur invalide.';
      break;
    case '00115':
      return 'Emetteur de carte inconnu.';
      break;
    case '00117':
      return 'Annulation client.';
      break;
    case '00119':
      return 'Répéter la transaction ultérieurement.';
      break;
    case '00120':
      return 'Réponse erronée (erreur dans le domaine serveur).';
      break;
    case '00124':
      return 'Mise à jour de fichier non supportée.';
      break;
    case '00125':
      return 'Impossible de localiser l\'enregistrement dans le fichier.';
      break;
    case '00126':
      return 'Enregistrement dupliqué, ancien enregistrement remplacé.';
      break;
    case '00127':
      return 'Erreur en « edit » sur champ de mise à jour fichier.';
      break;
    case '00128':
      return 'Accès interdit au fichier.';
      break;
    case '00129':
      return 'Mise à jour de fichier impossible.';
      break;
    case '00130':
      return 'Erreur de format.';
      break;
    case '00133':
      return 'Carte expirée.';
      break;
    case '00138':
      return 'Nombre d\'essais code confidentiel dépassé.';
      break;
    case '00141':
      return 'Carte perdue.';
      break;
    case '00143':
      return 'Carte volée.';
      break;
    case '00151':
      return 'Provision insuffisante ou crédit dépassé.';
      break;
    case '00154':
      return 'Date de validité de la carte dépassée.';
      break;
    case '00155':
      return 'Code confidentiel erroné.';
      break;
    case '00156':
      return 'Carte absente du fichier.';
      break;
    case '00157':
      return 'Transaction non permise à ce porteur.';
      break;
    case '00158':
      return 'Transaction interdite au terminal.';
      break;
    case '00159':
      return 'Suspicion de fraude.';
      break;
    case '00160':
      return 'L\'accepteur de carte doit contacter l\'acquéreur.';
      break;
    case '00161':
      return 'Dépasse la limite du montant de retrait.';
      break;
    case '00163':
      return 'Règles de sécurité non respectées.';
      break;
    case '00168':
      return 'Réponse non parvenue ou reçue trop tard.';
      break;
    case '00175':
      return 'Nombre d\'essais code confidentiel dépassé.';
      break;
    case '00176':
      return 'Porteur déjà en opposition, ancien enregistrement conservé.';
      break;
    case '00189':
      return 'Echec de l’authentification.';
      break;
    case '00190':
      return 'Arrêt momentané du système.';
      break;
    case '00191':
      return 'Emetteur de cartes inaccessible.';
      break;
    case '00194':
      return 'Demande dupliquée.';
      break;
    case '00196':
      return 'Mauvais fonctionnement du système.';
      break;
    case '00197':
      return 'Echéance de la temporisation de surveillance globale.';
      break;
    case '99999':
      return 'Opération en attente de validation par l\'émetteur du moyen de paiement.';
      break;
    default:
      return 'Erreur inconnue.';
  }
}
?>
