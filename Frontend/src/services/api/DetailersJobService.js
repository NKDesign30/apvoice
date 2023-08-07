import DetailersJobMapper from '@/services/mapper/DetailersJobMapper';

export default class DetailersJobService {
  static fetchInformationalTrainings() {
    return new Promise((resolve, reject) => {
      window.axios.get('/wp-json/wp/v2/ifrmtnl-trng')
        .then(({ data }) => resolve(DetailersJobMapper.mapInformationalTrainings(data)))
        .catch(error => reject(error));
    });
  }

  static saveState({
    informationalTrainingId,
    pharmacyId,
    detailerUserId,
    lastQuestionId,
  }) {
    return new Promise((resolve, reject) => {
      const payload = {
        informational_training_id: informationalTrainingId,
        pharmacy_id: pharmacyId,
        detailer_user_id: detailerUserId,
        last_question_id: lastQuestionId,
      };

      window.axios.post('/wp-json/detailers-job/v1/informational-trainings', payload)
        .then(({ data }) => resolve(DetailersJobMapper.mapSavedState(data)))
        .catch(error => reject(error));
    });
  }

  static clearSavedState({
    informationalTrainingId,
    pharmacyId,
    detailerUserId,
  }) {
    return new Promise((resolve, reject) => {
      const payload = {
        informational_training_id: informationalTrainingId,
        pharmacy_id: pharmacyId,
        detailer_user_id: detailerUserId,
      };

      window.axios.delete('/wp-json/detailers-job/v1/informational-trainings', payload)
        .then(() => resolve())
        .catch(error => reject(error));
    });
  }

  static fetchSavedStates() {
    return new Promise((resolve, reject) => {
      window.axios.get('/wp-json/detailers-job/v1/informational-trainings')
        .then(({ data }) => resolve(DetailersJobMapper.mapSavedStates(data)))
        .catch(error => reject(error));
    });
  }
}
