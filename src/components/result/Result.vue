<template>
  <section :result="results" class="result flex-horizontal" v-bind:class="classObject">
    <template v-if="!result.errorConnect && result.found === 1">
      <p>Nom: {{result.invoice.patient}}</p>
      <p>Numéro: {{result.invoice.number}}</p>
      <p>Montant: {{result.invoice.price}}€</p>
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
      <p><strong>Une erreur de connexion est survenue. Nous sommes navrés de la gêne occasionnée.<br />Vérifiez votre connexion internet ou réessayer plus tard.</strong></p>
    </template>
  </section>
</template>
<script src="./result.js"></script>
<style src="./result.scss" lang="scss"></style>
