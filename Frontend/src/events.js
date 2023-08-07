import store from '@/store';
import {
  AUTH_FETCH_CURRENT_USER,
  PHARMACIES_FETCH_PHARMACIES,
  DETAILERS_JOB_FETCH_INFORMATIONAL_TRAININGS,
  DETAILERS_JOB_FETCH_SAVED_STATES,
  PAGES_FETCH_PAGE_PERMISSIONS,
  AUTH_REFRESH,
} from './store/types/action-types';

const refreshAxiosInstance = () => {
  if (store.getters.isAuthenticated) {
    window.axios.defaults.headers.common.Authorization = `Bearer ${store.state.auth.token.raw}`;
    /* eslint-disable no-underscore-dangle */
    if (window._tokenAccessTimer) {
      clearInterval(window._tokenAccessTimer);
    }
    window._tokenAccessTimer = setInterval(() => {
      store.dispatch(AUTH_REFRESH);
    }, 1000 * 60 * 25);
    /* eslint-enable no-underscore-dangle */
  } else {
    delete window.axios.defaults.headers.common.Authorization;
  }
};

window.eventBus.$on('authenticated', () => {
  console.log('User has been authenticated...');

  // Set authorization headers
  refreshAxiosInstance();

  // In the STAGING environment there is HTTP Basic Auth enabled, which
  // overwrites the Authorization headers. In order for Wordpress to function
  // correctly, we need to provide the Auth token in an extra header, which
  // is then used by Nginx to overwrite the Authorization header with that value.
  if (process.env.NODE_ENV !== 'development' && process.env.VUE_APP_WITH_X_AUTHORIZATION_HEADER === 'true') {
    window.axios.defaults.headers.common['X-APO-AUTH'] = `Bearer ${store.state.auth.token.raw}`;
  }

  // Load state that requires an authenticated user
  store.dispatch(AUTH_FETCH_CURRENT_USER);
  store.dispatch(PAGES_FETCH_PAGE_PERMISSIONS);
  store.dispatch(PHARMACIES_FETCH_PHARMACIES);
  store.dispatch(DETAILERS_JOB_FETCH_INFORMATIONAL_TRAININGS);
  store.dispatch(DETAILERS_JOB_FETCH_SAVED_STATES);
});

window.eventBus.$on('recivedAccessToken', () => {
  refreshAxiosInstance();
});
