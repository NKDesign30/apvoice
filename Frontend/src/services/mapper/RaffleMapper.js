import get from 'lodash/get';

export default class RaffleMapper {
  static mapRaffle(data) {
    return {
      id: String(get(data, 'id', '')),
      date: get(data, 'date', ''),
      slug: get(data, 'slug', ''),
      title: get(data, 'title.rendered', ''),
      stage: get(data, 'acf.stage.stage'),
      content: get(data, 'acf.content', ''),
      contest: get(data, 'acf.contest', ''),
      form: get(data, 'acf.form', ''),
      configuration: get(data, 'acf.configuration', ''),
    };
  }
}
