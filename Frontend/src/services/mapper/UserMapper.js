import get from 'lodash/get';
import transform from 'lodash/transform';

export default class UserMapper {
  static mapActivationResult(data) {
    return {
      blog_id: String(get(data, 'result.blog_id', '')),
      password: get(data, 'result.password', ''),
      user_id: String(data, 'result.user_id', ''),
    };
  }

  static mapActivationErrorResult(data) {
    return transform(get(data, 'result.errors', []), (result, messages) => {
      messages.forEach(message => result.push(message));
    }, []);
  }

  static mapConfirmMailResult(data) {
    return {
      blog_id: String(get(data, 'result.blog_id', '')),
      password: get(data, 'result.password', ''),
      user_id: String(data, 'result.user_id', ''),
    };
  }

  static mapConfirmMailErrorResult(data) {
    return transform(get(data, 'result.errors', []), (result, messages) => {
      messages.forEach(message => result.push(message));
    }, []);
  }

  static mapUser(data) {
    return {
      id: String(get(data, 'id', '')),
      name: get(data, 'name', ''),
      firstName: get(data, 'meta.first_name', ''),
      lastName: get(data, 'meta.last_name', ''),
      url: get(data, 'url', ''),
      description: get(data, 'description', ''),
      link: get(data, 'link', ''),
      slug: get(data, 'slug', ''),
      roles: get(data, 'roles', []),
      apoPoints: get(data, 'apoPoints', 0) || 0,
      expertPoints: get(data, 'expertPoints', 0) || 0,
      levelData: get(data, 'levelData', null), // level data fetched on login, training completion and for display of Level components
      profilePicture: get(data, 'meta.profile_picture', ''),
      title: get(data, 'meta.title', ''),
      job: get(data, 'meta.job', ''),
      formOfAddress: get(data, 'meta.form_of_address', ''),
      workingSince: get(data, 'meta.working_since', ''),
      punCode: get(data, 'meta', ''),
      age: get(data, 'meta.age', ''),
      priorities: get(data, 'meta.priorities', []),
      tasks: get(data, 'meta.tasks', []),
      associatedPharmacies: get(data, 'associated_pharmacies', []),
      expertOnlyPharmacies: get(data, 'meta.expert_only_pharmacies', []) === '' ? [] : JSON.parse(get(data, 'meta.expert_only_pharmacies', [])),
      loginActivity: get(data, 'login_activity', 0),
      newsletterState: get(data, 'newsletter_state', null),
      surveyResults: get(data, 'survey_results', []),
      trainingResults: get(data, 'training_results', []),
      hasUpdatedPharmacyAddress: get(data, 'has_updated_pharmacy_address', true),
    };
  }

  static mapPunCode(data) {
    return {
      punCode: String(get(data, 'punCode', '')),
    };
  }
}
