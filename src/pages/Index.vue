<template>
  <section>
    <template v-if="ie">
      <BrowserAlert/>
    </template>
    <template v-else>
      <LoaderAnapath/>
      <HeaderAnapath/>
      <InfoAnapath/>
      <FormAnapath/>
      <ResultAnapath/>
      <FooterAnapath/>
    </template>
  </section>
</template>
<script>

// Load Components
import HeaderAnapath from '@/components/header/Header.vue';
import InfoAnapath from '@/components/info/Info.vue';
import FormAnapath from '@/components/form/Form.vue';
import FooterAnapath from '@/components/footer/Footer.vue';
import LoaderAnapath from '@/components/loader/Loader.vue';
import ResultAnapath from '@/components/result/Result.vue';
import BrowserAlert from '@/components/browser-alert/BrowserAlert';

// Internet Explorer 6-11
const isIE = /* @cc_on!@ */false || !!document.documentMode;

export default {
  name: 'index',
  data() {
    return {
      ie: isIE,
    };
  },
  components: {
    HeaderAnapath,
    InfoAnapath,
    FormAnapath,
    FooterAnapath,
    LoaderAnapath,
    ResultAnapath,
    BrowserAlert,
  },
  metaInfo: {
    title: 'Règlez par internet votre examen d\'anatomie pathologique | Centre de Pathologie des Hauts-de-France',
    link: [
      { rel: 'canonical', href: 'https://anapath.fr/reglement-en-ligne/' },
      { rel: 'icon', type: 'image/png', href: '/reglement-en-ligne/static/favicon-anapath-amiens.png' },
    ],
    meta: [
      { name: 'robots', content: 'index, follow, noodp' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { name: 'description', content: 'Régler par internet votre examen d\'anatomie pathologique effectué au Centre de Pathologie des Hauts-de-France. Règlement sécurisé.' },
      { charset: 'utf-8' },
    ],
  },
};
</script>
<style src='./index.scss' lang='scss'></style>
