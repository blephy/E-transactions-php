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
               this.result.validForm.ref === false,
      }
    }
  },
  methods: {
    makeURL: function () {
      var aim_file = this.$store.state.aimFile;
      var uri = aim_file + '?' +
        'montant=' + '54,90' + '&' +
        'ref=' + this.result.invoice.ref + '&' +
        'porteur=' + this.result.invoice.mail;
      var uri_encoded = encodeURI(uri);
      console.log(uri_encoded);
    }
  },
}
