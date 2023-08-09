import SurveyMapper from '@/services/mapper/SurveyMapper';

export default class SurveyService {
  static fetchAll() {
    return new Promise((resolve, reject) => {
      window.axios
        .get('/wp-json/wc/v2/surveys_filtered?per_page=100')
        .then(({ data }) => resolve(data.map(SurveyMapper.mapSurvey)))
        .catch(error => reject(error));
    });
  }

  static fetch(surveyId) {
    return new Promise((resolve, reject) => {
      window.axios
        .get(`/wp-json/wp/v2/surveys/${surveyId}`)
        .then(({ data }) => resolve(SurveyMapper.mapSurvey(data)))
        .catch(error => reject(error));
    });
  }

  static storeResults(payload) {
    return new Promise((resolve, reject) => {
      window.axios
        .post('/wp-json/survey-user-results/v1/results', payload)
        .then(({ data }) => resolve(data))
        .catch(error => reject(error));
    });
  }

  static fetchLatests() {
    return new Promise((resolve, reject) => {
      window.axios
        .get('/wp-json/wc/v2/latest-surveys/')
        .then(({ data }) => resolve(data.map(SurveyMapper.mapSurvey)))
        .catch(error => reject(error));
    });
  }
}