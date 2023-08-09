const configDefault = {
        'plainPrefix': 'dwnld',
        get prefix() {
            return `${this.plainPrefix}_`
        },
        'pluginName': 'ApoDownloads',
        'namespace': 'awsm\\wp\\boilerplate',
        'bootstrapFile': 'apo-downloads.php',
        'devUrl': 'http://localhost',
    };

module.exports = configDefault;