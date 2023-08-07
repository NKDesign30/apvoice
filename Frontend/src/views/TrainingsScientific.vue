<template>
  <apo-restrict-content-wrapper>
    <apo-wait for="trainings.series">
      <template #waiting>
        <apo-loading-overlay
          class="my-15"
          :message="$t('loaders.trainingSeries')"
        />
      </template>
      <div class="welcome-section">
        <div
          class="relative flex flex-wrap justify-center w-full pt-5 pb-10 pl-4 pr-4 tablet:pl-10 mx-auto space-x-12 text-white desktop:py-20 tablet:overflow-hidden max-w-7xl"
        >
          <div class="flex flex-col w-full tablet:w-1/2">
            <div class="pr-8 text-3xl tablet:text-4xl desktop:text-5xl leading-3">
              {{ $t("trainings.welcome") }} {{ user.firstName }}!
              <br>
              <span class="w-full">
                {{ $t("trainings.scientific.welcome_to_sci") }}
                {{ $t("trainings.scientific.category") }}
              </span>
            </div>

            <div class="flex flex-col w-full mt-5 tablet:mt-0">
              <p class="mt-5 mb-3 text-xl">
                {{ $t("trainings.overview_text_sci") }}:
              </p>
              <div class="flex flex-row tablet:flex-col desktop:flex-row">
                <div
                  class="w-1/2 pr-2 tablet:w-full desktop:w-1/2 tablet:pr-0 desktop:pr-2"
                >
                  <div
                    class="relative w-full h-full px-2 py-1 rounded-lg done-or-available-box"
                  >
                    <h4
                      class="py-6 text-6xl text-center text-black tablet:text-6xl"
                    >
                      {{
                        (scientificCategoryTrainingSeries.length - countDoneScientificTrainings)
                      }}
                    </h4>
                    <div
                      class="flex flex-row justify-between text-xs tablet:text-base"
                    >
                      <p class="mr-2 text-black">
                        {{ $t("trainings.available") }}
                      </p>
                    </div>
                  </div>
                </div>
                <div
                  class="w-1/2 px-2 py-1 rounded-lg tablet:mt-4 desktop:mt-0 tablet:w-full desktop:w-1/2 done-or-available-box"
                >
                  <h4
                    class="py-6 text-6xl text-center text-black tablet:text-6xl"
                  >
                    {{ countDoneScientificTrainings }}
                  </h4>
                  <div
                    class="flex flex-row justify-between text-xs tablet:text-base"
                  >
                    <p class="mr-2 text-black">
                      {{ $t("trainings.completed") }}
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="flex flex-col w-full tablet:w-1/2 relative">
            <img
              src="/assets/img/Training.svg"
              class="absolute hidden tablet:block"
              style="bottom: -95px;width: 536px;; height: 365px;right: 0px;"
            >
          </div>
        </div>
      </div>

      <div
        v-if="isOverview"
        class="px-5 pb-10 trainings desktop:px-0"
      >
        <h2 class="mx-auto mt-10 text-center">
          {{ $t("trainings.available_content") }}
        </h2>

        <div
          v-if="scientificCategoryTrainingSeries.length > 0"
          id="category"
          class="max-w-6xl py-2 mx-auto mt-10"
        >
          <div v-if="scientificCategory !== null">
            <div class="w-full pb-10">
              <p class="w-full px-2 mx-auto mb-8 text-center tablet:w-1/2 tablet:px-0">
                {{ $t('trainings.scientificTrainings.teaser') }}
              </p>

              <div
                v-if="content && contentPosition === 'before'"
                class="video-sci"
              >
                <component
                  :is="`apo-cms-${renderer}-renderer`"
                  v-for="(components, renderer) in content"
                  :key="`${renderer}-renderer`"
                  :components="components || []"
                />
              </div>
              <!-- desktop -->
              <div class="flex-wrap hidden w-full mx-auto mt-3 mb-8 desktop:flex desktop:flex-row">
                <div
                  v-for="category in trainingCategoriesForFilter"
                  :key="category.id"
                  class="items-center mr-3 cursor-pointer"
                  @click="filterTrainings(category.id)"
                >
                  <div>
                    <apo-icon
                      v-if="categoriesIds.indexOf(category.id) >= 0"
                      src="radio_checked"
                      class="w-4 h-4 training-lesson__icon--unchecked text-green-400"
                    />
                    <apo-icon
                      v-else
                      src="radio"
                      class="w-4 h-4 training-lesson__icon--checked text-green-400"
                    />
                    {{ category.name }}
                  </div>
                </div>
              </div>
            </div>
            <!-- mobile -->
            <div
              class="w-full p-5 mx-auto mb-8 rounded-lg tablet:w-1/2 desktop:hidden"
              style="box-shadow: 0px 0px 10px #00000029;"
            >
              <div
                class="flex flex-row items-center justify-between"
                @click="showFiltersMobile = !showFiltersMobile"
              >
                <span class="flex-grow flex-shrink text-center ">{{
                  $t('trainings.filter')
                }}</span>
                <img
                  src="/assets/img/triangle.png"
                  class="w-5 transform"
                  :class="showFiltersMobile ? 'rotate-180' : 'rotate-90'"
                >
              </div>
              <!-- category filter -->
              <div
                v-if="showFiltersMobile"
                class="flex flex-wrap w-full mx-auto mt-3 desktop:hidden"
              >
                <div
                  v-for="category in trainingCategoriesForFilter"
                  :key="category.id"
                  class="items-center w-1/2 cursor-pointer"
                  @click="filterTrainings(category.id)"
                >
                  <div>
                    <apo-icon
                      v-if="categoriesIds.indexOf(category.id) >= 0"
                      src="radio_checked"
                      class="w-4 h-4 training-lesson__icon--unchecked text-green-400"
                    />
                    <apo-icon
                      v-else
                      src="radio"
                      class="w-4 h-4 training-lesson__icon--checked text-green-400"
                    />
                    {{ category.name }}
                  </div>
                </div>
              </div>
            </div>
            <!-- trainings -->
            <div
              v-for="(training, index) in scientificCategoryTrainingSeries"
              :key="index"
            >
              <div
                class="flex flex-col w-full pb-5 mb-5 border-b-2"
              >
                <single-training
                  :training="training"
                  :theme="theme"
                />
              </div>
            </div>
          </div>
        </div>
        <enter-confirmation v-if="isOverview" />
        <leave-confirmation v-if="isOverview" />
      </div>
      <div v-if="!isOverview">
        <apo-training />
        <enter-confirmation />
        <leave-confirmation />
      </div>
    </apo-wait>
  </apo-restrict-content-wrapper>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import Training from '@/components/training/Training.vue';
