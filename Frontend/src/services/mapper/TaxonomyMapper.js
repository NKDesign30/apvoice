import get from 'lodash/get';
import unescape from 'lodash/unescape';

export default class TaxonomyMapper {
  static mapTrainingCategory(data) {
    return {
      id: get(data, 'id', null),
      count: get(data, 'count', 0),
      name: unescape(get(data, 'name', null)),
      imageComplete: get(data, 'acf.imagecomplete', null),
      imageIncomplete: get(data, 'acf.imageincomplete', null),
      activeAchievements: get(data, 'acf.active_achievements', false),
      slug: get(data, 'slug', null),
      taxonomy: get(data, 'taxonomy', null),
      parent: get(data, 'parent', null),
    };
  }

  static mapDownloadProduct(data) {
    return {
      id: get(data, 'id', null),
      count: get(data, 'count', 0),
      name: unescape(get(data, 'name', null)),
      slug: get(data, 'slug', null),
      taxonomy: get(data, 'taxonomy', null),
      parent: get(data, 'parent', null),
      category: get(data, 'acf.category', null),
      image: get(data, 'acf.image', null),
      dutyText: get(data, 'acf.duty_text', null),
    };
  }

  static mapDownloadCategory(data) {
    return {
      id: get(data, 'id', null),
      count: get(data, 'count', 0),
      name: unescape(get(data, 'name', null)),
      slug: get(data, 'slug', null),
      taxonomy: get(data, 'taxonomy', null),
      parent: get(data, 'parent', null),
    };
  }

  static mapDownloadMediatype(data) {
    return {
      id: get(data, 'id', null),
      count: get(data, 'count', 0),
      name: unescape(get(data, 'name', null)),
      slug: get(data, 'slug', null),
      taxonomy: get(data, 'taxonomy', null),
      parent: get(data, 'parent', null),
      icon: get(data, 'acf.icon', null),
    };
  }
}
