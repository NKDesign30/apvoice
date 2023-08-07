import Vue from 'vue';

Vue.filter('formattedNumber', value => {
  let formattedValue = '';
  if (document.documentElement.lang === 'es') {
    formattedValue = value.match(/.{1,3}/g).join(' ');
  } else {
    formattedValue = value;
  }
  return formattedValue;
});

Vue.filter('truncate', (value, length) => {
  if (!length || length === 0) {
    // eslint-disable-next-line no-param-reassign
    length = 65;
  }
  if (value.length <= length) {
    return value;
  }
  return `${value.substring(0, length)}... `;
});

Vue.filter('capitalize', word => word.charAt(0).toUpperCase() + word.slice(1));
