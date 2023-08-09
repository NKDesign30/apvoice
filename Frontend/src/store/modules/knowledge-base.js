/* eslint-disable no-param-reassign */
import KnowledgeBaseService from '@/services/api/KnowledgeBaseService';
import {
  KNOWLEDGE_BASE_FETCH_ALL,
  KNOWLEDGE_BASE_FETCH_ONE,
} from '../types/action-types';
import { KNOWLEDGE_BASE_UPDATE_KNOWLEDGE_BASE, KNOWLEDGE_BASE_UPDATE_CURRENT_KNOWLEDGE_BASE } from '../types/mutation-types';

export default {
  state: {
    knowledgeBase: [],
    currentKnowledgeBase: {},
  },

  mutations: {
    [KNOWLEDGE_BASE_UPDATE_KNOWLEDGE_BASE](state, updatedKnowledgeBase) {
      state.knowledgeBase = updatedKnowledgeBase;
    },
    [KNOWLEDGE_BASE_UPDATE_CURRENT_KNOWLEDGE_BASE](state, updatedCurrentKnowledgeBase) {
      state.knowledgeBase = updatedCurrentKnowledgeBase;
    },
  },

  actions: {
    [KNOWLEDGE_BASE_FETCH_ALL]({ dispatch, commit, state }) {
      if (state.knowledgeBase.length === 0) {
        dispatch('wait/start', 'knowledgeBasePosts', { root: true });
      }

      return new Promise((resolve, reject) => {
        KnowledgeBaseService.fetchAll()
          .then(knowledgeBase => {
            commit(KNOWLEDGE_BASE_UPDATE_KNOWLEDGE_BASE, knowledgeBase);
            dispatch('wait/end', 'knowledgeBasePosts', { root: true });
            resolve(knowledgeBase);
          }).catch(reject);
      });
    },
    [KNOWLEDGE_BASE_FETCH_ONE]({ dispatch, commit }, id) {
      dispatch('wait/start', 'knowledgeBasePost', { root: true });

      return new Promise((resolve, reject) => {
        KnowledgeBaseService.fetch(id)
          .then(knowledgeBase => {
            commit(KNOWLEDGE_BASE_UPDATE_CURRENT_KNOWLEDGE_BASE, knowledgeBase);
            dispatch('wait/end', 'knowledgeBasePost', { root: true });
            resolve(knowledgeBase);
          }).catch(reject);
      });
    },
  },

  getters: {
    knowledgeBase(state) {
      return state.knowledgeBase;
    },
    currentKnowledgeBase(state) {
      return state.currentKnowledgeBase;
    },
    knowledgeBaseById(state) {
      return id => state.knowledgeBase.find(knowledgeBase => knowledgeBase.id === id);
    },
  },
};
