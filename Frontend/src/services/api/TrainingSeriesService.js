import TrainingMapper from "@/services/mapper/TrainingMapper";

export default class TrainingSeriesService {
  static fetchAll() {
    return new Promise((resolve, reject) => {
      window.axios
        .get("/wp-json/wp/v2/training-series?per_page=100")
        .then(({ data }) => {
          console.log(data);
          resolve(data.map(series => TrainingMapper.this(series)));
        })
        .catch(error => reject(error));
    });
  }

  static fetchPremium() {
    return new Promise((resolve, reject) => {
      window.axios
        .get("/wp-json/wc/v2/training-series-premium")
        .then(({ data }) => {
          resolve(
            data.map(item => ({
              title: item.title.rendered,
              boost: item.acf.informations.boost,
              thumbnail: item.acf.informations.image.url,
              category: item.category,
              description: item.description,
              id: item.id,
              slug: item.slug,
              trainings: item.trainings,
              informations: item.acf.informations,
              unlocked: item.unlocked,
              is_complete: item.is_complete,
              apo_points: item.acf.informations.apo_points
            }))
          );
        })
        .catch(error => reject(error));
    });
  }

  static fetchLatestCategoryTrainings() {
    return new Promise((resolve, reject) => {
      window.axios
        .get("/wp-json/wc/v2/training-category-series")
        .then(({ data }) => {
          resolve(
            data.map(item => ({
              title: item.title,
              boost: item.acf.informations.boost,
              expires_at: item.acf.informations.expires_at,
              link: item.link,
              thumbnail: item.acf.informations.image.url,
              category: item.category,
              description: item.description,
              id: item.id,
              slug: item.slug,
              trainings: item.trainings,
              informations: item.acf.informations,
              apo_points: item.acf.informations.apo_points
            }))
          );
        })
        .catch(error => reject(error));
    });
  }

  static fetchLatestProductTrainings() {
    return new Promise((resolve, reject) => {
      window.axios
        .get("/wp-json/wc/v2/training-product-series")
        .then(({ data }) => {
          resolve(
            data.map(item => ({
              title: item.title,
              boost: item.acf.informations.boost,
              link: item.link,
              thumbnail: item.acf.informations.image.url,
              category: item.category,
              description: item.description,
              id: item.id,
              slug: item.slug,
              trainings: item.trainings,
              informations: item.acf.informations,
              apo_points: item.acf.informations.apo_points
            }))
          );
        })
        .catch(error => reject(error));
    });
  }

  static fetchLatestPremium() {
    return new Promise((resolve, reject) => {
      window.axios
        .get("/wp-json/wc/v2/latest-training-series-premium")
        .then(({ data }) => {
          // console.log('latest premium data', data);
          resolve(
            data.map(item => ({
              title: item.title,
              boost: item.acf.informations.boost,
              link: item.link,
              thumbnail: item.acf.informations.image.url,
              category: item.category,
              description: item.description,
              id: item.id,
              slug: item.slug,
              trainings: item.trainings,
              informations: item.acf.informations
            }))
          );
        })
        .catch(error => reject(error));
    });
  }

  static fetchSurveys() {
    return new Promise((resolve, reject) => {
      window.axios
        .get("/wp-json/wc/v2/incomplete_survey")
        .then(({ data }) => {
          resolve(
            data.map(item => ({
              title: item.title,
              link: item.link,
              thumbnail: item.thumbnail,
              category: item.category,
              description: item.description,
              id: item.id
            }))
          );
        })
        .catch(error => reject(error));
    });
  }

  static fetchAvailableAndCompletedTrainings() {
    return new Promise((resolve, reject) => {
      window.axios
        .get("/wp-json/wc/v2/count_overview_training")
        .then(({ data }) => {
          // console.log('Av data', data);
          resolve(data);
        })
        .catch(error => reject(error));
    });
  }

  static fetch(trainingSeriesId) {
    return new Promise((resolve, reject) => {
      window.axios
        .get(`/wp-json/wp/v2/training-series/${trainingSeriesId}`)
        .then(({ data }) => resolve(TrainingMapper.this(data)))
        .catch(error => reject(error));
    });
  }
}
