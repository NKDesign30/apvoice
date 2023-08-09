const configDefault = {
        'plainPrefix': 'raffle',
        get prefix() {
            return `${this.plainPrefix}_`
        },
        'pluginName': 'ApoRaffle',
        'namespace': 'awsm\\wp\\boilerplate',
        'bootstrapFile': 'apo-raffle.php',
        'devUrl': 'http://localhost',
    };

module.exports = configDefault;