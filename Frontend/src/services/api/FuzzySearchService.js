

export default class FuzzySearchService {
  static fetch(search) {
    window.fuzzySearchCancelToken = window.axiosCancelToken.source();

    return new Promise((resolve, reject) => {
      window.axios.get(`/wp-json/apovoice/v1/pharmacies-fuzzy-search?s=${search}`, {
        cancelToken: window.fuzzySearchCancelToken.token,
      })
        .then(({ data }) => resolve(data))
        .catch(error => reject(error));
    });
  }
}
