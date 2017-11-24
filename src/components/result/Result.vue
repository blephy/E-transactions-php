<template>
  <section :result="results" class="result flex-horizontal" v-bind:class="classObject" id="res">
    <template v-if="result.validForm.mail && result.validForm.ref && result.validForm.ddn">
      <template v-if="!result.errorConnect && result.found === 1">
        <p>Nom : <strong>{{result.invoice.lastname}}</strong></p>
        <p>Prénom : <strong>{{result.invoice.firstname}}</strong></p>
        <p>Date de naissance : <strong>{{result.invoice.ddn}}</strong></p>
        <p>N° Examen : <strong>{{result.invoice.ref}}</strong></p>
        <p>Montant à régler : <span class="pop">{{result.invoice.price}} €</span></p>
        <template v-if="result.invoice.paied === false">
          <a class="button" v-bind:href="makeURL" title="Vérifiez le montant avant de cliquer">Régler cette facture</a>
        </template>
        <template v-else>
          <p><strong>Facture déjà réglée !</strong></p>
        </template>
      </template>
      <template v-if="!result.errorConnect && result.found === 2">
        <p>Email : <strong>{{result.invoice.mail}}</strong></p>
        <p>Date de naissance : <strong>{{result.invoice.ddn}}</strong></p>
        <p>N° Examen : <strong>{{result.invoice.ref}}</strong></p>
        <p><strong>Facture introuvable ! Vérifiez vos données sur la facture papier.</strong></p>
      </template>
      <template v-if="result.errorConnect">
        <p><strong>Une erreur de connexion est survenue. Nous sommes navrés de la gêne occasionnée.<br />Vérifiez votre connexion internet ou réessayez plus tard.</strong></p>
      </template>
    </template>
    <template v-if="result.validForm.mail === false || result.validForm.ref === false || result.validForm.ddn === false">
      <p>Formulaire invalide :</p>
      <template v-if="result.validForm.mail === false">
        <p>Email invalide.</p>
      </template>
      <template v-if="result.validForm.ddn === false">
        <p>Date de naissance invalide. Exemple : <span class="exemple">31/12/1990</span></p>
      </template>
      <template v-if="result.validForm.ref=== false">
        <p>N° Examen invalide. Exemple : <span class="exemple">E17/12345</span></p>
      </template>
    </template>
  </section>
</template>
<script src="./result.js"></script>
<style src="./result.scss" lang="scss"></style>
