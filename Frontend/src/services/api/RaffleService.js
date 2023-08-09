import RaffleMapper from '@/services/mapper/RaffleMapper';

export default class RaffleService {
  static fetchAll() {
    return new Promise((resolve, reject) => {
      window.axios.get('/wp-json/wp/v2/raffle?per_page=100')
        .then(({ data }) => resolve(data.map(RaffleMapper.mapRaffle)))
        .catch(error => reject(error));
    });
  }

  static store(data) {
    return window.axios.post('/wp-json/apovoice/v1/raffle', data);
  }

  static getStored() {
    return new Promise((resolve, reject) => {
      window.axios.get('/wp-json/apovoice/v1/raffle/')
        .then(data => resolve(data))
        .catch(error => reject(error));
    });
  }
}
