<template>
  <apo-restrict-content-wrapper>
    <apo-wait for="trainings.series">
      <template #waiting>
        <apo-loading-overlay
          class="my-15"
          :message="$t('loaders.trainingSeries')"
        />
      </template>

      <div class="trainings">
        <div v-if="isOverview">
          <apo-training-overview-user-dashboard />
          <div v-if="content && contentPosition === 'before'">
            <component
              :is="`apo-cms-${renderer}-renderer`"
              v-for="(components, renderer) in content"
              :key="`${renderer}-renderer`"
              :components="components || []"
            />
          </div>
          <apo-training-overview />
          <div v-if="content && contentPosition === 'after'">
            <component
              :is="`apo-cms-${renderer}-renderer`"
              v-for="(components, renderer) in content"
              :key="`${renderer}-renderer`"
              :components="components || []"
            />
          </div>
        </div>
        <apo-training v-else />
        <h1>{{premiumSeries}}</h1>
      </div>
    </apo-wait>
  </apo-restrict-content-wrapper>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import CmsContentRenderer from "@/components/cms/CmsContentRenderer.vue";
import TrainingOverview from "@/components/training/TrainingOverview.vue";
import Training from "@/components/training/Training.vue";
import TrainingOverviewUserDashboard from "@/components/training/overview/TrainingOverviewUserDashboard.vue";
import LoadingOverlay from "@/components/ui/LoadingOverlay.vue";
import themeSettings from "@/mixins/theme-settings";
import {
  TRAININGS_FETCH_ALL_SERIES,
  TRAININGS_UPDATE_CURRENT_TRAINING,
  TAXONOMIES_FETCH_TRAINING_CATEGORIES,
} from "@/store/types/action-types";
import { canonicalTag } from "@/services/utils";

export default {
  components: {
    "apo-loading-overlay": LoadingOverlay,
    "apo-cms-content-renderer": CmsContentRenderer,
    "apo-training-overview": TrainingOverview,
    "apo-training": Training,
    "apo-training-overview-user-dashboard": TrainingOverviewUserDashboard,
  },

  mixins: [themeSettings("training")],

  data() {
    return {
      isOverview: true,
      training: null,
      trainings: [],
    };
  },

  head() {
    return {
      title: {
        inner: this.$t("pages.trainings.main.meta.title"),
      },
      link: [canonicalTag(this.$route)],
    };
  },

  computed: {
    ...mapGetters(["trainingSeries", "premiumTrainingSeries"]),

    pageData() {
      return this.$store.state.pages.pageContent.filter(
        (page) => page.slug === this.$route.path.replace(/^\/|\/$/g, "")
      ).length > 0
        ? this.$store.state.pages.pageContent.filter(
            (page) => page.slug === this.$route.path.replace(/^\/|\/$/g, "")
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
  },

  watch: {
    $route: {
      immediate: true,
      handler(route) {
        this.$nextTick(() => {
          if (this.$wait.is("trainings.series")) {
            return;
          }

          if (route.params.training_slug) {
            this.showTraining();
          } else {
            this.showOverview();
          }
        });
      },
    },
  },
  computed: {
    premiumSeries() {
      console.log('state', this.$store.state)
      return this.$store.state.trainings.premiumTrainingSeries;
    },
  },

  methods: {
    ...mapActions([
      TRAININGS_FETCH_ALL_SERIES,
      "fetchPremiumTrainingSeries",
      TRAININGS_UPDATE_CURRENT_TRAINING,
      TAXONOMIES_FETCH_TRAINING_CATEGORIES,
    ]),

    showTraining() {
      this.isOverview = false;
      this[TRAININGS_UPDATE_CURRENT_TRAINING](this.$route.params);
    },

    showOverview() {
      this.isOverview = true;
    },
  },

  created() {
    this[TRAININGS_FETCH_ALL_SERIES]();
    this[TAXONOMIES_FETCH_TRAINING_CATEGORIES]();
    this.fetchPremiumTrainingSeries();
    const unwatch = this.$watch(
      "trainingSeries",
      (trainingSeries) => {
        if (trainingSeries.length > 0 && this.$route.params.training_slug) {
          this.$nextTick(() => {
            this.showTraining(this.$route.params);
            unwatch();
          });
        }
      },
      { immediate: true }
    );
  },
};
</script>
