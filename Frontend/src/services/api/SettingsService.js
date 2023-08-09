import SettingsMapper from '@/services/mapper/SettingsMapper';

export default class SettingsService {
  static fetchAll() {
    return new Promise((resolve, reject) => {
      window.axios.get('/wp-json/apovoice/v1/settings/')
        .then(({ data }) => resolve(SettingsMapper.mapSettings(data)))
        .catch(error => reject(error));
    });
  }

  static createInvitations() {
    return new Promise((resolve, reject) => {
      window.axios.get('/wp-json/apovoice/v1/settings/invitation/create')
        .then(({ data }) => resolve(data))
        .catch(error => reject(error));
    });
  }
}
