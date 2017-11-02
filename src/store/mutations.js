import {
  SEARCH_INVOICE,
  SEARCH_INVOICE_FAILURE,
  SEARCH_INVOICE_SUCCESS_FOUND,
  SEARCH_INVOICE_FAILURE_FOUND,
  VALIDATE_FORM,
  INVALID_FORM_REF,
  INVALID_FORM_MAIL,
  INVALID_FORM_DDN,
  VALID_FORM_REF,
  VALID_FORM_MAIL,
  VALID_FORM_DDN,
  STORE_QUERY,
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
  [VALIDATE_FORM](state) {
    state.showLoader = true;
  },
  [INVALID_FORM_REF](state) {
    state.showLoader = false;
    state.validForm.ref = false;
  },
  [INVALID_FORM_MAIL](state) {
    state.showLoader = false;
    state.validForm.mail = false;
  },
  [INVALID_FORM_DDN](state) {
    state.showLoader = false;
    state.validForm.ddn = false;
  },
  [VALID_FORM_MAIL](state, payload) {
    state.showLoader = false;
    state.invoice.mail = payload;
    state.validForm.mail = true;
  },
  [VALID_FORM_REF](state, payload) {
    state.showLoader = false;
    state.invoice.ref = payload;
    state.validForm.ref = true;
  },
  [VALID_FORM_DDN](state, payload) {
    state.showLoader = false;
    state.invoice.ddn = payload;
    state.validForm.ddn = true;
  },
  [STORE_QUERY](state, payload) {
    state.query.mail = payload.mail;
    state.query.ref = payload.ref;
  },
};
