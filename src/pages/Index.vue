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

};
</script>
<style src='./index.scss' lang='scss'></style>
