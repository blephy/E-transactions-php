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
    submit(e) {
      e.preventDefault();
      var dataForm = {
        patient: this.patientName,
        number: this.folderNum
      }
      this.$store.dispatch('validForm', dataForm).then(() => {
        if (this.$store.state.validForm.patient && this.$store.state.validForm.number) {
          var dataInvoice = {
            patient: this.$store.state.invoice.patient,
            number: this.$store.state.invoice.number
          }
          this.$store.dispatch('searchInvoice', dataInvoice);
        }
      });
      $('html, body').animate({
        scrollTop: $('#res').offset().top - 0,
      }, 800, 'swing');
    }
  }
};
