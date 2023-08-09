import DownloadMapper from '@/services/mapper/DownloadMapper';

export default class DownloadService {
  static fetchAll() {
    return new Promise((resolve, reject) => {
      window.axios.get('/wp-json/wp/v2/downloads?per_page=5000')
        .then(({ data }) => resolve(data.map(DownloadMapper.mapDownload)))
        .catch(error => reject(error));
    });
  }
}
