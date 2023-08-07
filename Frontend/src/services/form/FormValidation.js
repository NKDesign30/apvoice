import find from 'lodash/find';

export default class FormValidation {
  constructor() {
    this.errors = [];
    this.isValid = true;
  }

  fill({ isValid, validationMessages }) {
    this.isValid = isValid;
    this.errors = validationMessages;
  }

  hasAny() {
    return this.errors.length > 0;
  }

  has(fieldId) {
    return this.errors.some(({ id }) => id === fieldId);
  }

  get(fieldId) {
    if (!this.has(fieldId)) {
      return undefined;
    }

    return find(this.errors, ['id', fieldId]).message;
  }

  reset(fieldId) {
    if (this.has(fieldId)) {
      this.errors = this.errors.filter(({ id }) => id !== fieldId);
    }

    this.isValid = !this.hasAny();
  }

  resetAll() {
    this.errors = [];
    this.isValid = true;
  }
}
