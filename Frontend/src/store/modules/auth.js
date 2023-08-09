/* eslint-disable no-param-reassign */

import jwt from 'jsonwebtoken';
import get from 'lodash/get';
import isEmpty from 'lodash/isEmpty';
import { isJwtValid } from '@/services/utils';
import {
  AUTH_FETCH_CURRENT_USER,
  AUTH_LOGIN,
  AUTH_LOGOUT,
  AUTH_REFRESH,
  AUTH_LOGOUT_WITHOUT_REDIRECT,
  AUTH_FETCH_USER_LEVEL_DATA,
} from '../types/action-types';
import { LOCAL_STORAGE_TOKEN_KEY, LOCAL_STORAGE_USER_KEY } from './constants';
import {
  AUTH_UPDATE_TOKEN,
  AUTH_UPDATE_USER,
  AUTH_UPDATE_SHOW_UPDATE_PHARMACY_MODAL,
  AUTH_UPDATE_USER_LEVEL_DATA,
} from '../types/mutation-types';
import UserService from '@/services/api/UserService';
import AuthService from '@/services/api/AuthService';

const RAW_INITIAL_TOKEN_STATE = {
  header: {
    alg: '',
    typ: '',
  },
  payload: {
    data: {
      user: {
        id: '',
      },
    },
    exp: '',
    iat: '',
    iss: '',
    nbf: '',
    signature: '',
  },
  raw: '',
};

const RAW_INITIAL_USER_STATE = {
  id: -1,
  email: '',
  name: '',
  firstName: '',
  lastName: '',
  profilePicture: {},
  description: '',
  link: '',
  slug: '',
  roles: [],
  url: '',
  loginActivity: 0,
  expertPoints: 0,
  newsletterState: true,
  pun: '',
  levelData: {
    level: 0,
    completed_trainings: 0,
  },
};

let INITIAL_TOKEN_STATE = { ...RAW_INITIAL_TOKEN_STATE };
let INITIAL_USER_STATE = { ...RAW_INITIAL_USER_STATE };

let isUserValid = false;
let isTokenValid = false;
const storedUser = localStorage.getItem(LOCAL_STORAGE_USER_KEY);
const storedToken = localStorage.getItem(LOCAL_STORAGE_TOKEN_KEY);

// Restore user state
if (storedUser !== null) {
  try {
    const parsedUser = JSON.parse(storedUser);

    INITIAL_USER_STATE = {
      ...INITIAL_USER_STATE,
      ...parsedUser,
    };

    isUserValid = true;
  } catch (e) {
    console.log('Local user data is invalid.');
  }
}

// Restore token state
if (storedToken !== null) {
  const decodedToken = jwt.decode(storedToken, { complete: true });

  if (decodedToken !== null && isJwtValid(decodedToken)) {
    const tokenUserId = get(decodedToken, 'payload.data.user.id', '');
    const userId = INITIAL_USER_STATE.id;

    // Verify that stored token matches stored user
    if (tokenUserId >= 0 && userId >= 0 && tokenUserId === userId) {
      INITIAL_TOKEN_STATE = {
        ...INITIAL_TOKEN_STATE,
        ...decodedToken,
        raw: storedToken,
      };

      isTokenValid = true;
    }
  }
}

if (!isUserValid) {
  localStorage.removeItem(LOCAL_STORAGE_USER_KEY);
}

if (!isTokenValid) {
  localStorage.removeItem(LOCAL_STORAGE_TOKEN_KEY);
}

