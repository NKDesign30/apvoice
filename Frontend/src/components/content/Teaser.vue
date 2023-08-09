<template>
  <div
    v-if="isVisible"
    :class="'teaser flex flex-col items-center py-48 bg-white' + theme"
  >
    <div class="container">
      <h2
        v-if="teaser.headline"
        class="text-center text-6xl leading-none mb-2"
        v-html="$options.filters.formatContent(teaser.headline)"
      />
    </div>
    <hr
      v-if="teaser.headline"
      class="h-1 my-2 w-full"
      :style="customColor ? 'background-color:' + customColor : null"
    >
    <div class="container flex flex-col items-center mt-5">
      <div
        v-if="teaser.subline"
        class="container text-center text-3xl"
        v-html="$options.filters.formatContent(teaser.subline)"
      />
      <div
        v-if="teaser.text"
        class="container mt-2 text-center text-2xl"
        v-html="$options.filters.formatContent(teaser.text)"
      />
    </div>
    <router-link
      v-if="teaser.button"
      class="button--primary shadow-hard-dark text-white mt-8 teaser-button"
      tag="apo-button"
      :to="teaser.button.link"
      :style="customColor ? 'background-color:' + customColor : null"
    >
      {{ teaser.button.label }}
    </router-link>
  </div>
</template>

<script>

import { mapGetters } from 'vuex';

export default {
  props: {
    teaser: {
      type: Object,
      required: true,
    },
  },
  computed: {
    ...mapGetters(['user']),

    isVisible() {
      if (typeof this.teaser.userrole === 'object' && this.teaser.userrole.length > 0 && !this.teaser.userrole.includes('NO_RESTRICTION')) {
        const res = this.teaser.userrole.find(item => this.user.roles.includes(item));
        return typeof res !== 'undefined';
      }
      return true;
    },

    theme() {
      return this.teaser.color_scheme.theme !== 'none' ? ` theme-${this.teaser.color_scheme.theme}` : null;
    },

    customColor() {
      if (this.teaser.color_scheme.custom_color) {
        return this.teaser.color_scheme.custom_color;
      }
      return null;
    },
  },
};

</script>

<style lang="scss" scoped>

  .theme-default {
    hr {
      background-color: theme('colors.blue.600');
    }
  }

  .theme-training {
    hr {
      background-color: theme('colors.training.500');
    }
  }

  .theme-survey {
    hr {
      background-color: theme('colors.orange.600');
    }
  }

  .theme-knowledge-base,
  .theme-downloads {
    hr {
      background-color: theme('colors.purple.500');
    }
  }

  .theme-raffle {
    hr {
      background-color: theme('colors.green.500');
    }
  }

  #app {
    .theme-training {
      hr {
        background-color: theme('colors.training.500');
      }
    }

    .theme-survey {
      hr {
        background-color: theme('colors.orange.600');
      }
    }

    .theme-knowledge-base,
    .theme-downloads {
      hr {
        background-color: theme('colors.purple.500');
      }
    }

    .theme-raffle {
      hr {
        background-color: theme('colors.green.500');
      }
    }
  }

</style>
