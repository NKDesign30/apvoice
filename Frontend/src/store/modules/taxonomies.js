/* eslint-disable no-param-reassign */
import TaxonomyService from '@/services/api/TaxonomyService';
import {
  TAXONOMIES_FETCH_ALL, TAXONOMIES_FETCH_TRAINING_CATEGORIES, TAXONOMIES_FETCH_DOWNLOAD_PRODUCTS, TAXONOMIES_FETCH_DOWNLOAD_CATEGORIES, TAXONOMIES_FETCH_DOWNLOAD_MEDIATYPES,
} from '../types/action-types';
import {
  TAXONOMIES_UPDATE_ALL_TAXONOMIES, TAXONOMIES_UPDATE_TRAINING_CATEGORIES, TAXONOMIES_UPDATE_DOWNLOAD_PRODUCTS, TAXONOMIES_UPDATE_DOWNLOAD_CATEGORIES, TAXONOMIES_UPDATE_DOWNLOAD_MEDIATYPES,
} from '../types/mutation-types';

export default {
  state: {
    taxonomies: [],
    trainingCategories: [],
    downloadCategories: [],
    downloadProducts: [],
    downloadMediatypes: [],
  },

  mutations: {
    [TAXONOMIES_UPDATE_ALL_TAXONOMIES](state, updatedTaxonomies) {
      state.taxonomies = updatedTaxonomies;
    },
    [TAXONOMIES_UPDATE_TRAINING_CATEGORIES](state, updatedTrainingCategories) {
      state.trainingCategories = updatedTrainingCategories;
    },
    [TAXONOMIES_UPDATE_DOWNLOAD_CATEGORIES](state, updatedDownloadCategories) {
      state.downloadCategories = updatedDownloadCategories;
    },
    [TAXONOMIES_UPDATE_DOWNLOAD_PRODUCTS](state, updatedDownloadProducts) {
      state.downloadProducts = updatedDownloadProducts;
    },
    [TAXONOMIES_UPDATE_DOWNLOAD_MEDIATYPES](state, updatedDownloadMediatypes) {
      state.downloadMediatypes = updatedDownloadMediatypes;
    },
  },

  actions: {
    [TAXONOMIES_FETCH_ALL]({ commit }) {
      return new Promise((resolve, reject) => {
        TaxonomyService.fetchAll()
          .then(taxonomies => {
            commit(TAXONOMIES_UPDATE_ALL_TAXONOMIES, taxonomies);
            resolve(taxonomies);
          }).catch(reject);
      });
    },
    [TAXONOMIES_FETCH_TRAINING_CATEGORIES]({ commit }) {
      return new Promise((resolve, reject) => {
        TaxonomyService.fetchTrainingCategories()
          .then(trainingCategories => {
            commit(TAXONOMIES_UPDATE_TRAINING_CATEGORIES, trainingCategories);
            resolve(trainingCategories);
          }).catch(reject);
      });
    },
    [TAXONOMIES_FETCH_DOWNLOAD_CATEGORIES]({ commit }) {
      return new Promise((resolve, reject) => {
        TaxonomyService.fetchDownloadCategories()
          .then(downloadCategories => {
            commit(TAXONOMIES_UPDATE_DOWNLOAD_CATEGORIES, downloadCategories);
            resolve(downloadCategories);
          }).catch(reject);
      });
    },
    [TAXONOMIES_FETCH_DOWNLOAD_PRODUCTS]({ commit }) {
      return new Promise((resolve, reject) => {
        TaxonomyService.fetchDownloadProducts()
          .then(downloadProducts => {
            commit(TAXONOMIES_UPDATE_DOWNLOAD_PRODUCTS, downloadProducts);
            resolve(downloadProducts);
          }).catch(reject);
      });
    },
    [TAXONOMIES_FETCH_DOWNLOAD_MEDIATYPES]({ commit }) {
      return new Promise((resolve, reject) => {
        TaxonomyService.fetchDownloadMediatypes()
          .then(downloadMediatypes => {
            commit(TAXONOMIES_UPDATE_DOWNLOAD_MEDIATYPES, downloadMediatypes);
            resolve(downloadMediatypes);
          }).catch(reject);
      });
    },
  },

  getters: {
    taxonomies(state) {
      return state.taxonomies;
    },
    trainingCategories(state) {
      return state.trainingCategories;
    },
    trainingCategory(state) {
      return id => state.trainingCategories.find(category => category.id === id);
    },
    downloadCategories(state) {
      return state.downloadCategories;
    },
    downloadProducts(state) {
      return state.downloadProducts;
    },
    downloadMediatypes(state) {
      return state.downloadMediatypes;
    },
  },
};
