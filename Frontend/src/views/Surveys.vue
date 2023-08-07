<template>
  <apo-restrict-content-wrapper>
    <div v-if="isOverview">
      <available-surveys
        :show-header-section="true"
        :surveys-title-text="surveysTitleText"
      />
    </div>
    <template v-else>
      <apo-survey
        v-if="survey"
        :survey="survey"
      />
    </template>
  </apo-restrict-content-wrapper>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

import CmsContentRenderer from '@/components/cms/CmsContentRenderer.vue';
import Survey from '@/components/survey/Survey.vue';
import AvailableSurveys from '@/components/survey/overview/AvailableSurveys';
import themeSettings from '@/mixins/theme-settings';
import { canonicalTag } from '@/services/utils';
import { SURVEYS_FETCH_ALL } from '@/store/types/action-types';

export default {
  components: {
    'apo-cms-content-renderer': CmsContentRenderer,
    'apo-survey': Survey,
    'available-surveys': AvailableSurveys,
  },

  mixins: [themeSettings('survey')],

  data() {
    return {
      isOverview: true,
      showAchTooltip: false,
    };
  },

  head() {
    return {
      title: {
        inner: this.$t('pages.surveys.meta.title'),
      },
      link: [canonicalTag(this.$route)],
    };
  },

  computed: {
    ...mapGetters(['surveyById']),
    ...mapGetters(['user']),

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

    survey() {
      if (this.$route.params.id) {
        return this.surveyById(this.$route.params.id);
      }
      return null;
    },

    surveysTitleText() {
      return this.$t('surveys.available_title');
    },
  },

  watch: {
    $route: {
      immediate: true,
      handler(route) {
        if (route.params.id) {
          this.isOverview = false;
        } else {
          this.isOverview = true;
        }
      },
    },
  },
  methods: {
    ...mapActions([SURVEYS_FETCH_ALL]),
  },
  created() {
    if (this.$route.params.id) {
      this[SURVEYS_FETCH_ALL]().catch(error => {
        console.log('error retrieving the surveys', error);
      });
    }
  },
};
</script>
<style>
</style>
