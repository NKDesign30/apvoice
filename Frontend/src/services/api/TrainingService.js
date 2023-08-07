export default class TrainingService {
  
  static storeLessonResults(payload) {
    return new Promise((resolve, reject) => {
      window.axios.post('/wp-json/training-user-results/v1/results', payload)
        .then(({ data }) => resolve(data))
        .catch(error => reject(error));
    });
  }

  static storeQuestionResult(payload) {
    return new Promise((resolve, reject) => {
      window.axios.post('/wp-json/apovoice/v1/trainings/questions/', payload)
        .then(({ data }) => resolve(data))
        .catch(error => reject(error));
    });
  }

  static storeLike(params) {
    return new Promise((resolve, reject) => {
      window.axios.get('/wp-json/wc/v2/like/'+params.TRAINING_SERIES_ID)
        .then(({ data }) => resolve(data))
        .catch(error => reject(error));
    });
  }
  
  static storeDisLike(params) {
    return new Promise((resolve, reject) => {
      window.axios.get('/wp-json/wc/v2/dislike/'+params.TRAINING_SERIES_ID)
        .then(({ data }) => resolve(data))
        .catch(error => reject(error));
    });
  }

  static checkLike(params) {
    return new Promise((resolve, reject) => {
      window.axios.get('/wp-json/wc/v2/check/'+params.TRAINING_SERIES_ID)
        .then(({ data }) => resolve(data))
        .catch(error => reject(error));
    });
  }

  static countLikes(params) {
    return new Promise((resolve, reject) => {
      window.axios.get('/wp-json/wc/v2/training-likes/'+params.TRAINING_SERIES_ID)
        .then(({ data }) => resolve(data))
        .catch(error => reject(error));
    });
  }
}
