<template>
  <div class="container pageheader">
    <img
      v-if="logo"
      class="pageheader-logo"
      :src="logo"
      :alt="logoAlt"
      :title="logoTitle"
    >
    <div v-if="show_return_button && page_header.headline" class="block tablet:flex justify-between items-start">
      <h1
        class="inline-block pageheader-headline font-display"
        v-html="$options.filters.formatContent(page_header.headline)"
      />
      <router-link class="block tablet:inline-block text-4xl m-0"
                   :to="{
        name: `${this.$route.name}`,
        params: {},

      }"
      >
        <button class="text-white button-class mt-5 px-8 py-2 text-base rounded-full">{{ $t('general.back') }}
        </button>
      </router-link>
    </div>
    <div v-if="show_return_button && !page_header.headline" class="block tablet:flex justify-end items-end">
      <router-link class="block tablet:inline-block text-4xl m-0"
                   :to="{
        name: `${this.$route.name}`,
        params: {},

      }"
      >
        <button class="text-white button-class mt-5 px-8 py-2 text-base rounded-full">{{ $t('general.back') }}
        </button>
      </router-link>
    </div>
    <div v-else-if="!show_return_button && page_header.headline">
      <h1
        class="pageheader-headline font-display"
        v-html="$options.filters.formatContent(page_header.headline)"
      />
    </div>

    <h2
      v-if="page_header.sub_headline"
      class="pageheader-subheadline font-display"
      v-html="$options.filters.formatContent(page_header.sub_headline)"
    />
    <img
      v-if="image"
      class="pageheader-image"
      :src="image"
      :title="imageTitle"
      :alt="imageAlt"
    >
    <div
      v-if="page_header.copy && page_header.copy != ''"
      class="pageheader-copy"
      v-html="$options.filters.formatContent(page_header.copy)"
    />
    <apo-scroller />
  </div>
</template>

<script>
import get from 'lodash/get';

export default {
  props: {
    page_header: {
      type: Object,
      required: true,
    },
    show_return_button: {
      type: Boolean,
      default: false
    }
  },
  computed: {
    logo() {
      return get(this.page_header, 'logo.sizes.large', '');
    },
    logoAlt() {
      return get(this.page_header, 'logo.alt', '');
    },
    logoTitle() {
      return get(this.page_header, 'logo.title', '');
    },
    image() {
      return get(this.page_header, 'image.sizes.large', '');
    },
    imageAlt() {
      return get(this.page_header, 'image.alt', '');
    },
    imageTitle() {
      return get(this.page_header, 'image.title', '');
    },
  },
};

</script>

<style lang="scss" scoped>

  .pageheader {

    > * {
      @apply mx-auto;
      @apply text-center;
    }

    &-logo {
      @apply ml-0;
      @apply text-left;

      max-width: 280px;
      height: 157px;
    }

    &-headline {
      @apply text-5xl;
      @apply mt-4;

      @screen desktop {
        @apply mt-8;
      }
    }

    &-subheadline {
      @apply text-3xl;
    }

    &-image {
      @apply mt-4;
      @apply max-w-full;

      @screen desktop {
        @apply mt-12;
      }
    }

    &-copy {
      @apply mt-4;

      @screen desktop {
        @apply mt-12;
      }
    }

    .training-summary & > *{
      @apply text-white;
    }
  }
  .theme-training {
    .button-class {
      @apply bg-training-500;
    }
  }
  .theme-scientific {
    .button-class {
      @apply bg-scientific-500;
    }
  }

</style>
