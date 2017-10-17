<template>
  <section :result="results" class="result flex-horizontal" v-bind:class="classObject" id="res">
    <template v-if="result.validForm.patient && result.validForm.number">
      <template v-if="!result.errorConnect && result.found === 1">
        <p>Nom: {{result.invoice.patient}}</p>
        <p>Numéro: {{result.invoice.number}}</p>
        <p>Montant: <span class="pop">{{result.invoice.price}} €</span></p>
        <template v-if="result.invoice.paied === false">
          <a class="button" href="https://www.e-transactions.fr/" title="Vérifiez le montant avant de cliquer">Régler cette facture</a>
        </template>
        <template v-else>
          <p><strong>Facture déjà payée !</strong></p>
        </template>
      </template>
      <template v-if="!result.errorConnect && result.found === 2">
        <p>Nom: {{result.invoice.patient}}</p>
        <p>Numéro: {{result.invoice.number}}</p>
        <p><strong>Facture introuvable ! Vérifiez vos données sur la facture papier.</strong></p>
      </template>
      <template v-if="result.errorConnect">
        <p><strong>Une erreur de connexion est survenue. Nous sommes navrés de la gêne occasionnée.<br />Vérifiez votre connexion internet ou réessayez plus tard.</strong></p>
      </template>
    </template>
    <template v-if="result.validForm.patient === false || result.validForm.number === false">
      <p>Formulaire invalide:</p>
      <template v-if="result.validForm.patient === false">
        <p>Nom de famille vide.</p>
      </template>
      <template v-if="result.validForm.number=== false">
        <p>Numéro d'examen invalide. Exemple: <span class="exemple">E17/12345</span></p>
      </template>
    </template>
  </section>
</template>
<script src="./result.js"></script>
<style src="./result.scss" lang="scss"></style>
