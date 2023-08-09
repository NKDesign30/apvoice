<template>
  <div
    v-show="!isBusy"
    class="user-activation"
  >
    <div class="container my-24">
      <h1
        v-if="success"
        class="text-center headine-1"
        v-text="$t('pages.userActivation.headlines.success')"
      />
      <h1
        v-else
        class="text-center headine-1"
        v-text="$t('pages.userActivation.headlines.failed')"
      />
      <div class="mt-12 flex justify-center">
        <div class="p-8 inline-block border-8 border-gray-900 rounded-full text-center">
          <apo-icon
            class="w-32 text-gray-900"
            src="check"
          />
        </div>
      </div>

      <div class="flex flex-col mt-12 text-center jusitfy-center">
        <p
          class="mt-6 text-xl text-center leading-2xl"
          v-html="$t('pages.userActivation.firstParagraph')"
        />
        <p
          class="mt-6 text-xl text-center leading-2xl"
          v-html="$t('pages.userActivation.secondParagraph')"
        />
        <p
          class="mt-6 text-xl text-center leading-2xl"
          v-html="$t('pages.userActivation.thirdParagraph')"
        />

        <div class="mt-12 ">
          <apo-button
            class="text-white button button--primary shadow-hard-dark"
            type="button"
            @click.native="onLoginClick"
            v-text="$t('pages.userActivation.button')"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import UserService from '@/services/api/UserService';
import { canonicalTag } from '@/services/utils';

export default {
  data() {
    return {
      isBusy: true,
      errors: [],
      success: false,
    };
  },

  head() {
    return {
      title: {
        inner: this.$t('pages.userActivation.meta.title'),
      },
      link: [
        canonicalTag(this.$route),
      ],
    };
  },

  methods: {
    onLoginClick() {
      this.$router.replace('/');
    },
  },

  created() {
    UserService.activateUser(this.$route.params.key)
      .then(() => {
        this.success = true;
      })
      .catch(errors => {
        this.errors = errors;
      })
      .finally(() => {
        this.isBusy = false;
      });
  },
};

</script>
