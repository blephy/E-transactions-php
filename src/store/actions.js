import axios from 'axios';
import {
  SEARCH_INVOICE,
  SEARCH_INVOICE_SUCCESS_FOUND,
  SEARCH_INVOICE_FAILURE_FOUND,
  SEARCH_INVOICE_FAILURE,
} from './mutations-types';

const API_BASE = 'http://anapath.fr';

export default {
  searchInvoice({ commit }, payload) {
    console.log('Beginning to connect server. Data to being transmit:', payload);
    commit(SEARCH_INVOICE);
    axios.post(`${API_BASE}`, payload).then((response) => {
      if (response.status === '200') {
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
};
