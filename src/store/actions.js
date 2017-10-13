import axios from 'axios';
import {
  SEARCH_INVOICE,
  SEARCH_INVOICE_SUCCESS_FOUND,
  SEARCH_INVOICE_FAILURE_FOUND,
  SEARCH_INVOICE_FAILURE,
  VALIDATE_FORM,
  INVALID_FORM_NUMBER,
  INVALID_FORM_PATIENT,
  VALID_FORM_NUMBER,
  VALID_FORM_PATIENT,
} from './mutations-types';
import {
  NUMBER_REG_EXP,
} from './regexp';

const API_BASE = 'https://www.bioserveur.com';

export default {
  searchInvoice({ commit }, payload) {
    console.log('Beginning to connect server. Data to being transmit:', payload);
    commit(SEARCH_INVOICE);
    axios.post(`${API_BASE}/`, payload).then((response) => {
      if (response.status === 200) {
        console.log('Server respond with status 200: Invoice found. Fetching data:', response.data);
        commit(SEARCH_INVOICE_SUCCESS_FOUND, response.data);
      } else {
        console.log('Server respond with status error: Invoice not found. Fetching data:', response.data);
        commit(SEARCH_INVOICE_FAILURE_FOUND, response.data);
      }
    }).catch(() => {
      console.log('Error to connect server, this is maybe CORS or server is crashed !', payload);
      commit(SEARCH_INVOICE_FAILURE, payload);
    });
  },
  validForm({ commit }, payload) {
    console.log('Beginning to validate data. Data to being validate:', payload);
    commit(VALIDATE_FORM);
    if (payload.patient) {
      console.log('Input patientName is Valid !');
      commit(VALID_FORM_PATIENT, payload.patient);
    } else {
      console.log('Input patientName is Invalid !');
      commit(INVALID_FORM_PATIENT);
    }
    if (NUMBER_REG_EXP.test(payload.number)) {
      console.log('Input invoiceNumber is Valid !');
      commit(VALID_FORM_NUMBER, payload.number.match(NUMBER_REG_EXP)[0]);
    } else {
      console.log('Input invoiceNumber is Invalid !');
      commit(INVALID_FORM_NUMBER);
    }
  },
};
