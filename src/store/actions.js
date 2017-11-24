import axios from 'axios';
import md5 from 'js-md5';

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
  REF_REG_EXP_WITHOUT,
  MAIL_REG_EXP,
  DDN_REG_EXP,
  DDN_REG_EXP_WITHOUT,
} from './regexp';

export default {
  searchInvoice({ commit }, payload) {
    console.log('Beginning to connect server. Data to being transmit:', payload);

    function yyyymmdd(date) {
      const mm = date.getMonth() + 1; // getMonth() is zero-based
      const dd = date.getDate();
      return [date.getFullYear(), (mm > 9 ? '' : '0') + mm, (dd > 9 ? '' : '0') + dd].join('');
    }
    const DATE = new Date();
    const TICKET = md5([yyyymmdd(DATE), payload.ref, 'petit'].join(''));

    commit(SEARCH_INVOICE);
    axios.get('https://resultats.anapath.fr/cts/cts/index.php', {
      params: {
        mail: payload.mail,
        ref: payload.ref,
        ddn: payload.ddn,
        app: 'anapath',
        action: 'get_price',
        ticket: TICKET,
      },
      timeout: 8000,
      responseType: 'json',
      withCredentials: true,
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      validateStatus: function statusCheck(status) {
        return status >= 200 && status <= 204;
      },
    }).then((response) => {
      if (response.status === 200) {
        console.log('Server respond with status 200: Invoice found. Fetching data:', response.data);
        commit(SEARCH_INVOICE_SUCCESS_FOUND, response.data);
      } else if (response.status === 204) {
        console.log('Server respond with status 204: Invoice not found. Fetching data:', response.data);
        commit(SEARCH_INVOICE_FAILURE_FOUND, response.data);
      } else {
        console.log('Server respond with unknow or no permit status. Data:', response);
        commit(SEARCH_INVOICE_FAILURE, payload);
      }
    }).catch((error) => {
      if (error.response) {
        console.log('Error API Answer:');
        console.log('Header: ', error.response.headers);
        console.log('Status: ', error.response.status);
        console.log('Data: ', error.response.data);
      } else {
        console.log('Connexion fail. This is maybe CORS, or API down, or bad client internet accès.', error);
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
      commit(VALID_FORM_DDN, payload.ddn.replace(/[.-]/gi, '/'));
    } else if (DDN_REG_EXP_WITHOUT.test(payload.ddn)) {
      console.log('Input patientDDN is Valid !');
      const DDN_WITH = [payload.ddn.substr(0, 2), '/', payload.ddn.substr(2, 2), '/', payload.ddn.substr(4, 4)].join('');
      commit(VALID_FORM_DDN, DDN_WITH);
    } else {
      console.log('Input patientDDN is Invalid !');
      commit(INVALID_FORM_DDN);
    }
    if (REF_REG_EXP.test(payload.ref)) {
      console.log('Input invoiceRef is Valid !');
      commit(VALID_FORM_REF, payload.ref.replace(/[.-]/gi, '/').toUpperCase());
    } else if (REF_REG_EXP_WITHOUT.test(payload.ref)) {
      console.log('Input invoiceRef is Valid !');
      const REF_WITH = [payload.ref.substr(0, 3), '/', payload.ref.substr(3)].join('');
      commit(VALID_FORM_REF, REF_WITH.toUpperCase());
    } else {
      console.log('Input invoiceRef is Invalid !');
      commit(INVALID_FORM_REF);
    }
  },
};
