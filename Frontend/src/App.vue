<template>
  <div
    id="app"
    class="flex flex-col font-display text-gray-900"
    :class="themeClass"
  >
    <apo-header />
    <apo-page-progress class="page-progress" />

    <vue-page-transition name="fade-in-up">
      <apo-pharmacy-confirmation-modal v-if="isAuthenticated && showUpdatePharmacyModal" />
    </vue-page-transition>
    <vue-page-transition name="fade-in-up">
      <apo-stage
        v-if="stageData && isAuthenticated"
        :stage-data="stageData"
      />
    </vue-page-transition>

    <main class="flex-auto">
      <vue-page-transition name="fade-in-up">
        <router-view />
      </vue-page-transition>
      <apo-cookies-settings v-if="language !== 'en'" />
    </main>

    <apo-footer />
  </div>
</template>

<script>

import last from 'lodash/last';
import { mapGetters, mapState } from 'vuex';
import Header from '@/components/template/Header.vue';
import Stage from '@/components/template/Stage.vue';
import Footer from '@/components/template/Footer.vue';
import CookiesSettings from '@/components/template/CookiesSettings.vue';
import PharmacyConfirmationModal from '@/components/pharmacies/PharmacyConfirmationModal.vue';
import PageProgress from '@/components/template/PageProgress.vue';
import PageService from '@/services/api/PageService';
import {
  PAGES_FETCH_MENUS,
  SETTINGS_FETCH_SETTINGS,
  SETTINGS_SET_CURRENT_VIEWPORT,
} from '@/store/types/action-types';

const screens = require('./tailwind/Screens');

