export default class ConfirmPharmacyService {
  static fetch() {
    return new Promise((resolve, reject) => {
      window.axios.get('/wp-json/apovoice/v1/confirm-pharmacy')
        .then(({ data }) => resolve(data))
        .catch(error => reject(error));
    });
  }

  static store(payload) {
    return new Promise((resolve, reject) => {
      window.axios.post('/wp-json/apovoice/v1/confirm-pharmacy', payload)
        .then(({ data }) => resolve(data))
        .catch(error => reject(error));
    });
  }
}
