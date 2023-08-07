export default {
  functional: true,

  props: {
    name: {
      type: String,
      default: 'fadeIn',
    },
  },

  render(h, { children, props }) {
    const data = {
      props: {
        appear: true,
        appearActiveClass: `animated ${props.name}`,
      },
    };

    return h('transition', data, children);
  },
};
