import {
  SEARCH_INVOICE_SUCCESS_FOUND,
  SEARCH_INVOICE_FAILURE_FOUND,
} from '../../store/mutations-types';

export default {
  name: 'Form',
  data() {
    return {
      patientName: this.$store.state.invoice.patient,
      folderNum: this.$store.state.invoice.number,
      placeHolderPatient: this.$store.state.query.patient || false,
      placeHolderNumber: this.$store.state.query.number || false,
    }
  },
  mounted: function isQuery() {
    if (this.$store.state.query.patient && this.$store.state.query.number) {
      console.log('Valid query object present: ', this.$route.query);
      this.submit();
    }
  },
  computed: {
    errorPatient() {
      return this.$store.state.validForm.patient === false;
    },
    errorNumber() {
      return this.$store.state.validForm.number === false;
    }
  },
  methods: {
    submit() {
      var dataForm = {
        patient: this.patientName || this.placeHolderPatient,
        number: this.folderNum || this.placeHolderNumber
      }
      this.$store.dispatch('validForm', dataForm).then(() => {
        if (this.$store.state.validForm.patient && this.$store.state.validForm.number) {
          var dataInvoice = {
            patient: this.$store.state.invoice.patient,
            number: this.$store.state.invoice.number
          }
          this.$store.dispatch('searchInvoice', dataInvoice);
        }
        $('html, body').animate({
          scrollTop: $('#res').offset().top - 0,
        }, 800, 'swing');
      });
    }
  }
};
