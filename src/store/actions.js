import axios from 'axios';
import {
  SEARCH_INVOICE,
  SEARCH_INVOICE_SUCCESS_FOUND,
  SEARCH_INVOICE_FAILURE_FOUND,
  SEARCH_INVOICE_FAILURE,
  VALIDATE_FORM,
  INVALID_FORM_REF,
  INVALID_FORM_MAIL,
  INVALID_FORM_DDN,
  VALID_FORM_REF,
  VALID_FORM_MAIL,
  VALID_FORM_DDN,
} from './mutations-types';
import {
  REF_REG_EXP,
  MAIL_REG_EXP,
  DDN_REG_EXP,
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
      } else if (response.status === 404) {
        console.log('Server respond with status 404: Invoice not found. Fetching data:', response.data);
        commit(SEARCH_INVOICE_FAILURE_FOUND, response.data);
      } else {
        console.log('Server respond with unknow or no permit status. Data:', response);
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
    if (MAIL_REG_EXP.test(payload.mail)) {
      console.log('Input patientMail is Valid !');
      commit(VALID_FORM_MAIL, payload.mail);
    } else {
      console.log('Input patientMail is Invalid !');
      commit(INVALID_FORM_MAIL);
    }
    if (DDN_REG_EXP.test(payload.ddn)) {
      console.log('Input patientDDN is Valid !');
      commit(VALID_FORM_DDN, payload.ddn.match(DDN_REG_EXP)[0]);
    } else {
      console.log('Input patientDDN is Invalid !');
      commit(INVALID_FORM_DDN);
    }
    if (REF_REG_EXP.test(payload.ref)) {
      console.log('Input invoiceRef is Valid !');
      commit(VALID_FORM_REF, payload.ref.match(REF_REG_EXP)[0]);
    } else {
      console.log('Input invoiceRef is Invalid !');
      commit(INVALID_FORM_REF);
    }
  },
};
