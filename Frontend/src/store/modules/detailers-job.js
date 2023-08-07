import {
  DETAILERS_JOB_FETCH_INFORMATIONAL_TRAININGS,
  DETAILERS_JOB_FETCH_SAVED_STATES,
} from '@/store/types/action-types';
import {
  DETAILERS_JOB_UPDATE_INFORMATIONAL_TRAININGS,
  DETAILERS_JOB_UPDATE_SAVED_STATES,
  DETAILERS_JOB_UPDATE_SAVED_STATE,
  DETAILERS_JOB_REMOVE_SAVED_STATE,
} from '@/store/types/mutation-types';
import DetailersJobService from '@/services/api/DetailersJobService';

export default {
  state: {
    informationalTrainings: [],
    savedStates: [],
  },

  mutations: {
    [DETAILERS_JOB_UPDATE_INFORMATIONAL_TRAININGS](state, newInformationalTrainings) {
      state.informationalTrainings = newInformationalTrainings;
    },

    [DETAILERS_JOB_UPDATE_SAVED_STATES](state, newSavedStates) {
      state.savedStates = newSavedStates;
    },

    [DETAILERS_JOB_UPDATE_SAVED_STATE](state, newSavedState) {
      state.savedStates = state.savedStates.map(savedState => {
        if (
          savedState.informationalTrainingId === newSavedState.informationalTrainingId
          && savedState.pharmacyId === newSavedState.pharmacyId
        ) {
          return newSavedState;
        }

        return savedState;
      });
    },

    [DETAILERS_JOB_REMOVE_SAVED_STATE](state, deletedSavedState) {
      state.savedStates = state.savedStates
        .filter(savedState => savedState.pharmacyId === deletedSavedState.pharmacyId
          && savedState.informationalTrainingId !== deletedSavedState.informationalTrainingId);
    },
  },

  actions: {
    [DETAILERS_JOB_FETCH_INFORMATIONAL_TRAININGS]({ state, dispatch, commit }) {
      if (state.informationalTrainings.length === 0) {
        dispatch('wait/start', 'detailersJob.informationalTrainings', { root: true });
      }

      DetailersJobService.fetchInformationalTrainings()
        .then(informationalTrainings => {
          commit(DETAILERS_JOB_UPDATE_INFORMATIONAL_TRAININGS, informationalTrainings);
          dispatch('wait/end', 'detailersJob.informationalTrainings', { root: true });
        })
        .catch(error => {
          console.log('could not fetch informational trainings', error);
        });
    },

    [DETAILERS_JOB_FETCH_SAVED_STATES]({ state, dispatch, commit }) {
      if (state.savedStates.length === 0) {
        dispatch('wait/start', 'detailersJob.savedStates', { root: true });
      }

      DetailersJobService.fetchSavedStates()
        .then(savedStates => {
          commit(DETAILERS_JOB_UPDATE_SAVED_STATES, savedStates);
          dispatch('wait/end', 'detailersJob.savedStates', { root: true });
        })
        .catch(error => {
          console.log('could not fetch informational trainings', error);
        });
    },
  },
};
