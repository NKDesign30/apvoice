module.exports = ({ addComponents, theme }) => {
  const containerComponent = {
    '@variants responsive': {
      '.container': {
        width: theme('width.full'),
        'margin-left': 'auto',
        'margin-right': 'auto',
        'padding-left': '1rem',
        'padding-right': '1rem',
      },
      [`@media (min-width: ${theme('screens.desktop')})`]: {
        '.container': {
          'max-width': theme('maxWidth.5xl'),
          'padding-left': '0',
          'padding-right': '0',
        },
      },
    },
  };

  addComponents(containerComponent);
};
