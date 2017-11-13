<?php
function sendNotifIPN($case, $message_json = NULL) {
  global $client_email_contact,
         $client_email_ipn_to,
         $client_email_ipn_from,
         $client_email_master,
         $client_prv_email,
         $client_prv_ddn,
         $client_pbx_ref,
         $client_pbx_montant,
         $client_pbx_date,
         $client_pbx_heure,
         $client_pbx_type_paiement,
         $client_pbx_cb,
         $client_pbx_transaction,
         $client_pbx_error,
         $client_prv_error_trad,
         $client_pbx_autorisation;

 $new_line = " \r\n";
 $tabulation = "\t ";
 $date = date("r (T)");
 $ip = $_SERVER['REMOTE_ADDR'];
 $qs = $_SERVER['QUERY_STRING'];
 $headers = "From: Retour Bancaire IPN <".$client_email_ipn_from.">".$new_line.
            "Return-Path: ".$client_email_contact.$new_line.
            "Reply-To: ".$client_email_ipn_from.$new_line.
            "Date: ".$date.$new_line.
            "X-Mailer: PHP/".phpversion();

  switch ($case) {
    case 'AUTH_OK':
      $sujet = '-> Requète autorisée, transaction signée.';
      $message_obj = json_decode($message_json);
      $destinataire = $client_email_ipn_to;
      $message = "Une nouvelle transaction signée et autorisée vient de parvenir :".$new_line.$new_line.
                 "---------------------------------------------------------------------------".$new_line.
                 "Email client : ".$message_obj->$client_prv_email.$new_line.
                 "Date de naissance : ".$message_obj->$client_prv_ddn.$new_line.
                 "Référence examen : ".$message_obj->$client_pbx_ref.$new_line.
                 "Montant facture : ".$message_obj->$client_pbx_montant." €".$new_line.
                 "Date transaction : ".$message_obj->$client_pbx_date.$new_line.
                 "Heure transaction : ".$message_obj->$client_pbx_heure.$new_line.
                 "Type de paiement : ".$message_obj->$client_pbx_type_paiement.$new_line.
                 "4 derniers chiffres CB : ".$message_obj->$client_pbx_cb.$new_line.
                 "Numéro de transaction : ".$message_obj->$client_pbx_transaction.$new_line.
                 "Code retour : ".$message_obj->$client_pbx_error.$new_line.
                 "Traduction code retour : ".$message_obj->$client_prv_error_trad.$new_line.
                 "Numéro d'autorisation bancaire : ".$message_obj->$client_pbx_autorisation.$new_line.
                 "IP du server appelant : ".$ip.$new_line.$new_line.
                 "---------------------------------------------------------------------------".$new_line.
                 "Informations utiles pour la compréhension :".$new_line.
                 $tabulation."- Cas d'un paiement effectué :".$new_line.
                 $tabulation.$tabulation."- Le code retour doit avoir la valeur 00000".$new_line.
                 $tabulation.$tabulation."- Le numéro d'autorisation bancaire doit être différent de 0 ou null".$new_line.
                 $tabulation."- Cas d'un paiement en attente (paypal) :".$new_line.
                 $tabulation.$tabulation."- Le code retour doit avoir la valeur 99999".$new_line.
                 $tabulation.$tabulation."- Le numéro d'autorisation bancaire doit être différent de 0 ou null".$new_line.
                 $tabulation."- Cas d'un paiement refusé :".$new_line.
                 $tabulation.$tabulation."- Le code retour sera différent de 00000 ou de 99999".$new_line.
                 $tabulation.$tabulation."- Le numéro d'autorisation bancaire vaut 0 ou null".$new_line.
                 $tabulation."- Transaction de TEST (pré-production): le numéro d'autorisation sera toujours XXXXXX";
      break;
    case 'QUERY_FAIL':
      $sujet = "!! LISEZ !! Un problème sérieux vient d'être détecté";
      $destinataire = $client_email_ipn_to.", contact@anapath.fr";
      $message = "Un problème nécessitant des investigations vient d'arriver :".$new_line.$new_line.
                 "La transaction a été envoyée par l'IP autorisée suivante : ".$ip.$new_line.
                 "La signature de la requête est bien signée, mais il manque des variables :".$new_line.
                 $tabulation."- Soit le montant de la transaction".$new_line.
                 $tabulation."- Soit la référence de la transaction".$new_line.
                 $tabulation."- Soit la date de naissance".$new_line.
                 $tabulation."- Soit l'adresse email du patient".$new_line.$new_line.
                 "Ce qui n'est pas normal, car une requête signée ne peux théoriquement pas".$new_line.
                 "ne pas contenir toutes les variables.".$new_line.$newline.
                 "Merci d'en informer votre responsable informatique : ".$client_email_master.$new_line.
                 "et de lui fournir cette information supplémentaire (query string) :".$new_line.
                 $qs;
      break;
    case 'AUTH_FAIL':
      $sujet = "!! URGENT !! Clé publique probablement obselète";
      $destinataire = $client_email_ipn_to.", contact@anapath.fr";
      $message = "Le server appelant ".$ip." a été autorisé avec succès mais la signature".$new_line.
                 "de la requête n'est pas authentifiée !".$new_line.$new_line.
                 "Ceci est forcément du à un changement de la clé publique d'e-transactions".$new_line.
                 "ou alors d'un problème d'e-transaction dans l'envoie des données.".$new_line.$new_line.
                 "Appelez e-transactions au 0810 812 810 pour leur faire part de l'erreur.".$new_line.
                 "Avertissez votre responsable informatique car une transaction client acceptée".$new_line.
                 "par la banque n'a peut-être pas pu être enregistrée sur vos server locaux.".$new_line.$new_line.
                 "Merci d'en informer votre responsable informatique : ".$client_email_master.$new_line.
                 "et de lui fournir cette information supplémentaire (query string) :".$new_line.
                 $qs;
      break;
    case 'CRITIQUE':
      $sujet = "!! CRITIQUE !! Problème interne de décodage signature";
      $destinataire = $client_email_ipn_to.", contact@anapath.fr";
      $message = "Le server appelant ".$ip." a été autorisé avec succès mais la signature".$new_line.
                 "de la requête n'a pas pu être vérifié en raison d'un problème interne !".$new_line.$new_line.
                 "Cela peut-être du à un problème de votre hébergeur, un problème unique et temporaire".$new_line.
                 "de surcharge du server ou encore d'une dépendance PHP défaillante.".$new_line.$new_line.
                 "Merci d'en informer votre responsable informatique : ".$client_email_master.$new_line.
                 "et de lui fournir cette information supplémentaire (query string) :".$new_line.
                 $qs;
      break;
    case 'FILTER_IP':
      $sujet = "!! FRAUDE !! Changement IP e-transactions ou fraude potentielle";
      $destinataire = $client_email_ipn_to.", contact@anapath.fr";
      $message = "Le server appelant ".$ip." a essayé de communiquer avec vos serveurs".$new_line.
                 "mais il ne fait pas partie des IP restreintes d'e-transactions.".$new_line.$new_line.
                 "Soit les serveurs d'e-transactions ont de nouvelles IP, il faut donc".$new_line.
                 "mettre à jour le code source avec les nouvelles adresse IP d'e-transactions :".$new_line.
                 "Appelez e-transactions au 0810 812 810 pour leur demander si c'est le cas.".$new_line.$new_line.
                 "Soit il s'agit d'une tentative de fraude ou de hacking : ".$new_line.
                 "Dans ce cas merci d'en informer votre responsable informatique : ".$client_email_master.$new_line.
                 "et de lui fournir cette information supplémentaire (query string) :".$new_line.
                 $qs;
      break;
    case 'ERR_CURL':
      $sujet = "!! ERR TRANSFERT !! Erreur de communication serveur";
      $destinataire = $client_email_ipn_to.", contact@anapath.fr";
      $message = "Le server appelant ".$ip." a bien communiqué avec vos serveurs".$new_line.
                 "et la requête à bien été authentifié.".$new_line.$new_line.
                 "Mais une erreur de transfert CURL est survenue avec l'API SOTRAIG".$new_line.
                 "Merci d'en informer votre responsable informatique : ".$client_email_master.$new_line.
                 "et de lui fournir ces informations supplémentaires (query string) :".$new_line.
                 $qs.$new_line.$new_line.
                 "erreur :".$new_line.
                 $message_json;
      break;
  }
  return mail($destinataire, $sujet, $message, $headers);
}
?>
