module.exports = {
  presets: [
    ['@vue/cli-plugin-babel/preset', {
      targets: {
        ie: '11',
        edge: '16',
      },
      polyfills: [
        'es.symbol',
        'es.object.assign',
      ],
    }],
  ],
};
