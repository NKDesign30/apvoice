/* eslint-disable no-param-reassign */

import forEach from 'lodash/forEach';
import {
  PAGES_ADD_PAGE,
  PAGES_FETCH_MENUS,
  PAGES_SET_CURRENT_PAGE,
  PAGES_FETCH_PAGE_PERMISSIONS,
} from '@/store/types/action-types';
import {
  PAGES_UPDATE,
  PAGES_UPDATE_CURRENT,
  PAGES_UPDATE_MENUS,
  PAGES_UPDATE_PAGE_PERMISSIONS,
} from '@/store/types/mutation-types';
import MenuService from '@/services/api/MenuService';
import PageService from '@/services/api/PageService';

export default {
  state: {
    menus: {},

    currentPage: {
      id: '',
    },

    pages: [],

    stages: [],

    pageContent: [],

    pagePermissions: [],
  },

  mutations: {
    [PAGES_UPDATE_MENUS](state, updatedMenus) {
      state.menus = updatedMenus;
    },

    [PAGES_UPDATE](state, updatedPages) {
      state.pages = updatedPages;
    },

    [PAGES_UPDATE_CURRENT](state, updatedCurrentPage) {
      state.currentPage = updatedCurrentPage;
    },

    [PAGES_UPDATE_PAGE_PERMISSIONS](state, updatedPagePermissions) {
      state.pagePermissions = updatedPagePermissions;
    },

    addStage(state, data) {
      if (state.stages.filter(stage => stage.name === data.name).length !== 1) {
        state.stages.push({ name: data.name, stage: data.stage ? data.stage : 'NO STAGE' });
      }
    },

    addPageContent(state, data) {
      state.pageContent = data;
    },
  },

  actions: {
    [PAGES_FETCH_MENUS]({ state, commit, dispatch }) {
      MenuService.fetchAll()
        .then(menus => {
          commit(PAGES_UPDATE_MENUS, { ...state.menus, ...menus });

          forEach(menus, menu => {
            menu.items
              .filter(({ object }) => object === 'page')
              // eslint-disable-next-line max-len
              .forEach(({
                objectId: id, url: path, isPublic, title,
              }) => dispatch(PAGES_ADD_PAGE, {
                id, path, isPublic, title,
              }));
          });
        })
        .catch(error => {
          console.log('Fetching menu failed!', error);
        });
    },

    [PAGES_ADD_PAGE]({ state, commit }, newPage) {
      const pageExists = state.pages.some(page => page.id === newPage.id);

      if (!pageExists) {
        commit(PAGES_UPDATE, state.pages.concat(newPage));
      }
    },

    [PAGES_SET_CURRENT_PAGE]({ commit }, newCurrentPage) {
      delete newCurrentPage.acf.public_resource;

      commit(PAGES_UPDATE_CURRENT, newCurrentPage);
    },

    [PAGES_FETCH_PAGE_PERMISSIONS]({ commit, state, dispatch }) {
      if (state.pagePermissions.length === 0) {
        dispatch('wait/start', 'pagePermissions', { root: true });
      }

      PageService.fetchPagePermissions()
        .then(permissions => {
          commit(PAGES_UPDATE_PAGE_PERMISSIONS, permissions);
          dispatch('wait/end', 'pagePermissions', { root: true });
        })
        .catch(error => {
          console.log('Fetching page permissions failed!', error);
        });
    },
  },

  getters: {
    pagePermissions(state) {
      return state.pagePermissions;
    },
  },
};
