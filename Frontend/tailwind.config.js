/* eslint-disable import/no-extraneous-dependencies */
const defaultTheme = require('tailwindcss/defaultTheme');
const ContainerComponentPlugin = require('./src/tailwind/ContainerComponentPlugin');
const TypographyComponentsPlugin = require('./src/tailwind/TypographyComponentsPlugin');
const colors = require('./src/tailwind/Colors');
const screens = require('./src/tailwind/Screens');

module.exports = {
  theme: {
    extend: {
      spacing: {
        2.5: '0.625rem',
        7: '1.5625rem',
        7.5: '1.875rem',
        9: '2.1875rem',
        11: '2.25rem',
        13: '3.125rem',
        15: '3.75rem',
        17: '4.375rem',
        23: '5.625rem',
        25: '6.25rem',
        30: '7rem',
        72: '18rem',
      },
    },

    colors,

    borderWidth: {
      ...defaultTheme.borderWidth,

      5: '5px',
      10: '10px',
    },

    borderRadius: {
      ...defaultTheme.borderRadius,

      xl: '2.5rem',
    },

    boxShadow: {
      ...defaultTheme.boxShadow,

      hard: '0 4px 0 1px rgba(0, 0, 0, 0.2)',
      'hard-dark': '0 4px 0 1px rgba(0, 0, 0, 0.4)',
      'inner-light': 'inset 0 1px 0 1px rgba(0, 0, 0, 0.2)',
    },

    fontFamily: {
      ...defaultTheme.fontFamily,
      display: ['"Frutiger LT Std"', 'sans-serif'],
      // display: 'Arial, sans-serif',
      sans: 'Arial, sans-serif',
    },

    fontSize: {
      ...defaultTheme.fontSize,

      '7xl': '5rem',
      '8xl': '6rem',
      '9xl': '8rem',
    },

    fontWeight: {
      normal: 400,
      bold: 700,
      black: 900,
    },

    lineHeight: {
      xl: '1.625rem',
      '2xl': '2rem',
      '3xl': '3rem',
      '5xl': '3.75rem',
    },

    maxWidth: {
      ...defaultTheme.maxWidth,

      xxs: '15rem',
      '2xs': '10rem',
      '3xs': '7.5rem',
      '4xs': '5rem',
      '7xl': '1440px',
    },

    minWidth: {
      ...defaultTheme.minWidth,

      48: '12rem',
    },

    screens,
  },
  variants: {},
  corePlugins: {
    // We use a custom .container helper class, because of the
    // breakpoints of the app (see plugin below)
    container: false,
  },
  plugins: [ContainerComponentPlugin, TypographyComponentsPlugin],
};
