import KnowledgeBaseMapper from '@/services/mapper/KnowledgeBaseMapper';

export default class KnowledgeBaseService {
  static fetchAll() {
    return new Promise((resolve, reject) => {
      window.axios.get('/wp-json/wp/v2/knowledge-base?per_page=100')
        .then(({ data }) => resolve(data.map(KnowledgeBaseMapper.mapKnowledgeBase)))
        .catch(error => reject(error));
    });
  }
}
