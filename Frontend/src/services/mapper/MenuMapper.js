import get from 'lodash/get';
import { stripHostnameFromUrl } from '@/services/utils';

export default class MenuMapper {
  static mapMenu(data) {
    return {
      description: get(data, 'description', ''),
      id: get(data, 'id'),
      items: (get(data, 'items', []) || []).map(itemData => MenuMapper.mapMenuItem(itemData)),
      name: get(data, 'name', ''),
      parent: get(data, 'parent', '0'),
      slug: get(data, 'slug', ''),
    };
  }

  static mapMenuItem(data) {
    return {
      description: get(data, 'description', ''),
      guid: get(data, 'guid', ''),
      icon: MenuMapper.mapMenuItemIcon(data),
      id: get(data, 'ID'),
      object: get(data, 'object', ''),
      objectId: get(data, 'object_id', '-1'),
      parent: get(data, 'menu_item_parent', '-1'),
      title: get(data, 'title', ''),
      url: get(data, 'template', '') ? `/${get(data, 'template', '')}` : MenuMapper.normalizeLink(data),
      url_path: get(data, 'url_path'),
      template: get(data, 'template', ''),
      showInMore: get(data, 'show_in_more', false),
      isPublic: get(data, 'public_resource', false),
    };
  }

  static mapMenuItemIcon(data) {
    return {
      url: get(data, 'icon.url', ''),
      title: get(data, 'icon.title', ''),
      alt: get(data, 'icon.alt', ''),
      source: atob(get(data, 'icon_source', '')),
    };
  }

  static normalizeLink(data) {
    const type = get(data, 'object', 'page');

    if (type === 'custom') {
      return get(data, 'url', '');
    }

    return stripHostnameFromUrl(get(data, 'url', ''));
  }
}
