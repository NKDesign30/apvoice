import get from "lodash/get";
import UserMapper from "@/services/mapper/UserMapper";

export default class UserService {
  static activateUser(key) {
    return new Promise((resolve, reject) => {
      window.axios
        .post("/wp-json/apovoice/v1/users/activate/", { key })
        .then(({ data }) => {
          if (get(data, "result.errors", false) !== false) {
            reject(UserMapper.mapActivationErrorResult(data));
          } else {
            resolve(UserMapper.mapActivationResult(data));
          }
        })
        .catch(error => reject(error));
    });
  }

  static fetchCurrentUser() {
    return new Promise((resolve, reject) => {
      window.axios
        .get("/wp-json/wp/v2/users/me")
        .then(({ data }) => resolve(UserMapper.mapUser(data)))
        .catch(error => reject(error));
    });
  }

  static fetchCurrentUserPunCode() {
    return new Promise((resolve, reject) => {
      window.axios
        .get("/wp-json/apovoice/v1/punCode")
        .then(({ data }) => resolve(data))
        .catch(error => reject(error));
    });
  }

  static updateUserProfile({ id }, data) {
    return window.axios
      .post(`/wp-json/apovoice/v1/users/${id}/profile/`, data)
      .then(() => Promise.resolve())
      .catch(error => Promise.reject(error));
  }

  static updateUserPun(code) {
    var mycode = code;
    return new Promise((resolve, reject) => {
      window.axios
        .post(`/wp-json/apovoice/v1/UpdatePun`, { PunCode: mycode })
        .then(updateddata => resolve(updateddata))
        .catch(error => reject(error));
    });
  }

  static confirmEmail(key) {
    return new Promise((resolve, reject) => {
      window.axios
        .post("/wp-json/apovoice/v1/users/confirmmail/", { key })
        .then(({ data }) => {
          if (get(data, "result.errors", false) !== false) {
            reject(UserMapper.mapConfirmMailErrorResult(data));
          } else {
            resolve(UserMapper.mapConfirmMailResult(data));
          }
        })
        .catch(error => reject(error));
    });
  }

  static fetchUserLevelTrainingsPoints() {
    return new Promise((resolve, reject) => {
      window.axios
        .get("/wp-json/wc/v2/user/level")
        .then(({ data }) => {
          // console.log('level data', data);
          resolve(data);
        })
        .catch(error => reject(error));
    });
  }
}
