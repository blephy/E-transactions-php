import {
  SEARCH_INVOICE,
  SEARCH_INVOICE_FAILURE,
  SEARCH_INVOICE_SUCCESS_FOUND,
  SEARCH_INVOICE_FAILURE_FOUND,
  VALIDATE_FORM,
  INVALID_FORM_NUMBER,
  INVALID_FORM_PATIENT,
  VALID_FORM_NUMBER,
  VALID_FORM_PATIENT,
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
  [INVALID_FORM_NUMBER](state) {
    state.showLoader = false;
    state.validForm.number = false;
  },
  [INVALID_FORM_PATIENT](state) {
    state.showLoader = false;
    state.validForm.patient = false;
  },
  [VALID_FORM_PATIENT](state, payload) {
    state.showLoader = false;
    state.invoice.patient = payload;
    state.validForm.patient = true;
  },
  [VALID_FORM_NUMBER](state, payload) {
    state.showLoader = false;
    state.invoice.number = payload;
    state.validForm.number = true;
  },
  [STORE_QUERY](state, payload) {
    state.query.patient = payload.patient;
    state.query.number = payload.number;
  },
};
