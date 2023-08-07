import get from 'lodash/get';

export default class KnowledgeBaseMapper {
  static mapKnowledgeBase(data) {
    return {
      id: String(get(data, 'id', '')),
      date: get(data, 'date', ''),
      slug: get(data, 'slug', ''),
      title: get(data, 'title.rendered', ''),
      subline: get(data, 'acf.subline', ''),
      teaser: get(data, 'acf.teaser', ''),
      text: get(data, 'acf.text', ''),
      image: get(data, 'acf.image', ''),
      type: get(data, 'acf.type', ''),
      stage: get(data, 'acf.stage', ''),
      content: get(data, 'acf.content', ''),
      relatedPosts: get(data, 'acf.related_posts', ''),
    };
  }
}
