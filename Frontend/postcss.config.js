/* eslint-disable global-require, import/no-extraneous-dependencies */
const purgecss = require('@fullhuman/postcss-purgecss')({
  // Specify the paths to all of the template files in your project
  content: [
    './src/**/*.html',
    './src/**/*.vue',
    // etc.
  ],

  // Include any special characters you're using in this regular expression
  defaultExtractor: content => content.match(/[A-Za-z0-9-_:/.]+/g) || [],

  // Add any dynamically generated classes here in order to keep them in the resulting stylesheet
  whitelist: [
    'is-success',
    'is-failure',
    'animated',
    'fadeInDown',
    'fadeInUp',
    'zoomIn',
    'pulse',
  ],

  whitelistPatterns: [
    // theme-* Classes for theme styling
    /^theme-/,

    // video-js Library
    /^video-js/,
    /^vjs[_-]/,

    // vue-progressbar Plugin
    /^__cov-/,

    // vue-select Library
    /^v-select/,
    /^vs__/,

    // shopify/draggable Library
    /^draggable-/,

    // tooltip classes
    /^tooltip/,
  ],
});

module.exports = {
  plugins: [
    require('tailwindcss'),
    require('autoprefixer'),
    ...process.env.NODE_ENV === 'production'
      ? [purgecss]
      : [],
  ],
};
