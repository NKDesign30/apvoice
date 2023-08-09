<template>
  <div class="cms-container">
    <!-- <maintenance v-if="!isAuthenticated && isHomePage && (language === 'es')" /> -->
    <apo-login-form
      v-if="!isAuthenticated && isHomePage & (language !== 'en') "
    />
    <apo-international-links v-else-if="language === 'en'" />
    <template v-else>
      <apo-not-found-page v-if="pageNotFound" />
      <apo-cms-page
        v-else
        :content="content"
      />
    </template>
  </div>
</template>

<script>
import { mapGetters, mapState } from 'vuex';
import CmsPage from '@/components/cms/CmsPage.vue';
import NotFoundPage from '@/components/cms/NotFoundPage.vue';
import LoginForm from '@/components/login/LoginForm.vue';
import InternationalLinks from '@/components/frontpage/InternationalLinks.vue';
import PageService from '@/services/api/PageService';
import themeSettings from '@/mixins/theme-settings';
import {
  PAGES_ADD_PAGE,
  PAGES_SET_CURRENT_PAGE,
} from '@/store/types/action-types';

export default {
  components: {
    'apo-cms-page': CmsPage,
    'apo-login-form': LoginForm,
    'apo-not-found-page': NotFoundPage,
    'apo-international-links': InternationalLinks,
  },

  mixins: [themeSettings('default')],

  data() {
    return {
      content: {},
      title: '',
      canonicalUrl: '/',
      pageNotFound: false,
      isPublicPage: false,
      isHomePage: false,
    };
  },

  head() {
    return {
      title: {
        inner: this.title,
      },
      link: [{ rel: 'canonical', href: this.canonicalUrl, id: 'canonical' }],
    };
  },

  computed: {
    ...mapState({
      pages: state => state.pages.pages,
      currentPage: state => state.pages.currentPage,
    }),

    ...mapGetters(['isAuthenticated', 'language']),
  },

  watch: {
    $route: {
      immediate: true,
      handler(newRoute) {
        this.loadPage(newRoute);
      },
    },

    currentPage(newPage) {
      this.isPublicPage = newPage.isPublic;
      this.content = Array.isArray(newPage.acf) ? {} : newPage.acf;
      this.title = newPage.title;
      this.canonicalUrl = `${window.location.protocol}//${window.location.host}${window.location.pathname}`;

      this.$emit('updateHead');
    },
  },

  methods: {
    loadPage(route) {
      this.pageNotFound = false;
      this.isHomePage = false;
      if (route.path === '/') {
        this.isHomePage = true;
        this.loadHomePage();
      } else if (this.isPageKnown(route)) {
        this.loadKnownPage(route);
      } else {
        this.loadUnknownPage(route);
      }
    },

    loadHomePage() {
      if (this.isAuthenticated) {
        this.$router.push({ name: 'welcome' });
      }
    },

    loadKnownPage(route) {
      const knownPage = PageService.findByPath(this.pages, route.path);

      if (knownPage) {
        this.$Progress.start();
        this.$Progress.set(30);

        PageService.getPage(knownPage)
          .then(page => {
            this.$store.dispatch(PAGES_SET_CURRENT_PAGE, page);
            this.$Progress.finish();
          })
          .catch(() => {
            this.pageNotFound = true;
            this.$Progress.fail();
          });
      } else {
        this.pageNotFound = true;
        this.$Progress.fail();
      }
    },

    loadUnknownPage(route) {
      this.$Progress.start();
      this.$Progress.set(30);
      PageService.getPageBySlug(route.path)
        .then(page => {
          this.$store.dispatch(PAGES_ADD_PAGE, {
            id: page.id,
            path: page.path,
          });
          this.$store.dispatch(PAGES_SET_CURRENT_PAGE, page);

          this.$Progress.finish();
        })
        .catch(() => {
          this.pageNotFound = true;
          this.$Progress.fail();
        });
    },

    isPageKnown(route) {
      return this.pages.some(page => page.path === route.path);
    },
  },
};
</script>
