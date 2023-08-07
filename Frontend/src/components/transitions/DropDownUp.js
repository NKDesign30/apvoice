export default {
  functional: true,

  render(h, { children }) {
    const data = {
      props: {
        enterActiveClass: 'transition-all transition-fastest transition-ease-out',
        leaveActiveClass: 'transition-all transition-faster transition-ease-in',
        enterClass: 'opacity-0 scale-75 translate-y-4',
        enterToClass: 'opacity-100 scale-100 translate-y-0',
        leaveClass: 'opacity-100 scale-100 translate-y-0',
        leaveToClass: 'opacity-0 scale-75 translate-y-4',
      },
    };

    return h('transition', data, children);
  },
};
