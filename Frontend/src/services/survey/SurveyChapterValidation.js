export default class SurveyChapterValidation {
  constructor() {
    this.errors = {};
    this.isValid = true;
  }

  add(questionId, message) {
    this.errors[questionId] = message;
    this.isValid = !this.hasAny();
  }

  get(questionId) {
    if (!this.has(questionId)) {
      return null;
    }

    return this.errors[questionId];
  }

  has(questionId) {
    return this.errors[questionId] !== undefined;
  }

  hasAny() {
    return Object.keys(this.errors).length > 0;
  }

  remove(questionId) {
    if (this.has(questionId)) {
      delete this.errors[questionId];
    }

    this.isValid = !this.hasAny();
  }

  reset() {
    this.errors = {};
    this.isValid = true;
  }
}
