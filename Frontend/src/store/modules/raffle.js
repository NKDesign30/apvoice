/* eslint-disable no-param-reassign */
import RaffleService from '@/services/api/RaffleService';
import {
  RAFFLE_FETCH_ALL,
  RAFFLE_FETCH_ONE,
} from '../types/action-types';
import { RAFFLE_UPDATE_RAFFLE, RAFFLE_UPDATE_CURRENT_RAFFLE } from '../types/mutation-types';

export default {
  state: {
    raffles: [],
    currentRaffle: {},
  },

  mutations: {
    [RAFFLE_UPDATE_RAFFLE](state, updatedRaffle) {
      state.raffles = updatedRaffle;
    },
    [RAFFLE_UPDATE_CURRENT_RAFFLE](state, updatedCurrentRaffle) {
      state.raffles = updatedCurrentRaffle;
    },
  },

  actions: {
    [RAFFLE_FETCH_ALL]({ dispatch, commit, state }) {
      if (state.raffles.length === 0) {
        dispatch('wait/start', 'raffle', { root: true });
      }

      return new Promise((resolve, reject) => {
        RaffleService.fetchAll()
          .then(raffle => {
            commit(RAFFLE_UPDATE_RAFFLE, raffle);
            dispatch('wait/end', 'raffle', { root: true });
            resolve(raffle);
          }).catch(reject);
      });
    },
    [RAFFLE_FETCH_ONE]({ dispatch, commit }, id) {
      dispatch('wait/start', 'raffle', { root: true });

      return new Promise((resolve, reject) => {
        RaffleService.fetch(id)
          .then(raffle => {
            commit(RAFFLE_UPDATE_CURRENT_RAFFLE, raffle);
            dispatch('wait/end', 'raffle', { root: true });
            resolve(raffle);
          }).catch(reject);
      });
    },
  },

  getters: {
    raffle(state) {
      return state.raffles;
    },
    currentRaffle(state) {
      return state.currentRaffle;
    },
    raffleById(state) {
      return id => state.raffles.find(raffle => raffle.id === id);
    },
  },
};
