import get from 'lodash/get';
import { stripHostnameFromUrl } from '@/services/utils';

export default class PageMapper {
  static mapPage(data) {
    return {
      _links: {
        self: get(data, '_link.self.0.href'),
      },
      acf: get(data, 'acf', ''),
      content: get(data, 'content.rendered', ''),
      date: get(data, 'date'),
      excerpt: get(data, 'excerpt.rendered', ''),
      guid: get(data, 'guid.rendered'),
      id: get(data, 'id'),
      path: stripHostnameFromUrl(get(data, 'link', '')),
      modified: get(data, 'modified'),
      slug: get(data, 'slug'),
      template: get(data, 'template', '').replace(/template-|.php/g, ''),
      title: get(data, 'title.rendered', ''),
      isPublic: get(data, 'acf.public_resource', false),
      password: get(data, 'acf.password', ''),
    };
  }

  static mapPermissions(data) {
    return data.map(permission => PageMapper.mapPermission(permission));
  }

  static mapPermission(permission) {
    return {
      id: get(permission, 'id', null),
      template: get(permission, 'template', '').replace(/template-|.php/g, ''),
      permissons: get(permission, 'user_role_permissions', []),
    };
  }
}
