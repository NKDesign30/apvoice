/* eslint-disable camelcase */
import TaxonomyMapper from '@/services/mapper/TaxonomyMapper';

export default class TaxonomyService {
  static fetchAll() {
    return new Promise((resolve, reject) => {
      window.axios.get('/wp-json/wp/v2/taxonomies')
        .then(({ data }) => resolve(data))
        .catch(error => reject(error));
    });
  }

  static fetchTrainingCategories() {
    return new Promise((resolve, reject) => {
      window.axios.get('/wp-json/wp/v2/training-category?per_page=100')
        .then(({ data }) => resolve(data
          .map(category => TaxonomyMapper.mapTrainingCategory(category))))
        .catch(error => reject(error));
    });
  }

  static fetchDownloadCategories() {
    return new Promise((resolve, reject) => {
      window.axios.get('/wp-json/wp/v2/dwnld-category?per_page=100')
        .then(({ data }) => {
          resolve(data.map(category => TaxonomyMapper.mapDownloadCategory(category)));
        })
        .catch(error => reject(error));
    });
  }

  static fetchDownloadProducts() {
    return new Promise((resolve, reject) => {
      window.axios.get('/wp-json/wp/v2/dwnld-product?per_page=100')
        .then(({ data }) => {
          resolve(data.map(product => TaxonomyMapper.mapDownloadProduct(product)));
        })
        .catch(error => reject(error));
    });
  }

  static fetchDownloadMediatypes() {
    return new Promise((resolve, reject) => {
      window.axios.get('/wp-json/wp/v2/dwnld-mediatype?per_page=100')
        .then(({ data }) => {
          resolve(data.map(mediatype => TaxonomyMapper.mapDownloadMediatype(mediatype)));
        })
        .catch(error => reject(error));
    });
  }
}