export default {
  components: {
    'apo-footer': Footer,
    'apo-stage': Stage,
    'apo-header': Header,
    'apo-page-progress': PageProgress,
    'apo-cookies-settings': CookiesSettings,
    'apo-pharmacy-confirmation-modal': PharmacyConfirmationModal,
  },
  data() {
    return {
      stageData: '',
    };
  },

  computed: {
    ...mapGetters(['isAuthenticated', 'theme', 'settingsLoaded', 'language', 'showUpdatePharmacyModal']),
    ...mapState({
      settings: state => state.settings.settings,
    }),

    themeClass() {
      return `theme-${this.theme}`;
    },

    sortedScreens() {
      return Object.entries(screens)
        .sort(([, minWidthA], [, minWidthB]) => {
          const a = parseInt(minWidthA, 10);
          const b = parseInt(minWidthB, 10);

          if (a > b) {
            return 1;
          }

          if (a < b) {
            return -1;
          }

          return 0;
        });
    },
  },

  watch: {
    isAuthenticated: {
      immediate: true,
      handler(isAuthenticated) {
        if (isAuthenticated) {
          window.eventBus.$emit('authenticated');
        }
      },
    },
    settingsLoaded: {
      immediate: true,
      handler(settingsLoaded) {
        if (settingsLoaded) {
          window.eventBus.$emit('settingsLoaded');
        }
      },
    },

    language: {
      immediate: true,
      handler(language) {
        let docLang = language;
        if (language === 'at') { docLang = 'de'; }
        document.documentElement.lang = docLang;
      },
    },

    $route: {
      immediate: true,
      handler(route) {
        if (this.isAuthenticated) {
          this.stageData = '';
          this.loadStage(route);
        }
      },
    },
  },

  methods: {
    initializeState() {
      this.$store.dispatch(SETTINGS_FETCH_SETTINGS);
      this.$store.dispatch(PAGES_FETCH_MENUS);
      if (this.isAuthenticated) {
        this.$Progress.start();
        this.$Progress.set(30);
        PageService.getPages()
          .then(data => {
            this.$store.commit('addPageContent', data);
            const tmpData = data.filter(page => page.acf.slides);
            tmpData.forEach(page => {
              this.$store.commit('addStage', { name: page.slug, stage: { minimum_height: page.acf.minimum_height, slides: page.acf.slides } });
            });
            this.$Progress.finish();
            this.loadStage(this.$route);
          });
      }
    },

    loadStage(route) {
      const storedData = this.$store.state.pages.stages.filter(stage => stage.name === route.path.replace(/\//g, '')).length === 1 ? this.$store.state.pages.stages.filter(stage => stage.name === route.path.replace(/\//g, ''))[0].stage : '';
      if (storedData) {
        window.setTimeout(() => {
          this.stageData = storedData;
        }, 100);
      }
    },

    initializeCodeSnippets() {
      const unwatch = this.$watch('settings', settings => {
        unwatch();

        this.evaluateCodeSnippets(settings.headCodeSnippets, 'head');
        this.evaluateCodeSnippets(settings.bodyCodeSnippets, 'body');
      });
    },

    evaluateCodeSnippets(snippets, wrappingElement) {
      this.cleanSnippets(snippets).forEach(codeSnippet => {
        const attributes = this.extractAttributes(codeSnippet);
        const scriptTag = document.createElement('script');
        let fn = null;

        Object.keys(attributes).forEach(key => {
          if (key === 'onload') {
            fn = attributes[key];
          }
          scriptTag.setAttribute(key, attributes[key]);
        });

        if (!scriptTag.hasAttribute('type')) {
          scriptTag.type = 'text/javascript';
        }

        const strippedCodeSnippet = codeSnippet.replace(/<script[^>]*>/im, '');

        scriptTag.text = strippedCodeSnippet;

        this.loadAsync(scriptTag, wrappingElement)
          .then(() => {
            if (fn) {
              try {
              // eslint-disable-next-line no-eval
                eval(fn);
              } catch (e) {
                console.log(e);
              }
            }
          });
      });
    },

    loadAsync(script, wrappingElement) {
      return new Promise(resolve => {
        document.getElementsByTagName(wrappingElement)[0].appendChild(script);

        script.addEventListener('load', () => {
          // this timeout is required to execute correctly all onload functions
          // this isn't a great solution but its not so common to add onload attributes
          // and a good workaround
          setTimeout(() => {
            resolve(true);
          }, 350);
        });
      });
    },

    cleanSnippets(snippets) {
      return snippets
        .split(/<\/script>/im)
        .map(snippet => snippet.replace(/<!--(.*?)-->/im, ''))
        .map(snippet => snippet.trim())
        .filter(snippet => snippet.length > 0);
    },

    extractAttributes(snippet) {
      const attributesWithValues = snippet.match(/(\S*)="(.*?)"/g);
      if (attributesWithValues) {
        const values = attributesWithValues.map(a => a.match(/"(.*?)"/g)[0].replace(/"/g, ''));
        const attributes = attributesWithValues.map(a => a.match(/[^=]*/i)[0]);
        return attributes.reduce((attribute, key, i) => ({ ...attribute, [key]: values[i] }), {});
      }

      return {};
    },

    registerViewportObserver() {
      this.sortedScreens.forEach(([viewport, minWidth]) => {
        const mediaQuery = window.matchMedia(`(min-width: ${minWidth})`);

        const listener = event => {
          if (event.matches) {
            return this.$store.dispatch(SETTINGS_SET_CURRENT_VIEWPORT, viewport);
          }

          const matchingViewports = this.sortedScreens
            // eslint-disable-next-line max-len
            .filter(([, matchingMinWidth]) => parseInt(minWidth, 10) > parseInt(matchingMinWidth, 10))
            .map(([matchingViewport]) => matchingViewport);

          const currentViewport = matchingViewports.length > 0
            ? last(matchingViewports)
            : 'mobile';

          return this.$store.dispatch(SETTINGS_SET_CURRENT_VIEWPORT, currentViewport);
        };

        mediaQuery.addListener(listener);

        this.$once('hook:destroyed', () => {
          mediaQuery.removeListener(listener);
        });

        if (mediaQuery.matches) {
          this.$store.dispatch(SETTINGS_SET_CURRENT_VIEWPORT, viewport);
        }
      });
    },
  },

  created() {
    this.initializeState();
    this.initializeCodeSnippets();
  },

  mounted() {
    this.registerViewportObserver();
  },
};

</script>

<style lang="scss">
*::selection{
  @apply bg-purple-500;
  @apply text-white;
}

html,
body,
#app {
  min-height: 100vh;
}

body {
  @apply bg-white;
}

.page-progress {
  margin-top: calc(theme('spacing.px') * -2);
}

.text-media-paragraph__copy {
  a {
    text-decoration: underline;
  }
}

@media (min-width: theme('screens.desktop')) {
  .spacer-module {
    padding: 3.125rem 0 !important;

    .text-media-paragraph__copy {
      margin-top: 0 !important;
    }
  }
}
</style>
