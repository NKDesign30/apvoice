var defaultConfig = require('./config.default');
var directoriesConfig = require('./config.directories');
var settingsConfig = require('./config.settings');

const config = {
    'default': {
        ...defaultConfig
    },
    'directories': {
        ...directoriesConfig
    },
    'settings': {
        ...settingsConfig
    }
};

module.exports = config;