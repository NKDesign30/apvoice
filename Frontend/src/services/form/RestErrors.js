import cloneDeep from 'lodash/cloneDeep';

export default class RestErrors {
  /**
   * Constructor
   */
  constructor() {
    this.errors = {};
  }

  /**
   * Get all errors.
   *
   * @returns {object}
   */
  all() {
    return this.errors;
  }

  /**
   * Determine whether there are any errors for the given field.
   *
   * @param  {string}  field
   * @returns {boolean}
   */
  has(field) {
    return !!this.errors[field];
  }

  /**
   * Get all errors for the given field.
   *
   * @param  {string}  field
   * @returns {array}
   */
  get(field) {
    if (!this.has(field)) return [];

    return this.errors[field];
  }

  /**
   * Clear the errors for the given field or all.
   *
   * @param  {string}  field
   */
  clear(field = null) {
    if (field === null) {
      this.errors = {};

      return;
    }

    if (!this.has(field)) return;

    const errors = cloneDeep(this.errors);

    delete errors[field];

    this.errors = { ...errors };
  }

  /**
   * Determine whether there are any errors.
   *
   * @returns {boolean}
   */
  any() {
    return Object.keys(this.errors).length > 0;
  }

  /**
   * Assign the given errors.
   *
   * @param  {Object}  errors
   */
  assign(errors) {
    this.errors = { ...errors };
  }

  /**
   * Add a single error.
   *
   * @param  {String}  field
   * @param  {String}  error
   */
  add(field, error) {
    if (!this.has(field)) {
      this.errors = {
        ...this.errors,
        [field]: [error],
      };
    } else {
      this.errors[field].push(error);
    }
  }

  /**
   * Get the class bindings for the given field.
   *
   * @param  {string}  field
   * @param  {string}  type
   * @returns {object}
   */
  classes(field, type = 'object') {
    const classes = {
      'form-input--has-error': this.has(field),
    };

    const classesAsArray = Object.keys(classes).filter(className => !!classes[className]);

    if (type === 'object') {
      return classes;
    }

    if (type === 'array') {
      return classesAsArray;
    }

    if (type === 'string') {
      return classesAsArray.join(' ');
    }

    return '';
  }
}
