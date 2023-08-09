import {
  SALES_REP_UPDATE_SALES_REP_NAME,
  SALES_REP_RESET_SALES_REP_NAME,
} from '@/store/types/mutation-types';

import {
  SALES_REP_FETCH_BY_EXPERT_CODE,
} from '@/store/types/action-types';

import SalesRepService from '@/services/api/SalesRepService';

export default {
  state: {
    salesRepName: null,
  },

  mutations: {
    [SALES_REP_UPDATE_SALES_REP_NAME](state, updatedSalesRepName) {
      state.salesRepName = updatedSalesRepName;
    },
    [SALES_REP_RESET_SALES_REP_NAME](state) {
      state.salesRepName = null;
    },
  },

  actions: {
    [SALES_REP_FETCH_BY_EXPERT_CODE]({ commit }, expertCode) {
      SalesRepService.fetchByExpertCode(expertCode)
        .then(({ name }) => {
          commit(SALES_REP_UPDATE_SALES_REP_NAME, name);
        })
        .catch(console.error);
    },
  },

  getters: {
    salesRepName(state) {
      return state.salesRepName;
    },
  },
};