import LoadingOverlay from '@/components/ui/LoadingOverlay.vue';
import themeSettings from '@/mixins/theme-settings';
import training from '@/components/V2/training/trainingSci.vue';
import CmsContentRenderer from '@/components/cms/CmsContentRenderer.vue';

import LeaveConfirmation from '@/components/training/LeaveScientificConfirmation.vue';
import EnterConfirmation from '@/components/training/EnterScientificConfirmation.vue';

import {
  TRAININGS_FETCH_ALL_SERIES,
  TRAININGS_UPDATE_CURRENT_TRAINING,
  TAXONOMIES_FETCH_TRAINING_CATEGORIES,
} from '@/store/types/action-types';
import { canonicalTag } from '@/services/utils';

export default {
  components: {
    'apo-loading-overlay': LoadingOverlay,
    'apo-training': Training,
    'single-training': training,
    'leave-confirmation': LeaveConfirmation,
    'apo-cms-content-renderer': CmsContentRenderer,
    'enter-confirmation': EnterConfirmation,
  },

  mixins: [themeSettings('scientific')],

  data() {
    return {
      isOverview: true,
      showFiltersMobile: false,
      training: null,
      trainings: [],
      categoriesIds: [],
      productCategory: null,
      categoryCategory: null,
      scientificCategory: null,
      showApopTooltip: false,
      showAchTooltip: false,
    };
  },

  head() {
    return {
      title: {
        inner: this.$t('pages.trainings.main.meta.title'),
      },
      link: [canonicalTag(this.$route)],
    };
  },

  computed: {
    ...mapGetters([
      'trainingSeries',
      'trainingCategories',
      'availableTrainingSeries',
    ]),
    ...mapGetters(['language']),
    ...mapGetters(['trainingCategory', 'user', 'theme']),
    trainingCategoriesForFilter() {
      // there must be trainings of this category available
      const availableCategoryIds = this.allScientificCategoryTrainingSeries.reduce((availableCategories, series) => [...availableCategories, ...series.categories], [])
        .filter(id => id !== this.scientificCategory.id && id !== this.categoryCategory.id && id !== this.productCategory);
      return this.trainingCategories.filter(category => availableCategoryIds.includes(category.id));
    },

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
    scientificCategoryTrainingSeries() {
      return this.trainingSeries.filter(item => {
        let unfiltered = true;
        if (this.categoriesIds.length > 0) {
          unfiltered = item.categories.reduce((prev, catId) => prev || this.categoriesIds.includes(catId), false);
        }
        return item.trainings.length > 0 && this.isScientificCategoryTraining(item) && parseInt(item.trainings[0].isPremium) === 0 && unfiltered;
      }).sort((a, b) => this.sortTrainings(a, b));
    },
    allScientificCategoryTrainingSeries() {
      return this.trainingSeries.filter(item => item.trainings.length > 0 && this.isScientificCategoryTraining(item) && parseInt(item.trainings[0].isPremium) === 0);
    },
    trainingSeries() {
      return this.$store.state.trainings.trainingSeries;
    },
    availableTrainingSeries() {
      return this.$store.state.trainings.availableTrainingSeries;
    },
    countDoneScientificTrainings() {
      return [...this.scientificCategoryTrainingSeries].reduce((prev, item) => {
        if (item.trainings.length > 0 && this.user.trainingResults[item.trainings[0].id] && !!parseInt(this.user.trainingResults[item.trainings[0].id].is_complete)) {
          return prev + 1;
        }
        return prev;
      }, 0);
    },
  },

  watch: {
    $route: {
      immediate: true,
      handler(route) {
        this.$nextTick(() => {
          if (this.$wait.is('trainings.series')) {
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

  methods: {
    ...mapActions([
      TRAININGS_FETCH_ALL_SERIES,
      'fetchAvailableAndCompletedSeries',
      TRAININGS_UPDATE_CURRENT_TRAINING,
      TAXONOMIES_FETCH_TRAINING_CATEGORIES,
    ]),

    showTooltipApopoints() {
      this.showApopTooltip = !this.showApopTooltip;
    },
    isScientificCategoryTraining(trainingItem) {
      if (this.scientificCategory === null) {
        return false;
      }
      if (typeof this.scientificCategory === 'object') {
        return trainingItem.categories.includes(this.scientificCategory.id);
      }
      return false;
    },
    showTraining() {
      this.isOverview = false;
      this[TRAININGS_UPDATE_CURRENT_TRAINING](this.$route.params);
    },
    showOverview() {
      this.isOverview = true;
    },
    filterTrainings(categoryId) {
      if (this.categoriesIds.includes(categoryId)) {
        const index = this.categoriesIds.indexOf(categoryId);
        this.categoriesIds.splice(index, 1);
      } else {
        this.categoriesIds.push(categoryId);
      }
    },
    sortTrainings(a, b) {
      const trainingResultA = this.user.trainingResults[a.trainings[0].id];
      const trainingResultB = this.user.trainingResults[b.trainings[0].id];

      if (trainingResultA !== undefined && trainingResultA.is_complete === '1') {
        if (trainingResultB !== undefined && trainingResultB.is_complete === '1') {
          if (parseInt(a.informations.boost) > parseInt(b.informations.boost)) {
            return -1; // Beide Trainings sind abgeschlossen und haben einen Boost-Wert, Training A hat einen höheren Boost-Wert und kommt nach oben.
          } if (parseInt(a.informations.boost) < parseInt(b.informations.boost)) {
            return 1; // Beide Trainings sind abgeschlossen und haben einen Boost-Wert, Training B hat einen höheren Boost-Wert und kommt nach oben.
          }
          if (a.created_at < b.created_at) {
            return 1; // Beide Trainings sind abgeschlossen und haben den gleichen Boost-Wert, Training A wurde früher erstellt und kommt nach unten.
          } if (a.created_at > b.created_at) {
            return -1; // Beide Trainings sind abgeschlossen und haben den gleichen Boost-Wert, Training B wurde früher erstellt und kommt nach unten.
          }
          return 0; // Beide Trainings sind abgeschlossen, haben den gleichen Boost-Wert und wurden zum gleichen Zeitpunkt erstellt.
        }
        return 1; // Nur Training A ist abgeschlossen, daher kommt es nach unten.
      }

      if (trainingResultB !== undefined && trainingResultB.is_complete === '1') {
        return -1; // Nur Training B ist abgeschlossen, daher kommt es nach unten.
      }

      if (parseInt(a.informations.boost) > parseInt(b.informations.boost)) {
        return -1; // Training A hat einen höheren Boost-Wert, daher kommt es nach oben.
      }

      if (parseInt(a.informations.boost) < parseInt(b.informations.boost)) {
        return 1; // Training B hat einen höheren Boost-Wert, daher kommt es nach oben.
      }

      if (a.created_at < b.created_at) {
        return 1; // Training A wurde früher erstellt, daher kommt es nach unten.
      }

      if (a.created_at > b.created_at) {
        return -1; // Training B wurde früher erstellt, daher kommt es nach unten.
      }

      return 0; // Beide Trainings haben den gleichen Boost-Wert und wurden zum gleichen Zeitpunkt erstellt.
    },
  },

  created() {
    this[TRAININGS_FETCH_ALL_SERIES]();
    this[TAXONOMIES_FETCH_TRAINING_CATEGORIES]().then(data => {
      this.scientificCategory = data.find(item => item.slug === 'scientific');
      this.productCategory = data.find(item => item.slug === 'products');
      this.categoryCategory = data.find(item => item.slug === 'category');
    });
    this.fetchAvailableAndCompletedSeries();
    const unwatch = this.$watch(
      'trainingSeries',
      trainingSeries => {
        if (trainingSeries.length > 0 && this.$route.params.training_slug) {
          this.$nextTick(() => {
            this.showTraining(this.$route.params);
            unwatch();
          });
        }
      },
      { immediate: true },
    );
  },
};
</script>

<style scoped>
.welcome-section {
  /* the spec for dt */
  /*background: transparent linear-gradient(249deg, #9BD442 0%, #00B041 100%) 0% 0% no-repeat padding-box !important;*/
  /* the spec for mobile - slightly different */
  /* background: transparent linear-gradient(217deg, #9BD442 0%, #00B041 100%) 0% 0% no-repeat padding-box; */
  /* av between two */
  background: transparent linear-gradient(233deg, #9BD442 0%, #00B041 100%) 0% 0% no-repeat padding-box !important;
  column-gap: 150px;
}

.done-or-available-box {
  background: transparent linear-gradient(244deg, #FFFFFF 0%, #DBF0AD 100%) 0% 0% no-repeat padding-box;
  box-shadow: 0px 0px 10px #00000029;
  color: #3c3c3b;
  max-width: 295px;
}
.max-w-6xl {
    max-width: 85rem;
}
.show-enter-active {
  animation: height 0.5s;
}

.show-leave-active {
  animation: height 0.5s reverse;
}

@keyframes show-in {
  0% {
    transform: height(0);
  }
  50% {
    transform: height(50%);
  }
  100% {
    transform: height(100%);
  }
}

@media (min-width: 767px) and (max-width: 1024px) {
  .custom-gap {
    column-gap: 0px !important;
  }
}
.custom-gap {
  column-gap: 150px;
}
.container {
    max-width: 45rem!important;
    padding-left: 0;
    padding-right: 0;
}
</style>
