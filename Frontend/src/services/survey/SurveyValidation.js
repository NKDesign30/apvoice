import every from 'lodash/every';

export default class SurveyValidation {
  constructor() {
    this.errors = {};
    this.isValid = true;
  }

  hasAny() {
    return !every(this.errors, chapter => chapter.isValid);
  }

  setChapter(number, chapter) {
    this.errors[number] = chapter;
    this.isValid = !this.hasAny();
  }

  hasChapter(number) {
    return this.errors[number] !== undefined;
  }

  getChapter(number) {
    if (!this.hasChapter(number)) {
      return null;
    }

    return this.errors[number];
  }

  resetChapter(number) {
    if (this.hasChapter(number)) {
      delete this.errors[number];
    }

    this.isValid = !this.hasAny();
  }

  reset() {
    this.errors = {};
    this.isValid = true;
  }
}
