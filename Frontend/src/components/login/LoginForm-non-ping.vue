<template>
  <div class="login-page">
    <div class="login-wrapper">
      <div class="container py-24 mx-auto">
        <div class="flex flex-col items-center login">
          <h1
            class="text-xs login__headline text-[25px]"
            v-html="$t('pages.login.intro')"
          />
          <form
            class="relative w-full max-w-2xl mt-12 tablet:mt-24"
            @submit.prevent="login"
          >
            <apo-text-input
              v-model="form.username"
              class="login-text-input-wrapper"
              input-class="login-text-input"
              :placeholder="$t('pages.login.form.username.placeholder')"
              :title="$t('pages.login.form.username.title')"
              type="text"
              @input="loginStatus = ''"
            >
              <!-- <template #before>
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 70.8 79.5"
                  fill="hsla(0, 0%, 100%, 0.75)"
                  class="absolute w-4 h-4 ml-8"
                >
                   eslint-disable-next-line max-len
                  <path d="M35.4 36.4c-10 0-18.2-8.1-18.2-18.2C17.2 8.2 25.4 0 35.4 0s18.2 8.1 18.2 18.2c0 10-8.2 18.2-18.2 18.2zm35.4 43.1H0v-5c0-18.7 15.3-34 34-34h2.8c18.7 0 34 15.3 34 34v5z" />
                </svg>
              </template> -->
            </apo-text-input>

            <apo-text-input
              v-model="form.password"
              class="mt-6 login-text-input-wrapper"
              input-class="login-text-input"
              :placeholder="$t('pages.login.form.password.placeholder')"
              :title="$t('pages.login.form.password.title')"
              type="password"
              @input="loginStatus = ''"
            >
              <!-- <template #before>
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 26 32"
                  fill="hsla(0, 0%, 100%, 0.75)"
                  class="absolute w-4 h-4 ml-8"
                >
                   eslint-disable-next-line max-len
                  <path d="M25 13h-2v-3c0-5.51-4.49-10-10-10S3 4.49 3 10v3H1c-.55 0-1 .45-1 1v17c0 .55.45 1 1 1h24c.55 0 1-.45 1-1V14c0-.55-.45-1-1-1zM5 10c0-4.41 3.59-8 8-8s8 3.59 8 8v3H5v-3zm9 13.72V25c0 .55-.45 1-1 1s-1-.45-1-1v-1.28c-.6-.35-1-.98-1-1.72 0-1.1.9-2 2-2s2 .9 2 2c0 .74-.4 1.38-1 1.72z" />
                </svg>
              </template> -->
            </apo-text-input>

            <div
              v-if="loginStatus"
              class="w-full mt-2 text-sm text-center text-white"
              v-html="$t(loginStatus)"
            />

            <div
              class="flex flex-wrap mt-8 -mx-2 tablet:flex-row tablet:flex-no-wrap"
            >
              <div class="w-full px-2 tablet:w-1/2">
                <apo-button
                  class="w-full text-white button button--primary "
                  :class="{ 'cursor-wait': isBusy }"
                  :disabled="isBusy"
                  type="button"
                  @click.native="onRegisterClick"
                  v-text="$t('pages.login.form.buttons.register')"
                />
              </div>
              <div class="order-first w-full px-2 mb-6 tablet:w-1/2 tablet:mb-0 tablet:order-last">
                <apo-button
                  class="w-full text-blue-600 button--naked "
                  :class="{ 'cursor-wait': isBusy }"
                  :disabled="isBusy"
                  v-text="$t('pages.login.form.buttons.signin')"
                />
              </div>
            </div>

            <div class="mt-16 text-center">
              <!-- eslint-disable max-len -->
              <router-link
                class="text-white border-b border-white hover:border-gray-transparent transition-normal transition-ease transition-border-color"
                :to="{ name: 'forgotten' }"
                v-text="$t('pages.login.form.buttons.forgotten')"
              />
            <!-- eslint-enable max-len -->
            </div>
          </form>
        </div>
      </div>
    </div>
    <apo-frontpage />
  </div>
</template>

<script>

