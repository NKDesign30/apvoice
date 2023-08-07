/* eslint-disable no-param-reassign */
import TrainingSeriesService from '@/services/api/TrainingSeriesService';
import {
  TRAININGS_FETCH_ALL_SERIES,
  TRAININGS_UPDATE_CURRENT_TRAINING,
  TRAININGS_UPDATE_CURRENT_TRAINING_SERIES,
  AUTH_FETCH_CURRENT_USER,
} from '../types/action-types';
import {
  TRAININGS_UPDATE_TRAINING_SERIES,
  TRAININGS_UPDATE_PREMIUM_TRAINING_SERIES,
  TRAININGS_UPDATE_PRODUCT_TRAINING_SERIES,
  TRAININGS_UPDATE_CATEGORY_TRAINING_SERIES,
  TRAININGS_UPDATE_LATEST_PREMIUM_TRAINING_SERIES,
  TRAININGS_UPDATE_SURVEYS_TRAINING_SERIES,
  TRAININGS_UPDATE_AVAILABLE_TRAINING_SERIES,
  TRAININGS_UPDATE_ONE_TRAINING_SERIES,
  TRAININGS_SET_CURRENT_TRAINING,
  TRAININGS_SET_CURRENT_TRAINING_ID,
  TRAININGS_SET_CURRENT_LESSON_ID,
  TRAININGS_SET_CURRENT_TRAINING_SERIES,
} from '../types/mutation-types';

