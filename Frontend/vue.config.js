module.exports = {
  transpileDependencies: [
  ],
  lintOnSave: process.env.NODE_ENV !== 'production',
  pwa: {
    workboxOptions: {
      exclude: [/OneSignal.*\.js$/],
    },
  },
};
