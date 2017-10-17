<template>
  <section class="form">
    <form id="form" class="flex-vertical">
      <div>
        <span>Nom de Famille:</span><br />
        <input
        v-if="!placeHolderPatient"
        v-model="patientName"
        id="input1"
        type="text"
        name="patientName"
        v-bind:value="patientName"
        placeholder="Dupont"
        v-bind:class="{ shadowred: errorPatient }">
        <input
        v-else
        v-model="patientName"
        id="input1"
        type="text"
        name="patientName"
        v-bind:placeholder="placeHolderPatient"
        v-bind:class="{ shadowred: errorPatient }">
      </div>
      <div>
        <span>Numéro d'Examen:</span><br />
        <input
        v-if="!placeHolderNumber"
        v-model="folderNum"
        id="input2"
        type="text"
        name="folderNum"
        v-bind:value="folderNum"
        placeholder="X18/65432"
        v-bind:class="{ shadowred: errorNumber }">
        <input
        v-else
        v-model="folderNum"
        id="input2"
        type="text"
        name="folderNum"
        v-bind:placeholder="placeHolderNumber"
        v-bind:class="{ shadowred: errorNumber }">
      </div>
      <div>
        <input @click.prevent="submit" type="submit" value="Envoyer">
      </div>
    </form>
  </section>
</template>
<script src='./form.js'></script>
<style src='./form.scss' lang='scss'></style>