export default {
  state: {
    trainingSeries: [],
    premiumTrainingSeries: [],
    productTrainingSeries: [],
    categoryTrainingSeries: [],
    latestPremiumTrainingSeries: [],
    surveysTrainingSeries: [],
    availableTrainingSeries: [],
    currentTrainingSeries: {},
    currentTraining: null,
    training_id: null,
    lesson_id: null,
  },

  mutations: {
    [TRAININGS_UPDATE_TRAINING_SERIES](state, updatedTrainingSeries) {
      state.trainingSeries = updatedTrainingSeries;
    },
    [TRAININGS_UPDATE_PREMIUM_TRAINING_SERIES](state, updatedTrainingSeries) {
      state.premiumTrainingSeries = updatedTrainingSeries;
    },
    [TRAININGS_UPDATE_PRODUCT_TRAINING_SERIES](state, updatedUncompletedTrainingSeries) {
      state.productTrainingSeries = updatedUncompletedTrainingSeries;
    },
    [TRAININGS_UPDATE_CATEGORY_TRAINING_SERIES](state, updatedUncompletedTrainingSeries) {
      state.categoryTrainingSeries = updatedUncompletedTrainingSeries;
    },
    [TRAININGS_UPDATE_LATEST_PREMIUM_TRAINING_SERIES](state, updatedLatestPremiumTrainingSeries) {
      state.latestPremiumTrainingSeries = updatedLatestPremiumTrainingSeries;
    },
    [TRAININGS_UPDATE_SURVEYS_TRAINING_SERIES](state, updatedSurveysTrainingSeries) {
      state.surveysTrainingSeries = updatedSurveysTrainingSeries;
    },
    [TRAININGS_UPDATE_AVAILABLE_TRAINING_SERIES](state, updatedAvailableTrainingSeries) {
      state.availableTrainingSeries = updatedAvailableTrainingSeries;
    },
    [TRAININGS_SET_CURRENT_TRAINING_SERIES](state, updatedCurrentTrainingSeries) {
      state.currentTrainingSeries = updatedCurrentTrainingSeries;
    },
    [TRAININGS_SET_CURRENT_TRAINING](state, updatedTraining) {
      state.currentTraining = updatedTraining;
    },
    [TRAININGS_SET_CURRENT_TRAINING_ID](state, updatedTrainingId) {
      state.training_id = updatedTrainingId;
    },
    [TRAININGS_SET_CURRENT_LESSON_ID](state, updatedLessonId) {
      state.lesson_id = updatedLessonId;
    },
    [TRAININGS_UPDATE_ONE_TRAINING_SERIES](state, updatedTrainingSeries) {
      const copiedTrainingSeries = state.trainingSeries.slice();
      const index = state.trainingSeries.findIndex(
        series => series.id === updatedTrainingSeries.id,
      );
      copiedTrainingSeries[index] = updatedTrainingSeries;
      state.trainingSeries = copiedTrainingSeries;
    },
  },

  actions: {
    [TRAININGS_FETCH_ALL_SERIES]({ dispatch, commit, state }) {
      if (state.trainingSeries.length === 0) {
        dispatch('wait/start', 'trainings.series', { root: true });
      }

      return new Promise((resolve, reject) => {
        TrainingSeriesService.fetchAll()
          .then(trainingSeries => {
            commit(TRAININGS_UPDATE_TRAINING_SERIES, trainingSeries);
            dispatch('wait/end', 'trainings.series', { root: true });
            resolve(trainingSeries);
          })
          .catch(reject);
      });
    },
    unlockPremiumContent({ dispatch, commit, state }, id) {
      return new Promise((resolve, reject) => {
        window.axios
          .get(`/wp-json/wc/v2/unlock-premium-training/${id}`)
          .then(({ data }) => {
            dispatch(AUTH_FETCH_CURRENT_USER);
            resolve(data);
          })
          .catch(error => reject(error));
      });
    },
    fetchPremiumTrainingSeries({ dispatch, commit, state }) {
      if (state.trainingSeries.length === 0) {
        dispatch('wait/start', 'premiumTraining.series', { root: true });
      }

      return new Promise((resolve, reject) => {
        TrainingSeriesService.fetchPremium()
          .then(premiumTrainingSeries => {
            commit(TRAININGS_UPDATE_PREMIUM_TRAINING_SERIES, premiumTrainingSeries);
            dispatch('wait/end', 'premiumTraining.series', { root: true });
            resolve(premiumTrainingSeries);
          })
          .catch(reject);
      });
    },
    fetchLatestProductTraining({ dispatch, commit, state }) {
      if (state.productTrainingSeries.length === 0) {
        dispatch('wait/start', 'trainings.latestProductTrainings', { root: true });
      }

      return new Promise((resolve, reject) => {
        TrainingSeriesService.fetchLatestProductTrainings()
          .then(incompleteTrainingSeries => {
            commit(TRAININGS_UPDATE_PRODUCT_TRAINING_SERIES, incompleteTrainingSeries);
            resolve(incompleteTrainingSeries);
            dispatch('wait/end', 'trainings.latestProductTrainings', { root: true });
          })
          .catch(reject);
      });
    },
    fetchLatestCategoryTraining({ dispatch, commit, state }) {
      if (state.categoryTrainingSeries.length === 0) {
        dispatch('wait/start', 'trainings.latestCategoryTrainings', { root: true });
      }

      return new Promise((resolve, reject) => {
        TrainingSeriesService.fetchLatestCategoryTrainings()
          .then(incompleteTrainingSeries => {
            commit(TRAININGS_UPDATE_CATEGORY_TRAINING_SERIES, incompleteTrainingSeries);
            resolve(incompleteTrainingSeries);
            dispatch('wait/end', 'trainings.latestCategoryTrainings', { root: true });
          })
          .catch(reject);
      });
    },
    fetchLatestPremiumTrainingSeries({ dispatch, commit, state }) {
      if (state.latestPremiumTrainingSeries.length === 0) {
        dispatch('wait/start', 'trainings.latestPremiumTrainings', { root: true });
      }
      return new Promise((resolve, reject) => {
        TrainingSeriesService.fetchLatestPremium()
          .then(latestPremiumTrainingSeries => {
            commit(TRAININGS_UPDATE_LATEST_PREMIUM_TRAINING_SERIES, latestPremiumTrainingSeries);
            resolve(latestPremiumTrainingSeries);
            dispatch('wait/end', 'trainings.latestPremiumTrainings', { root: true });
          })
          .catch(reject);
      });
    },
    fetchSurveysTrainingSeries({ dispatch, commit, state }) {
      return new Promise((resolve, reject) => {
        TrainingSeriesService.fetchSurveys()
          .then(surveysTrainingSeries => {
            commit(TRAININGS_UPDATE_SURVEYS_TRAINING_SERIES, surveysTrainingSeries);
            resolve(surveysTrainingSeries);
          })
          .catch(reject);
      });
    },
    fetchAvailableAndCompletedSeries({ dispatch, commit, state }) {
      return new Promise((resolve, reject) => {
        TrainingSeriesService.fetchAvailableAndCompletedTrainings()
          .then(availableTrainingSeries => {
            commit(TRAININGS_UPDATE_AVAILABLE_TRAINING_SERIES, availableTrainingSeries);
            resolve(availableTrainingSeries);
          })
          .catch(reject);
      });
    },
    unlockPremiumTrainingSeries({ dispatch, commit, state }, id) {
      const { premiumTrainingSeries } = state;
      const training = premiumTrainingSeries.find(item => item.id === id);
      training.unlocked = true;
      commit(TRAININGS_UPDATE_PREMIUM_TRAINING_SERIES, premiumTrainingSeries);
    },
    [TRAININGS_UPDATE_CURRENT_TRAINING_SERIES]({ state, commit }, { id }) {
      const currentTrainingSeries = state.trainingSeries.find(series => series.id === id);
      commit(TRAININGS_SET_CURRENT_TRAINING_SERIES, currentTrainingSeries);
    },
    // eslint-disable-next-line camelcase
    [TRAININGS_UPDATE_CURRENT_TRAINING](
      { state, commit, dispatch },
      {
        // eslint-disable-next-line camelcase
        series_slug,
        id,
        training_slug,
        lesson_id,
        training_id,
      },
    ) {
      // eslint-disable-next-line camelcase
      const currentTrainingSeries = state.trainingSeries.find(
        series => series.slug === series_slug,
      );
      // eslint-disable-next-line camelcase
      let currentTraining;
      if (training_slug !== undefined) {
        currentTraining = currentTrainingSeries.trainings.find(
          training => training.slug === training_slug,
        );
      } else if (training_id !== undefined) {
        currentTraining = currentTrainingSeries.trainings.find(
          training => training.id === training_id,
        );
      } else {
        return;
      }

      // eslint-disable-next-line camelcase
      if (!lesson_id && currentTraining.lessons[0] && currentTraining.lessons[0].lesson_id) {
        // eslint-disable-next-line camelcase,prefer-destructuring
        lesson_id = currentTraining.lessons[0].lesson_id;
      }

      commit(TRAININGS_SET_CURRENT_TRAINING, currentTraining);
      commit(TRAININGS_SET_CURRENT_TRAINING_ID, id);
      commit(TRAININGS_SET_CURRENT_LESSON_ID, lesson_id);
      dispatch(TRAININGS_UPDATE_CURRENT_TRAINING_SERIES, { id: currentTraining.trainingSeriesId });
    },
  },

  getters: {
    trainingSeries(state) {
      return state.trainingSeries;
    },
    premiumTrainingSeries(state) {
      return state.premiumTrainingSeries;
    },
    productTrainingSeries(state) {
      return state.productTrainingSeries;
    },
    categoryTrainingSeries(state) {
      return state.categoryTrainingSeries;
    },
    latestPremiumTrainingSeries(state) {
      return state.latestPremiumTrainingSeries;
    },
    surveysTrainingSeries(state) {
      return state.surveysTrainingSeries;
    },
    availableTrainingSeries(state) {
      return state.availableTrainingSeries;
    },
    currentTrainingSeries(state) {
      return state.currentTrainingSeries;
    },
    training(state) {
      return state.currentTraining;
    },
    lesson(state) {
      if (!state.currentTraining) {
        return null;
      }

      return state.currentTraining.lessons.find(lesson => lesson.lesson_id === state.lesson_id);
    },
    trainingActivity(state) {
      const completed = state.trainingSeries.reduce((acc, series) => {
        if (series.trainings && series.trainings.length > 0) {
          return acc + +series.trainings[0].isComplete;
        }
        return acc + 0;
      }, 0);
      const total = state.trainingSeries.length > 0 ? state.trainingSeries.length : 1;
      return {
        completed,
        total,
        activity: (completed / total) * 100,
      };
    },
  },
};