export default {
  state: {
    token: {
      ...INITIAL_TOKEN_STATE,
    },
    user: {
      ...INITIAL_USER_STATE,
    },
    showUpdatePharmacyModal: false,
  },

  mutations: {
    [AUTH_UPDATE_TOKEN](state, updatedToken) {
      state.token = updatedToken;

      localStorage.setItem(LOCAL_STORAGE_TOKEN_KEY, updatedToken.raw);
      window.eventBus.$emit('recivedAccessToken');
    },

    [AUTH_UPDATE_USER](state, updatedUser) {
      state.user = updatedUser;

      localStorage.setItem(LOCAL_STORAGE_USER_KEY, JSON.stringify(updatedUser));
    },

    [AUTH_UPDATE_SHOW_UPDATE_PHARMACY_MODAL](state, status) {
      state.showUpdatePharmacyModal = status;
    },

    [AUTH_UPDATE_USER_LEVEL_DATA](state, levelData) {
      state.user.levelData = levelData;
    },
  },

  actions: {
    [AUTH_LOGIN]({ state, commit }, { token, user }) {
      return new Promise(resolve => {
        const decodedToken = jwt.decode(token, { complete: true });

        // Invalid token
        if (decodedToken === null) {
          return;
        }

        commit(AUTH_UPDATE_TOKEN, {
          ...decodedToken,
          raw: token,
        });

        commit(AUTH_UPDATE_USER, {
          ...state.user,
          id: get(decodedToken, 'payload.data.user.id', ''),
          ...user,
        });

        resolve();
      });
    },

    [AUTH_LOGOUT]({ commit }) {
      return new Promise(resolve => {
        localStorage.removeItem(LOCAL_STORAGE_USER_KEY);
        localStorage.removeItem(LOCAL_STORAGE_TOKEN_KEY);

        commit(AUTH_UPDATE_TOKEN, RAW_INITIAL_TOKEN_STATE);
        commit(AUTH_UPDATE_USER, RAW_INITIAL_USER_STATE);
        window.location.href = '/';
        resolve();
      });
    },

    [AUTH_LOGOUT_WITHOUT_REDIRECT]({ commit }) {
      return new Promise(resolve => {
        localStorage.removeItem(LOCAL_STORAGE_USER_KEY);
        localStorage.removeItem(LOCAL_STORAGE_TOKEN_KEY);

        commit(AUTH_UPDATE_TOKEN, RAW_INITIAL_TOKEN_STATE);
        commit(AUTH_UPDATE_USER, RAW_INITIAL_USER_STATE);
        resolve();
      });
    },

    [AUTH_FETCH_CURRENT_USER]({ state, dispatch, commit }) {
      dispatch('wait/start', 'auth.user', { root: true });

      UserService.fetchCurrentUser()
        .then(user => {
          commit(AUTH_UPDATE_USER, {
            ...state.user,
            ...user,
          });

          commit(AUTH_UPDATE_SHOW_UPDATE_PHARMACY_MODAL, !user.hasUpdatedPharmacyAddress);

          dispatch('wait/end', 'auth.user', { root: true });
        })
        .catch(error => {
          console.log('Error fetching current user', error);
        });
    },

    [AUTH_REFRESH]({ dispatch, commit }) {
      return new Promise((resolve, reject) => {
        AuthService.refresh()
          .then(({ token }) => {
            const decodedToken = jwt.decode(token, { complete: true });

            // Invalid token
            if (decodedToken === null) {
              dispatch(AUTH_LOGOUT);
              reject();
            }

            commit(AUTH_UPDATE_TOKEN, {
              ...decodedToken,
              raw: token,
            });

            resolve(token);
          })
          .catch(error => {
            dispatch(AUTH_LOGOUT);
            reject(error);
          });
      });
    },

    [AUTH_FETCH_USER_LEVEL_DATA]({ commit }) {
      return new Promise((resolve, reject) => {
        UserService.fetchUserLevelTrainingsPoints()
          .then(levelData => {
            commit(AUTH_UPDATE_USER_LEVEL_DATA, levelData);
            resolve(levelData);
          })
          .catch(reject);
      });
    },
  },

  getters: {
    isAuthenticated(state) {
      if (state.user.id === '') {
        return false;
      }

      if (!state.token.payload.exp || !state.token.payload.nbf) {
        return false;
      }

      return isJwtValid(state.token);
    },

    user(state) {
      return state.user;
    },

    userId(state) {
      return state.user.id;
    },

    fullName(state) {
      if (!state.user.firstName && !state.user.lastName) {
        return state.user.name;
      }
      return `${state.user.firstName} ${state.user.lastName}`;
    },

    expertPoints(state) {
      return state.user.expertPoints;
    },

    levelData(state) {
      return state.user.levelData;
    },

    profilePicture(state) {
      if (!isEmpty(state.user.profilePicture)) {
        return state.user.profilePicture[250] || state.user.profilePicture.full;
      }
      return '/assets/img/user/no-profile-picture.png';
    },

    loginActivity(state) {
      return state.user.loginActivity;
    },

    canRedeem(state) {
      return state.user.expertPoints >= 50;
    },

    showUpdatePharmacyModal(state) {
      return state.showUpdatePharmacyModal;
    },

  },
};
