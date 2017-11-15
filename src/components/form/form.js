import {
  SEARCH_INVOICE_SUCCESS_FOUND,
  SEARCH_INVOICE_FAILURE_FOUND,
} from '../../store/mutations-types';

export default {
  name: 'Form',
  data() {
    return {
      patientMail: this.$store.state.invoice.mail,
      patientDDN: this.$store.state.invoice.ddn,
      folderRef: this.$store.state.invoice.ref,
      placeHolderMail: this.$store.state.query.mail || false,
      placeHolderRef: this.$store.state.query.ref || false,
      placeHolderDDN: this.$store.state.query.ddn || false,
    }
  },
  mounted: function isQuery() {
    if (this.$store.state.query.mail && this.$store.state.query.ref && this.$store.state.query.ddn) {
      console.log('Valid query object present: ', this.$route.query);
      this.submit();
    }
  },
  computed: {
    errorMail() {
      return this.$store.state.validForm.mail === false;
    },
    errorRef() {
      return this.$store.state.validForm.ref === false;
    },
    errorDDN() {
      return this.$store.state.validForm.ddn === false;
    },
  },
  methods: {
    submit() {
      var dataForm = {
        mail: this.patientMail || this.placeHolderMail,
        ref: this.folderRef || this.placeHolderRef,
        ddn: this.patientDDN || this.placeHolderDDN,
      }
      this.$store.dispatch('validForm', dataForm).then(() => {
        if (this.$store.state.validForm.mail && this.$store.state.validForm.ref && this.$store.state.validForm.ddn) {
          var dataInvoice = {
            mail: this.$store.state.invoice.mail,
            ref: this.$store.state.invoice.ref,
            ddn: this.$store.state.invoice.ddn,
          }
          // this.$store.dispatch('searchInvoice', dataInvoice);
          this.$store.commit(SEARCH_INVOICE_SUCCESS_FOUND, dataInvoice);
        }
        $('html, body').animate({
          scrollTop: $('#res').offset().top - 50,
        }, 800, 'swing');
      });
    },
    showInfo(event) {
      $('.content').css('display', 'none');
      $(event.target).prev().css('display', 'inline');
    },
    hideInfo(event) {
      $(event.target).parent().css('display', 'none');
    }
  }
};
