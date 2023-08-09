const configDefault = {
        'plainPrefix': 'trng',
        get prefix() {
            return `${this.plainPrefix}_`
        },
        'pluginName': 'ApoTrainings',
        'namespace': 'awsm\\wp\\boilerplate',
        'bootstrapFile': 'apo-trainings.php',
        'devUrl': 'http://localhost',
    };

module.exports = configDefault;