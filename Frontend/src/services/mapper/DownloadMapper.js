import get from 'lodash/get';

export default class DownloadMapper {
  static mapDownload(data) {
    return {
      id: String(get(data, 'id', '')),
      slug: get(data, 'slug', ''),
      title: get(data, 'title.rendered', ''),
      product: get(data, 'dwnld-product', ''),
      mediatype: get(data, 'dwnld-mediatype', ''),
      file: get(data, 'acf.file', null) || {},
      fileInfo: get(data, 'acf.file_info', ''),
    };
  }
}
