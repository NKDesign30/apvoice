import store from '@/store';
import { AUTH_LOGOUT } from '@/store/types/action-types';

// eslint-disable-next-line import/prefer-default-export
export const refreshSessionTimer = () => {
  /* eslint-disable no-underscore-dangle */
  if (window._sessionTimer) {
    clearInterval(window._sessionTimer);
  }
  window._sessionTimer = setInterval(() => {
    clearInterval(window._sessionTimer);
    store.dispatch(AUTH_LOGOUT);
  }, 1000 * 60 * 31);
  /* eslint-enable no-underscore-dangle */
};
