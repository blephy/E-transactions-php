import {
  SEARCH_INVOICE,
  SEARCH_INVOICE_FAILURE,
  SEARCH_INVOICE_SUCCESS_FOUND,
  SEARCH_INVOICE_FAILURE_FOUND,
} from './mutations-types';

export default {
  [SEARCH_INVOICE](state) {
    state.showLoader = true;
  },
  [SEARCH_INVOICE_SUCCESS_FOUND](state, payload) {
    state.showLoader = false;
    state.invoice = Object.assign(state.invoice, payload);
    state.errorConnect = false;
    state.found = 1;
  },
  [SEARCH_INVOICE_FAILURE_FOUND](state, payload) {
    state.showLoader = false;
    state.invoice = Object.assign(state.invoice, payload);
    state.errorConnect = false;
    state.found = 2;
  },
  [SEARCH_INVOICE_FAILURE](state, payload) {
    state.showLoader = false;
    state.invoice = Object.assign(state.invoice, payload);
    state.errorConnect = true;
  },
};
