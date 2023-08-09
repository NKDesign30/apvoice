import download from 'downloadjs';

export default class DownloadService {
  static load(id) {
    return new Promise((resolve, reject) => {
      window.axios.get(`/wp-json/apovoice/v1/downloads/${id}`, { responseType: 'blob' })
        .then(({ data }) => resolve(data))
        .catch(error => reject(error));
    });
  }

  static process(data, filename, mimeType = 'application/pdf') {
    return download(data, filename, mimeType);
  }
}
