export default class SalesRepService {
  static fetchByExpertCode(expertCode) {
    return new Promise((resolve, reject) => {
      window.axios.get(`/wp-json/apovoice/v1/sales-reps/expert-code/${expertCode}`)
        .then(({ data }) => resolve(data))
        .catch(error => reject(error));
    });
  }
}
