module.exports = ({ addComponents, theme }) => {
  addComponents({
    '.headline-1': {
      fontSize: '2rem',
      fontFamily: theme('fontFamily.display'),
      lineHeight: '3.75rem',
      fontWeight: 300,
    },

    '.headline-1-tablet': {
      fontSize: '3.125rem',
    },

    '.headline-1-desktop': {
      fontSize: '3.125rem',
      lineHeight: '4.375rem',
    },

    '.headline-2': {
      fontSize: '2.5rem',
      fontFamily: theme('fontFamily.display'),
      fontWeight: 400,
      lineHeight: '3.875rem',
    },

    '.headline-2-desktop': {
      fontSize: '3.125rem',
      lineHeight: '3.95rem',
    },

    '.headline-3': {
      fontSize: '1.875rem',
      fontFamily: theme('fontFamily.display'),
      fontWeight: 300,
      lineHeight: '2.5rem',
    },

    '.headline-3-desktop': {
      fontSize: '2.5rem',
      lineHeight: '3.125rem',
    },

    '.headline-4': {
      fontSize: '1.5625rem',
      fontFamily: theme('fontFamily.display'),
      fontWeight: 300,
      lineHeight: '2.1875rem',
    },

    '.headline-4-desktop': {
      fontSize: '1.5625rem',
      lineHeight: '2.1875rem',
    },

    '.headline-5': {
      fontSize: '1.25rem',
      fontFamily: theme('fontFamily.display'),
      fontWeight: 300,
      lineHeight: '1.5625rem',
    },

    '.headline-5-desktop': {
      fontSize: '1.25rem',
      lineHeight: '1.5625rem',
    },

    '.headline-6': {
      fontSize: '1.25rem',
      fontFamily: theme('fontFamily.sans'),
      fontWeight: 700,
      lineHeight: '1.5625rem',
    },

    '.headline-6-desktop': {
      fontSize: '1.25rem',
      lineHeight: '1.5625rem',
    },

    '.short-copy': {
      fontSize: '1.5625rem',
      fontFamily: theme('fontFamily.display'),
      lineHeight: '2.1875rem',
      fontWeight: 300,
    },

    '.long-copy': {
      fontSize: '1.25rem',
      fontFamily: theme('fontFamily.sans'),
      lineHeight: '1.5625rem',
      fontWeight: 400,
    },

    '.image-description': {
      fontSize: '1.25rem',
      fontFamily: theme('fontFamily.sans'),
      lineHeight: '1.5625rem',
      fontWeight: 400,
    },

    '.image-description-desktop': {
      fontSize: '0.75rem',
      lineHeight: '0.9375rem',
    },

    '.btn-red': {
      backgroundColor: '#e3342f',
      color: '#fff',
      '&:hover': {
        backgroundColor: '#cc1f1a',
      },
    },

    '.sources': {
      fontSize: '0.9375rem',
      fontFamily: theme('fontFamily.sans'),
      lineHeight: '1.25rem',
      fontWeight: 400,
    },

    '.sources-desktop': {
      fontSize: '0.625rem',
      lineHeight: '0.9375rem',
    },
  });
};
