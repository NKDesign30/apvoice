import transform from 'lodash/transform';
import MenuMapper from '@/services/mapper/MenuMapper';

export default class MenuService {
  static fetchAll() {
    return new Promise((resolve, reject) => {
      window.axios.get('/wp-json/apovoice/v1/menus/')
        .then(({ data }) => resolve(transform(data, (result, menu, position) => {
          // eslint-disable-next-line no-param-reassign
          result[position] = MenuMapper.mapMenu(menu);
        }, {})))
        .catch(error => reject(error));
    });
  }

  static fetch(slug) {
    return new Promise((resolve, reject) => {
      window.axios.get(`/wp-json/menus/v1/menus/${slug}`)
        .then(({ data }) => resolve(MenuMapper.mapMenu(data)))
        .catch(error => reject(error));
    });
  }
}
