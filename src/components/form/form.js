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
  methods: {
        submit(e) {
            e.preventDefault();
            var dataInvoice = {
              patient: this.patientName,
              number: this.folderNum
            }
            this.$store.dispatch('searchInvoice', dataInvoice);
            // this.$store.commit(SEARCH_INVOICE_SUCCESS_FOUND, dataInvoice)
            // console.log(this.$store.state.invoice);
        }
    }
};
