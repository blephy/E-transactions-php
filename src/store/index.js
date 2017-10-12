import Vue from 'vue';
import Vuex from 'vuex';
import states from './states';
import invoiceMutations from './mutations';
import invoiceActions from './actions';

Vue.use(Vuex);

export default new Vuex.Store({
  strict: true,
  state: states,
  mutations: Object.assign({}, invoiceMutations),
  actions: Object.assign({}, invoiceActions),
});
