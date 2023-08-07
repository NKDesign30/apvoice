import { WOW } from 'wowjs';

const capitalize = word => word.charAt(0).toUpperCase() + word.slice(1);

const supportedOptions = ['duration', 'delay', 'offset', 'iteration'];
let wowInstance;

class Plugin {
  /* eslint-disable class-methods-use-this, no-param-reassign */
  install(Vue, options = {}) {
    Vue.directive('wow', {
      bind(element, binding) {
        if (!wowInstance) {
          wowInstance = new WOW(options);
          wowInstance.init();
        }

        const classes = [
          'wow',
          ...Object.keys(binding.modifiers),
        ];

        classes.forEach(className => {
          if (!element.classList.contains(className)) {
            element.classList.add(className);
          }
        });

        if (binding.value) {
          Object.entries(binding.value)
            .filter(([property]) => supportedOptions.includes(property))
            .forEach(([property, value]) => {
              element.dataset[`wow${capitalize(property)}`] = value;
            });
        }
      },

      inserted() {
        if (wowInstance) {
          wowInstance.sync();
        }
      },

      updated() {
        if (wowInstance) {
          wowInstance.sync();
        }
      },

      unbind(element, binding) {
        const classes = [
          'wow',
          ...Object.keys(binding.modifiers),
        ];

        classes.forEach(className => {
          if (element.classList.contains(className)) {
            element.classList.remove(className);
          }
        });

        supportedOptions.forEach(option => {
          if (element.dataset[`wow${capitalize(option)}`]) {
            delete element.dataset[`wow${capitalize(option)}`];
          }
        });
      },
    });
  }
  /* eslint-enable class-methods-use-this, no-param-reassign */
}

export default new Plugin();
