import PharmacyMapper from '@/services/mapper/PharmacyMapper';

export default class PharmacyService {
  static fetchAll() {
    return new Promise((resolve, reject) => {
      window.axios.get('/wp-json/apovoice/v1/pharmacies/')
        .then(({ data }) => resolve(data.map(pharmacy => PharmacyMapper.mapPharmacy(pharmacy))))
        .catch(error => reject(error));
    });
  }

  static fetchById(id) {
    return new Promise((resolve, reject) => {
      window.axios.get(`/wp-json/apovoice/v1/pharmacies/${id}`)
        .then(({ data }) => resolve(PharmacyMapper.mapPharmacy(data)))
        .catch(error => reject(error));
    });
  }
}
