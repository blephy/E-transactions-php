import config from '../../../config/index';
export default {
  name: 'Result',
  data() {
    return {
      result: this.$store.state,
    }
  },
  computed: {
    results: function () {
      return this.$store.state;
    },
    classObject: function () {
      return  {
        found: this.result.found === 1,
        alert: this.result.found === 2,
        error: this.result.errorConnect ||
               this.result.validForm.mail === false ||
               this.result.validForm.ref === false ||
               this.result.validForm.ddn === false,
      }
    },
    makeURL: function () {
      var uri = config.build.urlDomaine +
                config.build.assetsPublicPath +
                config.build.phpFilesBrique + '/' +
                config.build.redirectBankFileName + '?' +
                'MONTANT=' + this.result.invoice.price + '&' +
                'REF=' + this.result.invoice.ref + '&' +
                'DDN=' + this.result.invoice.ddn + '&' +
                'EMAIL=' + this.result.invoice.mail;
      var uri_encoded = encodeURI(uri);
      return uri_encoded;
    }
  },
}
