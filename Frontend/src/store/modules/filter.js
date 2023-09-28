import {
  FILTER_TRAININGS,
  FILTER_CATEGORY,
  CLEAR_TRAININGS,
  SHOW_TAB,
  CLICK,
  SCROLL,
} from '../types/action-types';
import {
  FILTER_TRAININGSM, FILTER_CATEGORYM, CLEAR_TRAININGSM, SHOW_TABM, CLICKM,
} from '../types/mutation-types';


export default {
  state: {
    categoriesIds: [],
    categoryCategoriesIds: [],
    showProductSeries: !!(window.location.hash && window.location.hash === '#products'),
    scroll: 0,
  },

  mutations: {
    [FILTER_TRAININGSM](state, categoryId) {
      if (state.categoriesIds.includes(categoryId)) {
        const index = state.categoriesIds.indexOf(categoryId);
        state.categoriesIds.splice(index, 1);
      } else {
        state.categoriesIds.push(categoryId);
      }
    },
    [FILTER_CATEGORYM](state, categoryId) {
      if (state.categoryCategoriesIds.includes(categoryId)) {
        const index = state.categoryCategoriesIds.indexOf(categoryId);
        state.categoryCategoriesIds.splice(index, 1);
      } else {
        state.categoryCategoriesIds.push(categoryId);
      }
    },
    [CLEAR_TRAININGSM](state) {
      state.categoriesIds = [];
    },
    [SHOW_TABM](state) {
      state.showProductSeries = true;
      state.scroll = 1;
    },
    [CLICKM](state) {
      state.showProductSeries = !state.showProductSeries;
    },
  },

  actions: {

    [FILTER_TRAININGS]({ commit }, categoryId) {
      commit(FILTER_TRAININGSM, categoryId);
    },

    [FILTER_CATEGORY]({ commit }, categoryId) {
      commit(FILTER_CATEGORYM, categoryId);
    },

    [CLEAR_TRAININGS]({ commit }) {
      commit(CLEAR_TRAININGSM);
    },

    [SHOW_TAB]({ commit }) {
      commit(SHOW_TABM);
    },

    [CLICK]({ commit }) {
      commit(CLICKM);
    },
    [SCROLL]({ commit }) {
      commit(CLICKM);
    },
  },

  getters: {
    categoriesIds(state) {
      return (state.categoriesIds);
    },
    categoryCategoriesIds(state) {
      return state.categoryCategoriesIds; // Neu hinzugefügt für Kategorien
    },
    showProductSeries(state) {
      return (state.showProductSeries);
    },
    getscroll(state) {
      return (state.showProductSeries);
    },
  },
};
