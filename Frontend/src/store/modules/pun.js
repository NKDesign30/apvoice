/* eslint-disable no-param-reassign */

import UserService from "@/services/api/UserService";
import { PHARMACIES_FETCH_PUN, PHARMACIES_UPDATE_PUN_ACTION } from "../types/action-types";
import { PHARMACIES_UPDATE_PUN } from "../types/mutation-types";

export default {
  state: {
    pun: "no data",
    name: "no data"
  },

  mutations: {
    [PHARMACIES_UPDATE_PUN](state, PharmacyData) {
      state.pun = PharmacyData.pharmacy_unique_number;
      state.name = PharmacyData.name;
    }
  },

  actions: {
    [PHARMACIES_FETCH_PUN]({ state, dispatch, commit }) {
      return new Promise((resolve, reject) => {
        UserService.fetchCurrentUserPunCode().then(PharmacyData => {
          console.log("dispatch2");
          console.log(PharmacyData);
          resolve(PharmacyData);
          commit(PHARMACIES_UPDATE_PUN, PharmacyData);
        });
      });
    },
    [PHARMACIES_UPDATE_PUN_ACTION]({ state, dispatch, commit }, code) {
      return new Promise((resolve, reject) => {
        UserService.updateUserPun(code).then(result => {
          resolve(result.data);
        });
      });
    }
  },
  getters: {
    getPun(state) {
      return state.pun;
    },
    getName(state) {
      return state.name;
    }
  }
};