import get from 'lodash/get';
import TextInput from '@/components/form-renderer/TextInput.vue';
import { AUTH_LOGIN } from '@/store/types/action-types';
import { AUTH_UPDATE_SHOW_UPDATE_PHARMACY_MODAL } from '@/store/types/mutation-types';
import Frontpage from '@/components/frontpage/Frontpage.vue';
import PageService from '@/services/api/PageService';

export default {
  components: {
    'apo-text-input': TextInput,
    'apo-frontpage': Frontpage,
  },

  data() {
    return {
      form: {
        username: '',
        password: '',
      },
      loginStatus: '',
      isBusy: false,
    };
  },

  methods: {
    login() {
      this.isBusy = true;
      this.loginStatus = this.$t('pages.login.messages.pending');

      window.axios.post('/wp-json/jwt-auth/v1/token', this.form)
        .then(({ data }) => {
          if (Object.keys(data).includes('has_updated_pharmacy_address')) {
            this.$store.commit(
              AUTH_UPDATE_SHOW_UPDATE_PHARMACY_MODAL,
              !data.has_updated_pharmacy_address,
            );
          }
          this.loginStatus = this.$t('pages.login.messages.success');

          this.$store
            .dispatch(AUTH_LOGIN, {
              token: data.token,
              user: {
                name: data.user_display_name,
                email: data.user_email,
              },
            })
            .then(() => {
              PageService.getPages()
                .then(dataPages => {
                  this.$store.commit('addPageContent', dataPages);
                  const tmpData = dataPages.filter(page => page.acf.slides);
                  tmpData.forEach(page => {
                    this.$store.commit('addStage', { name: page.slug, stage: { minimum_height: page.acf.minimum_height, slides: page.acf.slides } });
                  });

                  if (this.$route.query.redirect_path) {
                    this.$router.replace({
                      path: this.$route.query.redirect_path,
                    });
                  } else {
                    this.$router.replace('/welcome');
                  }
                });
            });
        })
        .catch(error => {
          const errorCode = get(error, 'response.data.code', '').replace(/\[jwt_auth\]\s+/g, '');

          const errorMessage = get(error, 'response.data.message', '');
          const errorStatus = get(error, 'response.status', 0);

          if (errorMessage.indexOf('You are temporarily locked out') !== -1 && errorStatus === 503) {
            this.loginStatus = this.$t('errors.too_many_retries');
            /**
             * The 'incorrect_password' error must be translated on the frontend,
             * because wordfence provides an translation issue that is not resolved.
             * Maybe this can be fixed in the future.
             * @link https://wordpress.org/support/topic/cant-translate-error-the-username-or-password-you-entered-is-incorrect/
            */
          } else if (
            errorCode === 'too_many_retries'
            || errorCode === 'incorrect_password'
          ) {
            // const match = error.response.data.message.match(/(\d+).*?(\w+)/);
            this.loginStatus = this.$t(`errors.${errorCode}`);
          } else {
            this.loginStatus = get(error, 'response.data.message', '');
          }
        })
        .finally(() => {
          this.isBusy = false;
        });
    },

    onRegisterClick() {
      this.$router.push('/registration');
    },
  },
};

</script>

<style lang="scss" scoped>

.login {
  &-wrapper {
    background: linear-gradient(120deg, theme('colors.blue.600'), theme('colors.blue.400'));

    .button {
      @apply py-6;
      @apply px-4;
    }
  }

  /deep/ &-text-input {
    @apply pl-16;
    @apply pr-8;
    @apply py-6;
    @apply text-white;

    &:hover,
    &:focus {
      background-color: hsla(0, 0%, 100%, 0.08);
      border-color: theme('colors.white');
    }

    &-wrapper {
      @apply border-4;
      @apply border-white;
    }
  }

  &__headline {
    @apply text-center;
    @apply text-white;
    @apply font-display;
    @apply text-3xl;
    line-height: 2.5rem;
    font-weight: 300;

    @screen tablet {
      font-size: 3.125rem;
      line-height: 3.75rem,
    }

    @screen desktop {
      font-size: 3.75rem;
      line-height: 4.375rem;
    }
  }


}


</style>
