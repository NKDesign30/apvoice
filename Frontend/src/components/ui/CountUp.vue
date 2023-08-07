<template>
  <vue-count-up
    v-if="isInViewport"
    v-bind="attrs"
    v-on="$listeners"
  />
  <span
    v-else
    v-text="from"
  />
</template>

<script>

import CountUp from 'vue-countup-v2';
import { mapGetters } from 'vuex';

export default {
  components: {
    'vue-count-up': CountUp,
  },

  props: {
    from: {
      type: Number,
      default: 0,
    },

    to: {
      type: Number,
      required: true,
    },

    whenInViewport: {
      type: Boolean,
      default: false,
    },
  },

  data() {
    return {
      isInViewport: !this.whenInViewport,
    };
  },

  computed: {
    ...mapGetters(['language']),

    attrs() {
      return {
        ...this.$attrs,
        startVal: this.from,
        endVal: this.to,
        options: {
          separator: '',
          decimal: this.decimalSeparator,
          decimalPlaces: this.decimalPlaces,
        },
      };
    },

    thousandSeparator() {
      return Intl.NumberFormat(this.getLocaleIdentifier())
        .formatToParts(1000)
        .find(({ type }) => type === 'group')
        .value;
    },

    decimalSeparator() {
      return Intl.NumberFormat(this.getLocaleIdentifier())
        .formatToParts(1.1)
        .find(({ type }) => type === 'decimal')
        .value;
    },

    decimalPlaces() {
      if (this.hasDecimalPlaces()) {
        return this.to.toString().split('.')[1].length;
      }
      return 0;
    },
  },

  methods: {
    getLocaleIdentifier() {
      if (this.language === 'en') {
        return 'en-US';
      }

      return `${this.language}-${this.language.toLowerCase()}`;
    },

    observeWhenInViewport() {
      const observer = new IntersectionObserver(([entry]) => {
        if (entry.isIntersecting) {
          this.isInViewport = true;

          observer.disconnect();
        }
      });

      observer.observe(this.$el);

      this.$once('hook:destroyed', () => {
        if (observer && observer.disconnect) {
          observer.disconnect();
        }
      });
    },

    hasDecimalPlaces() {
      return this.to % 1 !== 0 && !Number.isNaN(this.to);
    },
  },

  mounted() {
    if (this.whenInViewport) {
      this.observeWhenInViewport();
    }
  },
};

</script>
