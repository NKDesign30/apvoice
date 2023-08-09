/* eslint-disable no-param-reassign */

import PharmacyService from '@/services/api/PharmacyService';
import { PHARMACIES_FETCH_PHARMACIES } from '../types/action-types';
import { PHARMACIES_UPDATE_PHARMACIES } from '../types/mutation-types';

export default {
  state: {
    pharmacies: [],
  },

  mutations: {
    [PHARMACIES_UPDATE_PHARMACIES](state, newPharmacies) {
      state.pharmacies = newPharmacies;
    },
  },

  actions: {
    [PHARMACIES_FETCH_PHARMACIES]({ state, dispatch, commit }) {
      if (state.pharmacies.length === 0) {
        dispatch('wait/start', 'pharmacies', { root: true });
      }

      PharmacyService.fetchAll()
        .then(pharmacies => {
          commit(PHARMACIES_UPDATE_PHARMACIES, pharmacies);
          dispatch('wait/end', 'pharmacies', { root: true });
        })
        .catch(error => {
          console.log('Fetching pharmacies failed!', error);
        });
    },
  },
};
