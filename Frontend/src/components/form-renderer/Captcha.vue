<template>
  <apo-captcha
    :sitekey="captchaWebsiteKey"
    :load-recaptcha-script="true"
  />
</template>

<script>

import VueRecaptcha from 'vue-recaptcha';
import { mapGetters } from 'vuex';

export default {
  components: {
    'apo-captcha': VueRecaptcha,
  },
  props: {
    value: {
      type: String,
      default: '',
    },

    meta: {
      type: Object,
      default() {
        return {
          maxLength: 0,
        };
      },
    },
  },

  computed: {
    ...mapGetters(['captchaWebsiteKey']),

    listeners() {
      return {
        ...this.$listeners,
        input: event => this.$emit('input', event.target.value),
      };
    },
  },
};

</script>
