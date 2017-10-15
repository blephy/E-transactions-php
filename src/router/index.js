import Vue from 'vue';
import Router from 'vue-router';
import Index from '@/pages/Index';
import Meta from 'vue-meta';

Vue.use(Router);
Vue.use(Meta);

export default new Router({
  // mode: 'history',
  routes: [
    {
      path: '/',
      name: 'Index',
      component: Index,
    },
  ],
});
