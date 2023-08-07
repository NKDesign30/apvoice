<template>
  <div class="thank-you">
    <div class="container py-24 mx-auto">
      <h1
        class="text-center text-gray-900"
        v-text="$t('pages.thankYou.headline')"
      />

      <div class="mt-12 text-center">
        <apo-icon
          class="w-48 text-gray-900"
          src="mail"
        />
      </div>

      <div class="flex flex-col items-center">
        <p
          class="max-w-3xl mt-12 text-xl text-center leading-2xl"
          v-html="$t('pages.thankYou.firstParagraph')"
        />
        <p
          class="max-w-3xl mt-12 text-xl text-center leading-2xl"
          v-html="$t('pages.thankYou.secondParagraph')"
        />
      </div>

      <div class="mt-16 text-center">
        <apo-button
          class="text-white button button--primary button--small shadow-hard-dark"
          @click.native="$router.push('/')"
          v-text="$t('pages.thankYou.button')"
        />
      </div>
    </div>
  </div>
</template>

<script>
import { canonicalTag } from '@/services/utils';

export default {
  head() {
    return {
      title: {
        inner: this.$t('pages.thankYou.meta.title'),
      },
      link: [
        canonicalTag(this.$route),
      ],
    };
  },
};
</script>
