const configDefault = {
        'plainPrefix': 'knwldg',
        get prefix() {
            return `${this.plainPrefix}_`
        },
        'pluginName': 'ApoKnowloedgeBase',
        'namespace': 'awsm\\wp\\boilerplate',
        'bootstrapFile': 'apo-knowloedge-base.php',
        'devUrl': 'http://localhost',
    };

module.exports = configDefault;