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
          <!-- <apo-training-overview /> -->
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
        <h2 class="mx-auto mt-10 text-center">Your Available Content</h2>

        <div class="py-2 mx-auto mt-10" style="max-width: 64rem">
          <div
            class="flex flex-row justify-center w-full p-2 px-5 rounded-lg cursor-pointer"
            style="
              background: linear-gradient(to right,#069BFF,#069BFF,#069BFF, #ABDDEF, #ABDDEF);"
            @click="showSeries = !showSeries"
          >
            <span class="ml-auto text-white">P&G Products</span>
            <img
              src="/assets/img/triangle.png" 
              class="w-5 ml-auto transform"
              style="filter: invert(1);" 
              :class="showSeries ? 'rotate-180' : 'rotate-90'"></img>
          </div>
          <div v-if="showSeries" class="w-full py-10" >
            <p class="w-3/4 mx-auto text-center">labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren.</p>
            <h2 class="mx-auto mt-10 text-center">Your Unlocked Content</h2>
            <div
              v-for="(training, index) in trainingSeries"
              :key="index"
              class="flex flex-row w-full mb-5"
            >
              <div class="flex flex-col w-1/4 px-2 py-3">
                <img
                  class="w-3/4 h-24 ml-auto rounded-lg"
                  style="box-shadow: 0px 0px 10px  rgba(0, 0, 0, 0.2);"
                  :src="training.informations.image.url"
                ></img>
                <button class="w-3/4 py-2 mt-5 ml-auto text-white rounded-full" style="background-color: #069BFF">Download certificate</button>
              </div>
              <div class="w-2/4 px-1 py-3 pl-3">
                <p class="mt-2">{{ training.title }}</p>
                <p class="text-sm">
                  {{ training.informations.description }}
                </p>
              </div>
              <div class="w-32 py-3 pl-5">
                <p class="text-sm text-right text-gray-700" >
                  {{ categoriesNames(training.categories) }}
                </p>
                <img src="/assets/img/days_icon.png" class="mt-2 ml-auto" alt="">
              </div>
            </div>
          </div>
        </div>
        
        <div class="py-2 mx-auto mb-10 " style="max-width: 64rem">
          <div
            class="flex flex-row justify-center w-full p-2 px-5 rounded-lg cursor-pointer"
            style="
              background: linear-gradient(to right, #d5b03a, #d5b03a, #d5b03a, #f4e2ab, #f4e2ab);"
            @click="showPremium = !showPremium"
          >
            <span class="ml-auto text-white">Premium Content</span>
            <img
              src="/assets/img/triangle.png" 
              class="w-5 ml-auto transform"
              style="filter: invert(1);" 
              :class="showPremium ? 'rotate-180' : 'rotate-90'"></img>
          </div>
          <div v-if="showPremium" class="w-full py-10" >
            <p class="w-3/4 mx-auto text-center">labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren.</p>
            <h2 class="mx-auto mt-10 text-center">Your Unlocked Content</h2>
            <div
              v-for="(premium, index) in premiumSeries"
              :key="index"
              class="flex flex-row w-full mb-5"
            >
              <div class="flex flex-col w-1/4 px-2 py-3">
                <img
                  class="w-3/4 h-24 ml-auto rounded-lg"
                  style="box-shadow: 0px 0px 10px  rgba(0, 0, 0, 0.2);"
                  :src="premium.thumbnail"
                ></img>
                <button class="w-3/4 py-2 mt-5 ml-auto text-white rounded-full" style="background-color: #d5b03a">Download</button>
              </div>
              <div class="w-2/4 px-1 py-3 pl-3">
                <p class="mt-2">{{ premium.title }}</p>
                <p class="text-sm">
                  {{ premium.description }}
                </p>
              </div>
              <div class="w-32 py-3 pl-5">
                <p class="text-sm text-right text-gray-700">{{ premium.category[0] }}</p>
                <img src="/assets/img/lock_icon.png" class="mt-2 ml-auto" alt="">
              </div>
            </div>
          </div>
        </div>
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
      showPremium: true,
      showSeries: false,
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
    ...mapGetters(["trainingCategory", "user"]),
    premiumSeries() {
      console.log("state", this.$store.state);
      return this.$store.state.trainings.premiumTrainingSeries;
    },
    trainingSeries() {
      return this.$store.state.trainings.trainingSeries;
    },
  },

  methods: {
    ...mapActions([
      TRAININGS_FETCH_ALL_SERIES,
      "fetchPremiumTrainingSeries",
      TRAININGS_UPDATE_CURRENT_TRAINING,
      TAXONOMIES_FETCH_TRAINING_CATEGORIES,
    ]),

    categoriesNames(categories) {
      if (categories.length > 0) {
        return categories
          .map((id) => this.trainingCategory(id))
          .map((category) => category.name)
          .join(", ");
      }
      return null;
    },
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
