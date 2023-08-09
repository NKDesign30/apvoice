<template>
  <div class="invite-page">
    <apo-wait for="user">
      <apo-loading-overlay
        class="my-15"
        message=""
      />
      <div v-if="user.id > 0">
        <div v-if="content && contentPosition === 'before'">
          <component
            :is="`apo-cms-${renderer}-renderer`"
            v-for="(components, renderer) in content"
            :key="`${renderer}-renderer`"
            :components="components || []"
          />
        </div>
        <div>
          <div class="flex justify-center back-button">
            <apo-button
              class="text-white button button--big button--primary shadow-hard-dark mb-8"
              type="button"
              :disabled="isBusy"
              @click.native="onCreateCodes"
            >
              <apo-spinner
                v-if="isBusy"
                class="mr-4"
                size="small"
              />

              <span v-text="$t('sendInvitation')" />
            </apo-button>
          </div>
          <div
            v-if="notification.show"
            class="mx-auto mb-10 w-full max-w-2xl p-4 rounded-full bg-green-300 text-white shadow-hard"
          >
            <div class="notification-inner mx-auto relative w-11/12">
              <p
                class="w-5/6 mx-auto"
                v-html="notification.message"
              />
              <span class="absolute top-0 right-0">
                <apo-icon
                  class="w-5 cursor-pointer"
                  src="close"
                  @click="SETTINGS_CLEAR_NOTIFICATION"
                />
              </span>
            </div>
          </div>
        </div>
        <div v-if="content && contentPosition === 'after'">
          <component
            :is="`apo-cms-${renderer}-renderer`"
            v-for="(components, renderer) in content"
            :key="`${renderer}-renderer`"
            :components="components || []"
          />
        </div>
        <div
          class="flex justify-center mb-5 container mx-auto"
          v-html="pageData.content.rendered"
        />
      </div>
    </apo-wait>
  </div>
</template>

<script>
import {
  mapGetters, mapState, mapActions, mapMutations,
} from 'vuex';
import themeSettings from '@/mixins/theme-settings';
import CmsContentRenderer from '@/components/cms/CmsContentRenderer.vue';
import { canonicalTag } from '@/services/utils';
import { SETTINGS_CREATE_INVITATIONS } from '@/store/types/action-types';
import { SETTINGS_CLEAR_NOTIFICATION } from '@/store/types/mutation-types';

export default {
  components: {
    'apo-cms-content-renderer': CmsContentRenderer,
  },

  head() {
    return {
      title: {
        inner: this.$t('pages.welcome.meta.title.inner'),
        complement: this.$t('pages.welcome.meta.title.complement'),
      },
      link: [canonicalTag(this.$route)],
    };
  },

  mixins: [themeSettings('default')],

  data() {
    return {
      isBusy: false,
    };
  },

  computed: {
    ...mapGetters(['user']),
    ...mapState({
      settings: state => state.settings.settings,
      notification: state => state.settings.notification,
    }),
    pageData() {
      return this.$store.state.pages.pageContent.filter(
        page => page.slug === this.$route.path.replace(/^\/|\/$/g, ''),
      ).length > 0
        ? this.$store.state.pages.pageContent.filter(
          page => page.slug === this.$route.path.replace(/^\/|\/$/g, ''),
        )[0]
        : null;
    },

    content() {
      if (this.pageData) {
        const {
          /* eslint-disable */
          password,
          minimum_height,
          slides,
          public_resource,
          content_position,
          ...filtered
        } = this.pageData.acf;
        /* eslint-enable */
        return filtered;
      }

      return null;
    },

    contentPosition() {
      return this.pageData ? this.pageData.acf.content_position : null;
    },

    invitationCodes() {
      console.log(this.settings.invitationCodes);
      return this.settings.invitationCodes
        ? this.settings.invitationCodes
        : false;
    },
  },
  methods: {
    ...mapActions([SETTINGS_CREATE_INVITATIONS]),
    ...mapMutations([SETTINGS_CLEAR_NOTIFICATION]),

    onCreateCodes() {
      this.isBusy = true;
      this[SETTINGS_CREATE_INVITATIONS]().finally(() => {
        this.isBusy = false;
      });
    },
  },

  destroyed() {
    this[SETTINGS_CLEAR_NOTIFICATION]();
  },
};
</script>
