<template>
  <section v-show="isLoading" class="callback flex-vertical">
    <p class="info"><span class="loading"></span><br />Patientez ...</p>
  </section>
</template>
<script src='./loader.js'></script>
<style src='./loader.scss' lang='scss'></style>
