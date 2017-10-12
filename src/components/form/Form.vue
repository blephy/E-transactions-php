<template>
  <section class="form">
    <form id="form" class="flex-vertical">
      <div>
        <span>Nom de Famille:</span><br />
        <input v-model="patientName" id="input1" type="text" name="patientName" value="">
      </div>
      <div>
        <span>Numéro de Facture:</span><br />
        <input v-model="folderNum" id="input2" type="text" name="folderNum" value="">
      </div>
      <div>
        <input @click="submit" type="submit" value="Envoyer">
      </div>
    </form>
  </section>
</template>
<script src='./form.js'></script>
<style src='./form.scss' lang='scss'></style>
