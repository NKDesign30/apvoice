<template>
  <div
    v-show="!isBusy"
    class="user-activation"
  >
    <div class="container my-24">
      <h1
        v-if="success"
        class="text-center headine-1"
        v-text="$t('pages.userConfirmMail.headlines.success')"
      />
      <h1
        v-else
        class="text-center headine-1"
        v-text="$t('pages.userConfirmMail.headlines.failed')"
      />
      <div class="mt-12 flex justify-center">
        <div class="p-8 inline-block border-8 border-gray-900 rounded-full text-center">
          <apo-icon
            v-if="success"
            class="w-32 text-gray-900"
            src="check"
          />
          <apo-icon
            v-else
            class="w-32 text-gray-900"
            src="close"
          />
        </div>
      </div>

      <div class="flex flex-col mt-12 text-center jusitfy-center">
        <p
          v-if="success"
          class="mt-6 text-xl text-center leading-2xl"
          v-html="$t('pages.userConfirmMail.firstParagraph')"
        />
        <p
          v-if="success"
          class="mt-6 text-xl text-center leading-2xl"
          v-html="$t('pages.userConfirmMail.secondParagraph')"
        />
        <p
          v-if="success"
          class="mt-6 text-xl text-center leading-2xl"
          v-html="$t('pages.userConfirmMail.thirdParagraph')"
        />
        <p
          v-for="(error, i) in errors"
          v-else
          :key="i"
          class="mt-6 text-xl text-center leading-2xl"
          v-html="error"
        />

        <div class="mt-12 ">
          <apo-button
            class="text-white button button--primary shadow-hard-dark"
            type="button"
            @click.native="onLoginClick"
            v-text="$t('pages.userConfirmMail.button')"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import UserService from '@/services/api/UserService';
import { canonicalTag } from '@/services/utils';
import { AUTH_LOGOUT_WITHOUT_REDIRECT } from '@/store/types/action-types';

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
        inner: this.$t('pages.userConfirmMail.meta.title'),
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
    // console.log(this.$route.params.key);
    this.$store.dispatch(AUTH_LOGOUT_WITHOUT_REDIRECT);

    UserService.confirmEmail(this.$route.params.key)
      .then(data => {
        console.log('data then');
        console.log(data);
        if (!data.messages) {
          this.success = true;
        } else {
          this.errors = data.errors;
        }
      })
      .catch(errors => {
        console.log('error');
        console.log(errors);
        this.errors = errors;
      })
      .finally(() => {
        this.isBusy = false;
      });
  },
};

</script>
