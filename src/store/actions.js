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

const API_BASE = 'https://resultats.anapath.fr';

const configRequest = {
  baseURL: `${API_BASE}/`,
  timeout: 8000,
  responseType: 'json',
  headers: {
    'Content-Type': 'application/x-www-form-urlencoded',
    'Access-Control-Allow-Origin': 'resultats.anapath.fr',
  },
  validateStatus: function statusCheck(status) {
    return status >= 200 && status < 450;
  },
};

export default {
  searchInvoice({ commit }, payload) {
    console.log('Beginning to connect server. Data to being transmit:', payload);
    commit(SEARCH_INVOICE);
    axios.post('/cts/cts/index.php', payload, configRequest).then((response) => {
      if (response.status === 200) {
        console.log('Server respond with status 200: Invoice found. Fetching data:', response.data);
        commit(SEARCH_INVOICE_SUCCESS_FOUND, response.data);
      } else {
        console.log('Server respond with status error: Invoice not found. Fetching data:', response.data);
        commit(SEARCH_INVOICE_FAILURE_FOUND, response.data);
      }
    }).catch((error) => {
      if (error.response) {
        console.log('Error API Answer:');
        console.log('Header: ', error.response.headers);
        console.log('Status: ', error.response.status);
        console.log('Data: ', error.response.data);
      } else {
        console.log('Connexion fail. This is maybe CORS, or API down, or bad client internet accès.');
      }
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
