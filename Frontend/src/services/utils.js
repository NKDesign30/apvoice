import uniqueId from 'lodash/uniqueId';
import { DateTime } from 'luxon';

/**
 * Strips the hostname portion from the given url.
 *
 * @param   {String}  url
 * @returns {String}
 */
export const stripHostnameFromUrl = url => {
  if (url.match(/^\//)) {
    return url;
  }

  const segments = url.split('/').slice(3).filter(segment => segment !== '');

  return segments.length === 0 ? '/' : `/${segments.join('/')}`;
};

/**
 * Resolves the Component name from the given WP Advanced Custom Fields layout name.
 * A layout with the name "call_to_action" will resolve to a "apo-call-to-action" Component.
 *
 * @param   {String}  acfLayoutName
 * @returns {String}
 */
export const resolveComponentName = acfLayoutName => {
  const componentName = acfLayoutName.toLowerCase().replace(/[_\s]/g, '-');

  return `apo-${componentName}`;
};

/**
 * Create a unique Content ID for the given content name.
 * Content with the name "call_to_action" will resolve to a
 * "content-call_to_action-%random_unique_id%" string.
 *
 * @param   {String}  contentName
 * @returns {String}
 */
export const contentId = contentName => uniqueId(`content-${contentName}-`);

/**
 * Map the given utility functions to a mixin to make them
 * available from within a Vue component.
 *
 * @param   {Object}  utilsMap
 * @returns {Object}
 */
export const mapUtils = utilsMap => ({
  methods: { ...utilsMap },
});

/**
 * Determines whether the given decoded JWT is valid
 * according to its timestamps.
 *
 * @param   {Object}  jwt
 * @returns {Boolean}
 */
export const isJwtValid = jwt => {
  const now = DateTime.fromJSDate(new Date()).plus({ seconds: 5 });
  const notBefore = DateTime.fromSeconds(jwt.payload.nbf);
  const expiresAt = DateTime.fromSeconds(jwt.payload.exp);

  return now >= notBefore && now < expiresAt;
};

/**
 * Get the canonical url from the given route and window.
 *
 * @param   {Route}  route
 * @param   {Window}  win
 * @returns {String}
 */
export const canonical = (route, win = null) => {
  const { protocol, host } = (win || window).location;
  const { path } = route;

  return `${protocol}//${host}${path}`;
};

/**
 * Get the canonical tag object to use for the head.
 *
 * @param   {Route}  route
 * @param   {String}  id
 * @param   {Window}  win
 * @returns {Object}
 */
export const canonicalTag = (route, id = 'canonical', win = null) => ({ rel: 'canonical', href: canonical(route, win), id });

export const descriptionTag = (content, id = 'description') => ({
  name: 'description',
  content,
  id,
});

/**
 * Read the given File object from an input[type="file"]
 * as Data URL and return the result.
 *
 * @param   {File}  file
 * @returns {Promise}
 */
export const readInputFile = file => new Promise((resolve, reject) => {
  const reader = new FileReader();

  reader.onload = event => resolve(event.target.result);
  reader.onerror = error => reject(error);
  reader.readAsDataURL(file);
});

/**
 * Convert the given hex string in the format #ff00bb intp
 * and object containing the according red, green and blue value.
 *
 * @param   {String}  hexValue
 * @returns {Object}
 */
export const hexToRgb = hexValue => {
  const rgbValues = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hexValue);

  return rgbValues ? {
    red: parseInt(rgbValues[1], 16),
    green: parseInt(rgbValues[2], 16),
    blue: parseInt(rgbValues[3], 16),
  } : null;
};

/**
 * Calculate the brightness for the given red, green and blue
 * valued color. Taken from: https://www.w3.org/TR/AERT#color-contrast
 *
 * @param   {Number}  red
 * @param   {Number}  green
 * @param   {Number}  blue
 * @returns {Number}
 */
export const colorBrightness = (red, green, blue) => (red * 299 + green * 587 + blue * 114) / 1000;

/**
 * Determine if the current environment is considered as
 * the "development" environment.
 *
 * @returns {Boolean}
 */
export const isDevEnvironment = () => process.env.NODE_ENV === 'development';
