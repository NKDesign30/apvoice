import FormService from '@/services/api/FormService';
import { FORMS_FETCH_FORM } from '../types/action-types';
import { FORMS_UPDATE_FORM } from '../types/mutation-types';

export default {
  state: {
    forms: [],
  },

  mutations: {
    [FORMS_UPDATE_FORM](state, updatedForm) {
      const exists = state.forms.find(form => form.id === updatedForm.id);

      if (exists) {
        state.forms = state.forms.map(form => {
          if (form.id === updatedForm.id) {
            return updatedForm;
          }

          return form;
        });
      } else {
        state.forms.push(updatedForm);
      }
    },
  },

  actions: {
    [FORMS_FETCH_FORM]({ dispatch, commit }, formId) {
      dispatch('wait/start', `form.${formId}`, { root: true });

      FormService.fetch(formId)
        .then(form => {
          commit(FORMS_UPDATE_FORM, form);
          dispatch('wait/end', `form.${formId}`, { root: true });
        })
        .catch(error => {
          console.log(`error fetching form ${formId}`, error);
        });
    },
  },
};
