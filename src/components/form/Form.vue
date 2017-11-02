<template>
  <section class="form">
    <form class="flex-vertical">
      <div>
        <span>E-mail:</span><br />
        <input
        v-if="!placeHolderMail"
        v-model="patientMail"
        type="text"
        name="patientMail"
        v-bind:value="patientMail"
        placeholder="dupont@gmail.com"
        v-bind:class="{ shadowred: errorMail }">
        <input
        v-else
        v-model="patientMail"
        type="text"
        name="patientMail"
        v-bind:placeholder="placeHolderMail"
        v-bind:class="{ shadowred: errorMail }">
      </div>
      <div>
        <span>Date de naissance:</span><br />
        <input
        v-if="!placeHolderDDN"
        v-model="patientDDN"
        type="text"
        name="patientDDN"
        v-bind:value="patientDDN"
        placeholder="31/12/1990"
        v-bind:class="{ shadowred: errorDDN }">
        <input
        v-else
        v-model="patientDDN"
        type="text"
        name="patientDDN"
        v-bind:placeholder="placeHolderDDN"
        v-bind:class="{ shadowred: errorDDN }">
      </div>
      <div>
        <span>Numéro d'Examen:</span><br />
        <input
        v-if="!placeHolderRef"
        v-model="folderRef"
        type="text"
        name="folderRef"
        v-bind:value="folderRef"
        placeholder="X18/65432"
        v-bind:class="{ shadowred: errorRef }">
        <input
        v-else
        v-model="folderRef"
        type="text"
        name="folderRef"
        v-bind:placeholder="placeHolderRef"
        v-bind:class="{ shadowred: errorRef }">
      </div>
      <div>
        <input @click.prevent="submit" type="submit" value="Envoyer">
      </div>
    </form>
  </section>
</template>
<script src='./form.js'></script>
<style src='./form.scss' lang='scss'></style>
