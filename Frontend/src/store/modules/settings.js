/* eslint-disable no-param-reassign */

import SettingsService from '@/services/api/SettingsService';
import LanguageService from '@/services/settings/LanguageService';
import {
  SETTINGS_FETCH_SETTINGS,
  SETTINGS_CREATE_INVITATIONS,
  SETTINGS_SET_THEME,
  SETTINGS_SET_LANGUAGE,
  SETTINGS_SET_CURRENT_VIEWPORT,
} from '../types/action-types';
import {
  SETTINGS_UPDATE_THEME,
  SETTINGS_UPDATE_LANGUAGE,
  SETTINGS_UPDATE_SETTINGS,
  SETTINGS_UPDATE_CURRENT_VIEWPORT,
  SETTINGS_UPDATE_NOTIFICATION,
  SETTINGS_CLEAR_NOTIFICATION,
  SETTINGS_LOADED,
} from '../types/mutation-types';

export default {
  state: {
    settingsLoaded: false,
    theme: 'default',
    language: LanguageService.resolve(),
    currentViewport: 'mobile',
    settings: {
      frontendUrl: '',
      formLocations: [],
      jobRoles: [],
      showVoucher: [],
      headCodeSnippets: '',
      bodyCodeSnippets: '',
      bonagoVoucherUrl: '',
      captchaWebsiteKey: '',
      newsletterPopover: '',
      newsletterPrivacy: '',
      sites: [],
      invitationCodes: [],
    },
    notification: {
      show: false,
      message: null,
    },
  },

  mutations: {
    [SETTINGS_UPDATE_THEME](state, newTheme) {
      state.theme = newTheme;
    },

    [SETTINGS_UPDATE_LANGUAGE](state, newLanguage) {
      state.language = newLanguage;
    },

    [SETTINGS_UPDATE_SETTINGS](state, newSettings) {
      state.settings = { ...state.settings, ...newSettings };
    },

    [SETTINGS_UPDATE_CURRENT_VIEWPORT](state, newCurrentViewport) {
      state.currentViewport = newCurrentViewport;
    },

    [SETTINGS_UPDATE_NOTIFICATION](state, notification) {
      state.notification = notification;
    },

    [SETTINGS_CLEAR_NOTIFICATION](state) {
      state.notification = { show: false, message: null };
    },

    [SETTINGS_LOADED](state, loaded) {
      state.settingsLoaded = loaded;
    },
  },

  actions: {
    [SETTINGS_SET_THEME]({ commit }, newTheme) {
      commit(SETTINGS_UPDATE_THEME, newTheme);
    },

    [SETTINGS_SET_LANGUAGE]({ commit }, newLanguage) {
      commit(SETTINGS_UPDATE_LANGUAGE, newLanguage);
    },

    [SETTINGS_FETCH_SETTINGS]({ dispatch, commit }) {
      dispatch('wait/start', 'settings', { root: true });
      SettingsService.fetchAll()
        .then(settings => {
          commit(SETTINGS_UPDATE_SETTINGS, settings);
          commit(SETTINGS_LOADED, true);

          dispatch('wait/end', 'settings', { root: true });
        })
        .catch(error => {
          console.log('Error while fetching settings!', error);
        });
    },

    [SETTINGS_CREATE_INVITATIONS]({ commit }) {
      SettingsService.createInvitations()
        .then(notification => {
          console.log(notification);
          commit(SETTINGS_UPDATE_NOTIFICATION, { show: true, message: notification });
        })
        .catch(error => {
          console.log('Error while fetching settings!', error);
        });
    },

    [SETTINGS_SET_CURRENT_VIEWPORT]({ commit }, newCurrentViewport) {
      commit(SETTINGS_UPDATE_CURRENT_VIEWPORT, newCurrentViewport);
    },
  },

  getters: {
    theme(state) {
      return state.theme;
    },

    language(state) {
      return state.language;
    },

    currentViewport(state) {
      return state.currentViewport;
    },

    settingsLoaded(state) {
      return state.settingsLoaded;
    },

    getForm(state) {
      return key => state.settings.formLocations.find(form => form.key === key);
    },

    bonagoVoucherUrl(state) {
      return state.settings.bonagoVoucherUrl;
    },

    captchaWebsiteKey(state) {
      return state.settings.captchaWebsiteKey;
    },

    filteredSites(state) {
      return state.settings.sites.filter(site => !site.current);
    },
  },
};
