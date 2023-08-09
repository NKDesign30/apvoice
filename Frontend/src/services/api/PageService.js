import find from 'lodash/find';
import PageMapper from '@/services/mapper/PageMapper';

export default class PageService {
  static getFrontPage() {
    return new Promise((resolve, reject) => {
      window.axios.get('/wp-json/wp/v2/frontpage')
        .then(({ data }) => resolve(PageMapper.mapPage(data)))
        .catch(error => reject(error));
    });
  }

  static getPages() {
    return new Promise((resolve, reject) => {
      window.axios.get('/wp-json/wp/v2/pages?per_page=100')
        .then(({ data }) => resolve(data))
        .catch(error => reject(error));
    });
  }

  static getPage({ id }) {
    return new Promise((resolve, reject) => {
      window.axios.get(`/wp-json/wp/v2/pages/${id}`)
        .then(({ data }) => resolve(PageMapper.mapPage(data)))
        .catch(error => reject(error));
    });
  }

  static getPageBySlug(slug) {
    return new Promise((resolve, reject) => {
      window.axios.get('/wp-json/wp/v2/pages?per_page=100')
        .then(({ data }) => (data.filter(page => page.slug === slug.replace(/^\/|\/$/g, '')).length === 0
          ? reject(data)
          : resolve(PageMapper.mapPage(data.filter(page => page.slug === slug.replace(/^\/|\/$/g, ''))[0]))))
        .catch(error => reject(error));
    });
  }

  static findByPath(pages, path) {
    return find(pages, ['path', path]);
  }

  static fetchPagePermissions() {
    return new Promise((resolve, reject) => {
      window.axios.get('/wp-json/apovoice/v1/page-permissions')
        .then(({ data }) => resolve(PageMapper.mapPermissions(data)))
        .catch(error => reject(error));
    });
  }
}
