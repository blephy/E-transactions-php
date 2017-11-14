<template>
  <section class="form">
    <form class="flex-vertical no-autofill" autocomplete="off">
      <div>
        <p>E-mail :
          <span class="content">Votre adresse e-mail est <strong>nécessaire pour recevoir la notification bancaire de règlement</strong>.</span>
          <span class="infobulle" @click.prevent="showInfo"></span>
        </p>
        <input
        v-if="!placeHolderMail"
        v-model="patientMail"
        type="text"
        name="patientMail"
        autocomplete="off"
        placeholder="dupont@gmail.com"
        v-bind:class="{ shadowred: errorMail }">
        <input
        v-else
        v-model="patientMail"
        type="text"
        name="patientMail"
        autocomplete="off"
        v-bind:placeholder="placeHolderMail"
        v-bind:class="{ shadowred: errorMail }">
      </div>
      <div>
        <p>Date de naissance :
          <span class="content">Entrez la <strong>date de naissance du patient concerné par l'examen</strong>. S'il s'agit de l'examen de votre enfant, entrez sa date de naissance et non la votre.</span>
          <span class="infobulle" @click.prevent="showInfo"></span>
        </p>
        <input
        v-if="!placeHolderDDN"
        v-model="patientDDN"
        type="text"
        name="patientDDN"
        autocomplete="off"
        placeholder="31/12/1990"
        v-bind:class="{ shadowred: errorDDN }">
        <input
        v-else
        v-model="patientDDN"
        type="text"
        name="patientDDN"
        autocomplete="off"
        v-bind:placeholder="placeHolderDDN"
        v-bind:class="{ shadowred: errorDDN }">
      </div>
      <div>
        <p>Numéro d'examen :
          <span class="content">Entrez le numéro d'examen figurant sur votre note d'honoraires. Il ressemble à <strong>X18/28390</strong>.</span>
          <span class="infobulle" @click.prevent="showInfo"></span>
        </p>
        <input
        v-if="!placeHolderRef"
        v-model="folderRef"
        type="text"
        name="folderRef"
        autocomplete="off"
        placeholder="X18/65432"
        v-bind:class="{ shadowred: errorRef }">
        <input
        v-else
        v-model="folderRef"
        type="text"
        name="folderRef"
        autocomplete="off"
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
