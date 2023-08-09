/**
 * A mini-store only for local storage (no api connections involved)
 */
import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    showEnterScientificModal: true
  },
  mutations: {
    saveEnterScientificModalState: (state, modalState) => {
      state.showEnterScientificModal = modalState;
    }
  },
  actions: {},
});
