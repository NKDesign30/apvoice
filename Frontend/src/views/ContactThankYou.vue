<template>
  <div class="contact-thank-you">
    <div class="container py-24 mx-auto">
      <template v-if="show">
        <h1
          class="text-center text-gray-900"
          v-text="$t('pages.contact.thankYou.headline')"
        />

        <div class="mt-12 text-center">
          <apo-icon
            class="w-48 text-gray-900"
            src="radio_checked"
          />
        </div>

        <div class="flex flex-col items-center">
          <p
            class="max-w-3xl mt-12 text-xl text-center leading-2xl"
            v-html="$t('pages.contact.thankYou.firstParagraph')"
          />
        </div>
      </template>

      <div class="mt-16 text-center">
        <apo-button
          class="text-white button button--primary button--small shadow-hard-dark"
          @click.native="$router.push('/')"
          v-text="$t('pages.contact.thankYou.button')"
        />
      </div>
    </div>
  </div>
</template>

<script>
import { canonicalTag, descriptionTag } from '@/services/utils';

export default {

  data() {
    return {
      show: false,
    };
  },

  head() {
    return {
      title: {
        inner: this.$t('pages.contact.meta.title'),
      },
      meta: [
        descriptionTag(this.$t('pages.contact.meta.description')),
      ],
      link: [
        canonicalTag(this.$route),
      ],
    };
  },

  watch: {
    $route: {
      immediate: true,
      handler(route) {
        if (route.query.submitted) {
          this.show = true;
        } else {
          this.$router.push('/');
        }
      },
    },
  },
};
</script>
