import FormMapper from '@/services/mapper/FormMapper';

export default class FormService {
  static fetch(formId) {
    return new Promise((resolve, reject) => {
      window.axios.get(`/wp-json/gf/v2/forms/${formId}`)
        .then(({ data }) => resolve(FormMapper.mapForm(data)))
        .catch(error => reject(error));
    });
  }

  static submit(submissionUrl, payload) {
    return new Promise((resolve, reject) => {
      window.axios.post(submissionUrl, payload)
        .then(({ data }) => resolve(FormMapper.mapSubmissionResponse(data)))
        .catch(error => {
          if (error.response && error.response.status === 400) {
            return reject(FormMapper.mapErrorResponse(error.response.data));
          }

          return reject(error);
        });
    });
  }

  static getFormComponent(field) {
    switch (field.type) {
      case 'email':
      case 'password':
      case 'text':
        return 'apo-text-input';

      case 'html':
        return 'apo-html-block';

      case 'radio':
        return 'apo-radio-buttons';

      case 'checkbox':
        return 'apo-checkbox';

      case 'textarea':
        return 'apo-textarea';

      case 'select':
        return 'apo-select-input';

      case 'multiselect':
        return 'apo-multi-select-input';

      case 'hidden':
        return 'apo-hidden-input';

      case 'apovoice_registration_pharmacy_summary':
        return 'apo-pharmacy-summary';

      case 'apovoice_registration_information':
        return 'apo-registration-information';

      case 'apovoice_pharmacy_fuzzy_search':
        return 'apo-pharmacies-fuzzy-search';

      case 'captcha':
        return 'apo-captcha';

      default:
        console.info(`Unknown field type discovered: ${field.type}`);
        return 'apo-unknown-field';
    }
  }
}
