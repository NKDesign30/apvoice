const svgFiles = require.context('!svg-sprite-loader!@/assets/svg', false, /.*\.svg$/);
svgFiles.keys().forEach(svgFiles);
