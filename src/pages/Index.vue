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

// Load Animations
// import LinkScroll from '../assets/animations/class.linkScroll';

// Init LinkScroll on every a[href^='#']
// -------------------------------------
// LinkScroll.init({
//   target: 'html, body',
//   selector: 'a[href^="#"]',
//   offset: 125,
//   delay: 800,
//   easing: 'swing',
// });

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
