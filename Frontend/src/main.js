import 'animate.css/animate.min.css';
import axios from 'axios';
import Vue from 'vue';
import App from '@/App.vue';
import i18n from '@/i18n';
import router from '@/router';
import store from '@/store';
import { SETTINGS_SET_THEME } from '@/store/types/action-types';
import wait from '@/wait';
import '@/bootstrap/plugins';
import '@/bootstrap/filters';
import '@/bootstrap/svgs';
import '@/bootstrap/transitions';
import '@/bootstrap/directives';
import '@/bootstrap/global-components';
import '@/assets/scss/app.scss';
import { refreshSessionTimer } from '@/bootstrap/session-timer';

/* import the fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core'

/* import specific icons */
import { faPen } from '@fortawesome/free-solid-svg-icons'

/* import font awesome icon component */
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

/* add icons to the library */
library.add(faPen)

/* add font awesome icon component */
Vue.component('font-awesome-icon', FontAwesomeIcon)


window.handleTooltips = e => {
  e.classList.toggle('tooltip--is-active');
};

require('promise.prototype.finally').shim();
require('intersection-observer');

window.Intl = require('intl');
require('intl/locale-data/jsonp/en-US');
require('intl/locale-data/jsonp/es-ES');

require('./assets/fonts/frutiger-lt-std');

Vue.config.productionTip = false;

window.eventBus = new Vue();

require('./events');

const baseURL = process.env.VUE_APP_BACKEND_URL;

window.axios = axios.create({ baseURL });
window.axiosCancelToken = axios.CancelToken;

router.beforeEach((to, from, next) => {
  const { isAuthenticated } = store.getters;

  if (isAuthenticated) {
    refreshSessionTimer();
  }

  if (to.meta.requiresAuth && !isAuthenticated && to.path !== '/') {
    if (to.fullPath) {
      next({ path: '/', query: { redirect_path: to.fullPath } });
    } else {
      next({ path: '/' });
    }
  }

  if (to.meta.theme) {
    store.dispatch(SETTINGS_SET_THEME, to.meta.theme);
  }

  return next();
});

// Filters

Vue.filter('formatContent', value => ((!value) ? '' : value.replace(/((?!<sup>\s*))&reg;((?!\s*<\/sup>))/gi, '<sup>&reg;</sup>')
  .replace(/((?!<sup>\s*))®((?!\s*<\/sup>))/gi, '<sup>&reg;</sup>')));

new Vue({
  router,
  store,
  i18n,
  wait,
  render: h => h(App),
}).$mount('#app');
