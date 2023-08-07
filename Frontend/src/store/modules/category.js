import {
    SETCATEGORY,
    CLICK_CATEGORY,
    SHOW_TAB_CATEGORY
  } from '../types/action-types';
import { SETCATEGORYM,SHOW_TAB_CATEGORYM,CLICK_CATEGORYM } from '../types/mutation-types';


export default {
    state: {
      clicked: 0,
      showCategorySeries: !!(window.location.hash && window.location.hash === '#category'),
    },
  
    mutations: {
     [SETCATEGORYM](state,id){
        state.clicked=id;
     },
     [SHOW_TAB_CATEGORYM](state){
        state.showCategorySeries=true;
      },
      [CLICK_CATEGORYM](state){
        state.showCategorySeries=!state.showCategorySeries;
      }
    },
  
    actions: {
        [SETCATEGORY]({ commit }, id) {
            commit(SETCATEGORYM, id)
        },
        [SHOW_TAB_CATEGORY]({ commit }) {
          commit(SHOW_TAB_CATEGORYM)
      },
  
      [CLICK_CATEGORY]({ commit }) {
        commit(CLICK_CATEGORYM)
      },

    },
  
    getters: {
        getid(state){
            return(state.clicked)
        },
        showCategorySeries(state){
           return(state.showCategorySeries);
        }
    },
  };
  