const configDefault = {
        'plainPrefix': 'svy',
        get prefix() {
            return `${this.plainPrefix}_`
        },
        'pluginName': 'Surveys',
        'bootstrapFile': 'surveys.php',
        'devUrl': 'http://localhost',
    };

module.exports = configDefault;