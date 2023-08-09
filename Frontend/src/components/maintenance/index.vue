<template>
  <div style="height: 60vh">
    <div class="login-wrapper">
      <div class="container py-24 mx-auto">
        <div class="flex flex-col items-center login">
          <h1 class="text-xs login__headline text-[25px]">
            Hola queridos usuarios, <br> Actualmente estamos revisando nuestro sitio
            web. <br> Por favor, vuelva más tarde. <br>Saludos de su equipo de Apovoice
          </h1>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import get from "lodash/get";
import TextInput from "@/components/form-renderer/TextInput.vue";
import { AUTH_LOGIN } from "@/store/types/action-types";
import { AUTH_UPDATE_SHOW_UPDATE_PHARMACY_MODAL } from "@/store/types/mutation-types";
import Frontpage from "@/components/frontpage/Frontpage.vue";
import PageService from "@/services/api/PageService";

export default {
  components: {
    "apo-text-input": TextInput,
    "apo-frontpage": Frontpage,
  },

  data() {
    return {
      form: {
        username: "",
        password: "",
      },
      loginStatus: "",
      isBusy: false,
    };
  },

  methods: {
    login() {
      this.isBusy = true;
      this.loginStatus = this.$t("pages.login.messages.pending");

      window.axios
        .post("/wp-json/jwt-auth/v1/token", this.form)
        .then(({ data }) => {
          if (Object.keys(data).includes("has_updated_pharmacy_address")) {
            this.$store.commit(
              AUTH_UPDATE_SHOW_UPDATE_PHARMACY_MODAL,
              !data.has_updated_pharmacy_address
            );
          }
          this.loginStatus = this.$t("pages.login.messages.success");

          this.$store
            .dispatch(AUTH_LOGIN, {
              token: data.token,
              user: {
                name: data.user_display_name,
                email: data.user_email,
              },
            })
            .then(() => {
              PageService.getPages().then((dataPages) => {
                this.$store.commit("addPageContent", dataPages);
                const tmpData = dataPages.filter((page) => page.acf.slides);
                tmpData.forEach((page) => {
                  this.$store.commit("addStage", {
                    name: page.slug,
                    stage: {
                      minimum_height: page.acf.minimum_height,
                      slides: page.acf.slides,
                    },
                  });
                });

                if (this.$route.query.redirect_path) {
                  this.$router.replace({
                    path: this.$route.query.redirect_path,
                  });
                } else {
                  this.$router.replace("/welcome");
                }
              });
            });
        })
        .catch((error) => {
          const errorCode = get(error, "response.data.code", "").replace(
            /\[jwt_auth\]\s+/g,
            ""
          );

          const errorMessage = get(error, "response.data.message", "");
          const errorStatus = get(error, "response.status", 0);

          if (
            errorMessage.indexOf("You are temporarily locked out") !== -1 &&
            errorStatus === 503
          ) {
            this.loginStatus = this.$t("errors.too_many_retries");
            /**
             * The 'incorrect_password' error must be translated on the frontend,
             * because wordfence provides an translation issue that is not resolved.
             * Maybe this can be fixed in the future.
             * @link https://wordpress.org/support/topic/cant-translate-error-the-username-or-password-you-entered-is-incorrect/
             */
          } else if (
            errorCode === "too_many_retries" ||
            errorCode === "incorrect_password"
          ) {
            // const match = error.response.data.message.match(/(\d+).*?(\w+)/);
            this.loginStatus = this.$t(`errors.${errorCode}`);
          } else {
            this.loginStatus = get(error, "response.data.message", "");
          }
        })
        .finally(() => {
          this.isBusy = false;
        });
    },

    onRegisterClick() {
      this.$router.push("/registration");
    },
  },
};
</script>

<style lang="scss" scoped>
.login {
  &-wrapper {
    background: linear-gradient(
      120deg,
      theme("colors.blue.600"),
      theme("colors.blue.400")
    );

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
      border-color: theme("colors.white");
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
      line-height: 3.75rem;
    }

    @screen desktop {
      font-size: 3.75rem;
      line-height: 4.375rem;
    }
  }
}
</style>
