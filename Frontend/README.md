# Apovoice Frontend

## Project setup
Just nothing!

### PurgeCSS
We are using [PurgeCSS](https://github.com/FullHuman/purgecss) to reduce the size of the resulting stylesheet, including TailwindCSS Utility classes.  
Make sure to *avoid generating dynamic class names*, otherwise PurgeCSS will delete them in production builds.  
A way to work around this caveat is to use the `whitelist` option in the `postcss.config.js` file. Put any dynamically generated class names in here. Refer to the [PurgeCSS Whitelisting Docs](https://www.purgecss.com/whitelisting) for more information.

### Docker
The development environment is dockerized. You can just spin up the container using `docker-compose up` or use the `apovoice.sh` commands.
```sh
./apovoice up       # start the container and attach logging
./apovoice down     # stop the container
./apovoice logs     # attach a logging session to the container
```

### Compiles and hot-reloads for development
```
npm run serve
```

### Compiles and minifies for production
```
npm run build
```

### Run your tests
```
npm run test
```

### Lints and fixes files
```
npm run lint
```

### Customize configuration
See [Configuration Reference](https://cli.vuejs.org/config/).
