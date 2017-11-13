<template>
  <section>
    <LoaderAnapath/>
    <HeaderAnapath/>
    <InfoAnapath/>
    <FormAnapath/>
    <ResultAnapath/>
    <FooterAnapath/>
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

export default {
  name: 'index',
  components: {
    HeaderAnapath,
    InfoAnapath,
    FormAnapath,
    FooterAnapath,
    LoaderAnapath,
    ResultAnapath,
  },
  metaInfo: {
    title: 'Paiement en ligne de votre examen médical | Centre de Pathologie des Hauts-de-France',
    link: [
      { rel: 'canonical', href: 'https://anapath.fr/reglement-examen' },
      { rel: 'icon', type: 'image/png', href: '/test/static/favicon-anapath-amiens.png' },
    ],
    meta: [
      { name: 'robots', content: 'index, follow, noodp' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { name: 'description', content: 'Régler en ligne votre examen d\'anapathologie effectué au Centre de Pathologie d\'Amiens des Hauts-de-France. Paiement sécurisé' },
      { charset: 'utf-8' },
    ],
  },
};
</script>
<style src='./index.scss' lang='scss'></style>
