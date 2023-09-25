/* eslint-disable no-param-reassign */
// import { resolve } from "core-js/fn/promise";
import SurveyService from '@/services/api/SurveyService';

import {
  SURVEYS_FETCH_ALL,
  SURVEYS_FETCH_ONE,
  SURVEYS_STORE_RESULT,
  AUTH_FETCH_CURRENT_USER,
  LATESTS_SURVEYS,
} from '../types/action-types';
import {
  SURVEYS_UPDATE_SURVEYS,
  SURVEYS_UPDATE_CURRENT_SURVEY,
  UPDATE_LATEST_SURVEYS,
  UPDATE_SURVEY_ANSWERS,
} from '../types/mutation-types';

export default {
  state: {
    surveys: [],
    currentSurvey: {},
    latestsSurveys: [],
  },

  mutations: {
    [SURVEYS_UPDATE_SURVEYS](state, updatedSurveys) {
      state.surveys = updatedSurveys;
    },
    [SURVEYS_UPDATE_CURRENT_SURVEY](state, updatedCurrentSurvey) {
      state.currentSurvey = updatedCurrentSurvey;
    },
    [UPDATE_LATEST_SURVEYS](state, latestsSurveys) {
      state.latestsSurveys = latestsSurveys;
    },
    [UPDATE_SURVEY_ANSWERS](state, payload) { // Hinzufügen dieser neuen Mutation
      const chapter = state.surveys.find(s => s.id === payload.chapterId);
      if (chapter) {
        chapter.questions.forEach((q, index) => {
          q.value = payload.answers[index];
        });
      }
    },
  },
  actions: {
    [LATESTS_SURVEYS]({ dispatch, commit, state }) {
      if (state.latestsSurveys.length === 0) {
        dispatch('wait/start', 'latestsSurveys', { root: true });
      }

      return new Promise((resolve, reject) => {
        SurveyService.fetchLatests()
          .then(latestsSurveys => {
            commit(UPDATE_LATEST_SURVEYS, latestsSurveys);
            dispatch('wait/end', 'latestsSurveys', { root: true });
            resolve(latestsSurveys);
          })
          .catch(reject);
      });
    },
    [SURVEYS_FETCH_ALL]({ dispatch, commit, state }) {
      if (state.surveys.length === 0) {
        dispatch('wait/start', 'surveys', { root: true });
      }

      return new Promise((resolve, reject) => {
        SurveyService.fetchAll()
          .then(surveys => {
            commit(SURVEYS_UPDATE_SURVEYS, surveys);
            dispatch('wait/end', 'surveys', { root: true });
            resolve(surveys);
          })
          .catch(reject);
      });
    },
    [SURVEYS_FETCH_ONE]({ dispatch, commit }, id) {
      dispatch('wait/start', 'survey', { root: true });

      return new Promise((resolve, reject) => {
        SurveyService.fetch(id)
          .then(survey => {
            commit(SURVEYS_UPDATE_CURRENT_SURVEY, survey);
            dispatch('wait/end', 'survey', { root: true });
            resolve(survey);
          })
          .catch(reject);
      });
    },
    [SURVEYS_STORE_RESULT]({ state, commit, dispatch }, result) {
      return new Promise((resolve, reject) => {
        SurveyService.storeResults(result)
          .then(surveyResult => {
            const index = state.surveys.findIndex(s => s.id === surveyResult.survey_id);
            const survey = state.surveys.find(s => s.id === surveyResult.survey_id);

            const copiedSurveys = state.surveys.slice();
            copiedSurveys.splice(index, 1, survey);

            commit(SURVEYS_UPDATE_SURVEYS, copiedSurveys);
            dispatch(AUTH_FETCH_CURRENT_USER);

            resolve(survey);
          })
          .catch(reject);
      });
    },
  },

  getters: {
    surveys(state) {
      return state.surveys;
    },
    latestsSurveys(state) {
      return state.latestsSurveys;
    },
    currentSurvey(state) {
      return state.currentSurvey;
    },
    surveyById(state) {
      return id => state.surveys.find(survey => survey.id === id);
    },
  },
};
