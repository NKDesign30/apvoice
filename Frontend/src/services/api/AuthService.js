
export default class AuthService {
  static refresh() {
    return new Promise((resolve, reject) => {
      window.axios.post('/wp-json/jwt-auth/v1/token/refresh')
        .then(({ data }) => resolve(data))
        .catch(error => reject(error));
    });
  }
}
