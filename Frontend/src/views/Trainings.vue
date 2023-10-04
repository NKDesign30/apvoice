<template>
  <apo-restrict-content-wrapper>
    <apo-wait for="trainings.series">
      <template #waiting>
        <apo-loading-overlay
          class="my-15"
          :message="$t('loaders.trainingSeries')"
        />
      </template>
      <div id="welcome-section-3">
        <div
          class="flex flex-wrap max-w-7xl mx-auto justify-center pt-5 pb-10 desktop:pl-20 pl-4 pr-4"
        >
          <div
            class="relative flex flex-col w-full tablet:w-1/2 mx-auto desktop:pt-12 tablet:pr-0 text-white tablet:overflow-hidden  p-0 flex-1"
          >
            <div class="flex w-full">
              <div
                class="pr-8 text-xs"
                style="line-height: 3.675rem !important;"
              >
                <h1>
                  {{ $t("trainings.welcome") }} {{ user.firstName }}!
                  <br>
                  <span class="w-full">
                    {{ $t("trainings.welcome_to") }}<br>
                    {{ $t("trainings.knowledge") }}.
                  </span>
                </h1>
              </div>
            </div>
            <div class="flex flex-col w-full mt-auto">
              <p class="mt-5 mb-3 text-2xl">
                {{ $t("trainings.overview_text") }}:
              </p>
              <div class="flex flex-row tablet:flex-col desktop:flex-row">
                <div class="w-1/2 mr-5 tablet:w-full desktop:w-1/2 tablet:pr-0 desktop:pr-2">
                  <div
                    class="relative w-full h-full px-2  pb-0 pt-4 rounded-lg"
                    style="
                    background: transparent linear-gradient(244deg, #ffffff 0%, #adddef 100%) 0% 0% no-repeat padding-box;
                    color: #3c3c3b;
                    box-shadow: 0px 0px 10px #00000029;
                    height: 140px !important;
                  "
                  >
                    <h4
                      class="desktop:py-10 py-7 text-center text-black tablet:text-6xl"
                      style="font-size: 5rem;"
                    >
                      {{
                        productTrainingSeries.length +
                          categoryTrainingSeries.length +
                          unlockedPremiumTrainings.length -
                          countDoneTrainings
                      }}
                    </h4>
                    <div class="flex flex-row justify-between text-xs tablet:text-base">
                      <p class="mr-2 text-black">
                        {{ $t("trainings.available") }}
                      </p>
                    </div>
                  </div>
                </div>
                <div
                  class="w-1/2 px-2 pb-0 pt-4 rounded-lg tablet:mt-4 desktop:mt-0 tablet:w-full desktop:w-1/2"
                  style="
                  background: transparent linear-gradient(244deg, #ffffff 0%, #adddef 100%) 0% 0% no-repeat padding-box;
                  color: #3c3c3b;
                  box-shadow: 0px 0px 10px #00000029;
                  height: 140px !important;
                "
                >
                  <h4
                    class="desktop:py-10 py-7 text-center text-black tablet:text-6xl"
                    style="font-size: 5rem;"
                  >
                    {{ countDoneTrainings }}
                  </h4>
                  <div class="flex flex-row justify-between text-xs tablet:text-base">
                    <p class="mr-2 text-black">
                      {{ $t("trainings.completed") }}
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div
            class="relative mt-3 flex flex-col w-full tablet:w-1/2 mx-auto  desktop:pt-8 desktop:overflow-visible	 desktop:pl-5 px-4 tablet:px-10  text-white tablet:overflow-hidden p:0 flex-1"
          >
            <img
              src="/assets/img/Training.svg"
              class="responsive-image absolute hidden tablet:block"
            >

            <level
              v-if="language != 'de' && language != 'at'"
              :show-profile-items="false"
              :user="user"
              :profile-picture="profilePicture"
              :show-edit-icon="true"
            />

            <achievements class="tablet:hidden mt-6" />
            <achievements class="hidden tablet:block" />

            <div class="flex mt-auto">
              <div
                v-if="language != 'de' && language != 'at'"
                class="desktop:w-1/2 w-full pr-2 tablet:pr-0 desktop:pr-2 mt-2"
              >
                <div class="flex flex-row">
                  <div
                    class="relative w-full px-1 py-2  rounded-lg"
                    style="
                  background: transparent linear-gradient(244deg, #adddef 0%, #0099ff 100%) 0% 0% no-repeat padding-box;
                  box-shadow: 0px 0px 10px #00000029;
                  height: 140px !important;
                "
                  >
                    <div class="relative">
                      <img
                        src="/assets/img/Apo-Info.svg"
                        class="z-50 ml-auto cursor-pointer"
                        alt=""
                        @click="showTooltipApopoints"
                      >

                      <div
                        id="apo-tooltip"
                        role="tooltip"
                        class="absolute inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm top-10 tooltip dark:bg-gray-700"
                        :class="showApopTooltip ? 'opacity-1' : 'opacity-0'"
                        :style="showApopTooltip ? 'z-index: 999' : 'z-index: -1'"
                      >
                        {{ $t("general.apoPointsTooltip") }}
                        <div
                          class="tooltip-arrow"
                          data-popper-arrow
                        />
                      </div>
                    </div>

                    <img
                      class="absolute left-5"
                      src="/assets/img/star.svg"
                    >
                    <h3
                      class="py-4 pb-8 text-center"
                      style="font-size:5rem"
                    >
                      {{ user.apoPoints }}
                    </h3>
                    <div class="flex flex-row justify-between text-xs tablet:text-base">
                      <p class="mr-2">
                        {{ $t("general.apoPoints") }}
                      </p>
                      <a
                        class="underline"
                        href="/trainings/"
                      >
                        {{ $t("trainings.buttons.redeem") }}
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
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
          v-if="categoryTrainingSeries.length > 0"
          id="category"
          class="max-w-6xl py-2 mx-auto mt-10"
        >
          <div
            class="flex flex-row items-center justify-between w-full p-2 px-5 rounded-lg cursor-pointer "
            style="
              background: linear-gradient(to right,#069BFF,#069BFF,#069BFF, #ABDDEF, #ABDDEF);"
            @click="handleCategoryClick"
          >
            <span class="flex-grow flex-shrink text-center text-white">{{
              $t("trainings.categoryTrainings.headline")
            }}</span>
            <img
              src="/assets/img/triangle.png"
              class="w-5 h-5 transform"
              style="filter: invert(1);"
              :class="showCategorySeries ? 'rotate-180' : 'rotate-90'"
            >
          </div>
          <transition
            name="show"
            mode="in-out"
          >
            <div
              v-if="showCategorySeries"
              class="w-full py-10"
            >
              <p class="w-full px-2 mx-auto mb-8 text-center tablet:w-1/2 tablet:px-0">
                {{ $t("trainings.categoryTrainings.teaser") }}
              </p>
              <div
                v-if="categoryCategory !== null && categoryCategory !== undefined"
                class="flex-wrap hidden w-full mx-auto mt-3 mb-8 desktop:flex desktop:flex-row"
              >
                <div
                  v-for="category in trainingCategoriesForFilter"
                  :id="category.id"
                  :key="category.id"
                  class="items-center mr-3 cursor-pointer filterPro"
                  @click="setFilterCategory(category.id)"
                >
                  <div
                    v-if="category.id !== productCategory.id && category.id !== categoryCategory.id"
                  >
                    <apo-icon
                      v-if="categoriesIds.indexOf(category.id) >= 0"
                      src="radio_checked"
                      class="w-4 h-4 training-lesson__icon--unchecked text-training-500"
                    />
                    <apo-icon
                      v-else
                      src="radio"
                      class="w-4 h-4 training-lesson__icon--checked text-training-500"
                    />
                    {{ category.name }}
                  </div>
                </div>
              </div>
              <div
                v-if="
                  productCategory !== null &&
                    categoryCategory !== null &&
                    productCategory !== undefined &&
                    categoryCategory !== undefined"
              >
                <div
                  v-for="(training, index) in categoryTrainingSeries"
                  :id="index"
                  :key="index"
                >
                  <div
                    v-if="checkexpiration(training.informations.expires_at)"
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
          </transition>
        </div>

        <div
          v-if="productTrainingSeries.length > 0"
          id="products"
          class="max-w-6xl py-2 mx-auto"
        >
          <div
            class="flex flex-row items-center justify-between w-full p-2 px-5 rounded-lg cursor-pointer "
            style="
              background: linear-gradient(to right, #069bff, #069bff, #069bff, #abddef, #abddef);
            "
            @click="handleClick"
          >
            <span class="flex-grow flex-shrink text-center text-white">{{
              $t("trainings.productTrainings.headline")
            }}</span>
            <img
              src="/assets/img/triangle.png"
              class="w-5 h-5 transform"
              style="filter: invert(1)"
              :class="this.showProductSeries ? 'rotate-180' : 'rotate-90'"
            >
          </div>
          <transition
            name="show"
            mode="in-out"
          >
            <div
              v-if="showProductSeries"
              class="w-full py-10"
            >
              <p class="w-full px-2 mx-auto mb-5 mb-8 text-center tablet:w-1/2 tablet:px-0">
                {{ $t("trainings.productTrainings.teaser") }}
              </p>
              <div
                v-if="
                  productCategory !== null &&
                    categoryCategory !== null &&
                    productCategory !== undefined &&
                    categoryCategory !== undefined
                "
                class="flex-wrap hidden w-full mx-auto mt-3 mb-8 desktop:flex desktop:flex-row"
              >
                <div
                  v-for="category in trainingCategoriesForFilter"
                  :id="category.id"
                  :key="category.id"
                  class="items-center mr-3 cursor-pointer filterPro"
                  @click="setFilterProduct(category.id)"
                >
                  <div
                    v-if="category.id !== productCategory.id && category.id !== categoryCategory.id"
                  >
                    <apo-icon
                      v-if="categoriesIds.indexOf(category.id) >= 0"
                      src="radio_checked"
                      class="w-4 h-4 training-lesson__icon--unchecked text-training-500"
                    />
                    <apo-icon
                      v-else
                      src="radio"
                      class="w-4 h-4 training-lesson__icon--checked text-training-500"
                    />
                    {{ category.name }}
                  </div>
                </div>
              </div>
              <div
                v-if="
                  productCategory !== null &&
                    categoryCategory !== null &&
                    productCategory !== undefined &&
                    categoryCategory !== undefined
                "
                class="w-full p-5 mx-auto mb-8 rounded-lg tablet:w-1/2 desktop:hidden"
                style="box-shadow: 0px 0px 10px #00000029;"
              >
                <div
                  class="flex flex-row items-center justify-between"
                  @click="showFiltersMobile = !showFiltersMobile"
                >
                  <span class="flex-grow flex-shrink text-center ">{{
                    $t("trainings.filter")
                  }}</span>
                  <img
                    src="/assets/img/triangle.png"
                    class="w-5 transform"
                    :class="showFiltersMobile ? 'rotate-180' : 'rotate-90'"
                  >
                </div>
                <div
                  v-if="showFiltersMobile"
                  class="flex flex-wrap w-full mx-auto mt-3 desktop:hidden"
                >
                  <div
                    v-for="category in trainingCategoriesForFilter"
                    :key="category.id"
                    class="items-center w-1/2 cursor-pointer"
                    @click="setFilterProduct(category.id)"
                  >
                    <div
                      v-if="
                        productCategory !== null &&
                          categoryCategory !== null &&
                          category.id !== productCategory.id &&
                          category.id !== categoryCategory.id
                      "
                    >
                      <apo-icon
                        v-if="categoriesIds.indexOf(category.id) >= 0"
                        src="radio_checked"
                        class="w-4 h-4 training-lesson__icon--unchecked text-training-500"
                      />
                      <apo-icon
                        v-else
                        src="radio"
                        class="w-4 h-4 training-lesson__icon--checked text-training-500"
                      />
                      {{ category.name }}
                    </div>
                  </div>
                </div>
              </div>
              <div v-if="productCategory !== null">
                <div
                  v-for="(training, index) in productTrainingSeries"
                  :key="index"
                >
                  <div class="flex flex-col w-full pb-5 mb-5 border-b-2">
                    <single-training
                      :training="training"
                      :theme="theme"
                    />
                  </div>
                </div>
              </div>
            </div>
          </transition>
        </div>

        <div
          v-if="
            unlockedPremiumTrainings.length > 0 ||
              lockedPremiumTrainings.length > 0 ||
              expensivePremiumTrainings.length > 0
          "
          id="premium"
          class="max-w-6xl py-2 mx-auto mb-10"
        >
          <div
            class="flex flex-row justify-between w-full p-2 px-5 rounded-lg cursor-pointer "
            style="
              background: linear-gradient(to right, #d5b03a, #d5b03a, #d5b03a, #f4e2ab, #f4e2ab);
            "
            @click="showPremium = !showPremium"
          >
            <span class="flex-grow flex-shrink text-center text-white">{{
              $t("trainings.premiumTrainings.headline")
            }}</span>
            <img
              src="/assets/img/triangle.png"
              class="w-5 transform"
              style="filter: invert(1)"
              :class="showPremium ? 'rotate-180' : 'rotate-90'"
            >
          </div>

          <div
            v-if="showPremium"
            class="w-full py-10"
          >
            <apo-wait for="premiumTraining.series">
              <template #waiting>
                <apo-loading-overlay class="my-15" />
              </template>
              <p class="w-1/2 mx-auto text-center">
                {{ $t("trainings.premiumTrainings.teaser") }}
              </p>
              <div v-if="unlockedPremiumTrainings.length > 0">
                <h2 class="mx-auto mt-10 mb-8 text-center">
                  {{ $t("trainings.unlocked") }}
                </h2>
                <div
                  v-for="premium in unlockedPremiumTrainings"
                  :key="premium.id"
                >
                  <div class="flex flex-col w-full mb-5 tablet:flex-row">
                    <single-premium :premium="premium" />
                  </div>
                </div>
              </div>
              <div v-if="lockedPremiumTrainings.length > 0">
                <h2 class="mx-auto mt-10 mb-8 text-center">
                  {{ $t("trainings.availablePremium") }}
                </h2>
                <div
                  v-for="(premium, index) in lockedPremiumTrainings"
                  :key="index"
                >
                  <div class="flex flex-col w-full mb-5 tablet:flex-row">
                    <single-premium :premium="premium" />
                  </div>
                </div>
              </div>
              <div v-if="expensivePremiumTrainings.length > 0">
                <h2 class="mx-auto mt-10 mb-8 text-center">
                  {{ $t("trainings.expensivePremium") }}
                </h2>
                <div
                  v-for="(premium, index) in expensivePremiumTrainings"
                  :key="index"
                >
                  <div class="flex flex-col w-full mb-5 tablet:flex-row">
                    <single-premium
                      disabled
                      :premium="premium"
                    />
                  </div>
                </div>
              </div>
            </apo-wait>
          </div>
        </div>
      </div>
      <apo-training v-else />
    </apo-wait>
  </apo-restrict-content-wrapper>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import Training from '@/components/training/Training.vue';
import LoadingOverlay from '@/components/ui/LoadingOverlay.vue';
import themeSettings from '@/mixins/theme-settings';
import training from '@/components/V2/training/training.vue';
import premiumTraining from '@/components/V2/training/premiumTraining.vue';

import {
  TRAININGS_FETCH_ALL_SERIES,
  TRAININGS_UPDATE_CURRENT_TRAINING,
  TAXONOMIES_FETCH_TRAINING_CATEGORIES,
  FILTER_TRAININGS,
  FILTER_CATEGORY,
  CLICK,
  CLICK_CATEGORY,
  SETCATEGORY,
} from '@/store/types/action-types';
import { canonicalTag } from '@/services/utils';
import Achievements from '@/components/user/performance/Achievements';
import Level from '@/components/user/performance/Level';

export default {
  components: {
    'apo-loading-overlay': LoadingOverlay,
    'apo-training': Training,
    'single-training': training,
    'single-premium': premiumTraining,
    achievements: Achievements,
    level: Level,
  },

  mixins: [themeSettings('training')],

  data() {
    return {
      showSeriesHealth: false,
      showPremium: !!(window.location.hash && window.location.hash === '#premium'),
      // showProductSeries: !!(window.location.hash && window.location.hash === '#products'),
      //  showCategorySeries: !!(window.location.hash && window.location.hash === '#category'),
      isOverview: true,
      showFiltersMobile: false,
      training: null,
      trainings: [],
      myscroll: this.$route.params.type,
      productCategory: null,
      categoryCategory: null,
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
      'premiumTrainingSeries',
      'availableTrainingSeries',
    ]),
    trainingCategoriesForFilter() {
      // there must be trainings of this category available
      const availableCategoryIds = this.allProductTrainingSeries
        .reduce((availableCategories, series) => [...availableCategories, ...series.categories], [])
        .filter(id => id !== this.categoryCategory.id && id !== this.productCategory);
      return this.trainingCategories.filter(category => availableCategoryIds.includes(category.id));
    },
    allProductTrainingSeries() {
      return this.trainingSeries.filter(
        item => item.trainings.length > 0
          && this.isProductTraining(item)
          && parseInt(item.trainings[0].isPremium) === 0,
      );
    },

    ...mapGetters(['language']),
    ...mapGetters(['trainingCategory', 'user', 'theme']),
    ...mapGetters(['user', 'profilePicture']),
    ...mapGetters(['filter', 'categoriesIds']),
    ...mapGetters(['filter', 'showProductSeries']),
    ...mapGetters(['filter', 'showCategorySeries']),
    ...mapGetters(['filter', 'getscroll']),
    ...mapGetters(['category', 'getid']),

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
    productTrainingSeries() {
      return this.trainingSeries
        .filter(item => {
          let unfiltered = true;
          console.log(this.categoriesIds);
          if (this.categoriesIds.length > 0) {
            unfiltered = item.categories.reduce(
              (prev, catId) => prev || this.categoriesIds.includes(catId),
              false,
            );
          }
          return (
            item.trainings.length > 0
            && this.isProductTraining(item)
            && parseInt(item.trainings[0].isPremium) === 0
            && unfiltered
          );
        })
        .sort((a, b) => this.sortTrainings(a, b));
    },
    categoryTrainingSeries() {
      const id = this.getid;
      if (id) {
        return this.trainingSeries
          .filter(
            item => item.categories.includes(id)
              && item.trainings.length > 0
              && this.isCategoryTraining(item)
              && parseInt(item.trainings[0].isPremium) === 0,
          )
          .sort((a, b) => this.sortTrainings(a, b));
      }
      return this.trainingSeries
        .filter(
          item => item.trainings.length > 0
            && this.isCategoryTraining(item)
            && parseInt(item.trainings[0].isPremium) === 0,
        )
        .sort((a, b) => this.sortTrainings(a, b));
    },
    trainingSeries() {
      return this.$store.state.trainings.trainingSeries;
    },
    availableTrainingSeries() {
      return this.$store.state.trainings.availableTrainingSeries;
    },

    unlockedPremiumTrainings() {
      return this.premiumTrainingSeries
        .filter(item => item.trainings.length > 0 && item.unlocked === 1)
        .sort((a, b) => this.sortTrainings(a, b));
    },

    lockedPremiumTrainings() {
      return this.premiumTrainingSeries.filter(
        item => item.trainings.length > 0 && item.unlocked !== 1,
      ); // && parseInt(item.apo_points) <= this.user.apoPoints
    },

    expensivePremiumTrainings() {
      return this.premiumTrainingSeries.filter(
        item => item.trainings.length > 0
          && item.unlocked !== 1
          && parseInt(item.apo_points) > this.user.apoPoints,
      );
    },
    countDoneTrainings() {
      return [
        ...this.unlockedPremiumTrainings,
        ...this.productTrainingSeries,
        ...this.categoryTrainingSeries,
      ].reduce((prev, item) => {
        if (
          item.trainings.length > 0
          && this.user.trainingResults[item.trainings[0].id]
          && !!parseInt(this.user.trainingResults[item.trainings[0].id].is_complete)
        ) {
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
      'fetchPremiumTrainingSeries',
      'fetchAvailableAndCompletedSeries',
      TRAININGS_UPDATE_CURRENT_TRAINING,
      TAXONOMIES_FETCH_TRAINING_CATEGORIES,
      FILTER_TRAININGS,
      FILTER_CATEGORY,
      CLICK,
      CLICK_CATEGORY,
      SETCATEGORY,
    ]),
    handleClick() {
      this[CLICK]();
    },
    checkexpiration(expires_at) {
      const today = new Date();
      const yyyy = today.getFullYear();
      let mm = today.getMonth() + 1; // Months start at 0!
      let dd = today.getDate();

      if (dd < 10) dd = `0${dd}`;
      if (mm < 10) mm = `0${mm}`;

      const formattedToday = `${yyyy}-${mm}-${dd}`;

      return expires_at >= formattedToday || expires_at == '';
    },
    handleCategoryClick() {
      this[CLICK_CATEGORY]();
    },
    setFilterProduct(categoriesId) {
      this[FILTER_TRAININGS](categoriesId);
    },
    setFilterCategory(categoryId) {
      this[FILTER_CATEGORY](categoryId);
    },

    showTooltipAchievements() {
      this.showAchTooltip = !this.showAchTooltip;
    },
    showTooltipApopoints() {
      this.showApopTooltip = !this.showApopTooltip;
    },

    isProductTraining(trainingItem) {
      if (this.productCategory === null) {
        return false;
      }
      if (typeof this.productCategory === 'object') {
        return trainingItem.categories.includes(this.productCategory.id);
      }
      return false;
    },

    isCategoryTraining(trainingItem) {
      if (this.categoryCategory === null) {
        return false;
      }
      if (typeof this.categoryCategory === 'object') {
        return trainingItem.categories.includes(this.categoryCategory.id);
      }
      return false;
    },

    filterTrainings(categoryId) {
      if (this.categoriesIds.includes(categoryId)) {
        const index = this.categoriesIds.indexOf(categoryId);
        this.categoriesIds.splice(index, 1);
      } else {
        this.categoriesIds.push(categoryId);
      }
    },
    categoriesNames(categories) {
      if (categories.length > 0) {
        return categories
          .map(id => this.trainingCategory(id))
          .map(category => category.name)
          .join(', ');
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
    sortTrainings(a, b) {
      const trainingResultA = this.user.trainingResults[a.trainings[0].id];
      const trainingResultB = this.user.trainingResults[b.trainings[0].id];

      if (trainingResultA !== undefined && trainingResultA.is_complete === '1') {
        if (trainingResultB !== undefined && trainingResultB.is_complete === '1') {
          if (parseInt(a.informations.boost) > parseInt(b.informations.boost)) {
            return -1; // Beide Trainings sind abgeschlossen und haben einen Boost-Wert, Training A hat einen höheren Boost-Wert und kommt nach oben.
          }
          if (parseInt(a.informations.boost) < parseInt(b.informations.boost)) {
            return 1; // Beide Trainings sind abgeschlossen und haben einen Boost-Wert, Training B hat einen höheren Boost-Wert und kommt nach oben.
          }
          if (a.created_at < b.created_at) {
            return 1; // Beide Trainings sind abgeschlossen und haben den gleichen Boost-Wert, Training A wurde früher erstellt und kommt nach unten.
          }
          if (a.created_at > b.created_at) {
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
    // this.$watch(this.getscroll, (getscroll) => {
    // console.log(getscroll);
    // });
    this[TRAININGS_FETCH_ALL_SERIES]();
    this[TAXONOMIES_FETCH_TRAINING_CATEGORIES]().then(data => {
      this.productCategory = data.find(item => item.slug === 'products');
      this.categoryCategory = data.find(item => item.slug === 'category');
    });
    this.fetchPremiumTrainingSeries();
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
.leading-3 {
  line-height: 3.675rem !important;
}

#welcome-section-3 {
  /* @rudston made the lighter blue darker than the spec otherwise there was too little contrast to display level and achievements */
  background-image: linear-gradient(to right, #2ca6f9, #4ab5f7, #69c2f4, #87cff2, #a6dbf0);
  column-gap: 150px;
}

.show-enter-active {
  animation: height 0.5s;
}

.max-w-6xl {
  max-width: 85rem !important;
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

* {
  box-sizing: content-box;
}

@media (max-width: 767px) {
  * {
    box-sizing: border-box;
  }
}

@media (min-width: 767px) and (max-width: 1024px) {
  .custom-gap {
    column-gap: 0px !important;
  }
}

@media (min-width: 767px) {
  .responsive-image {
    top: 8%;
    right: 0%;
    height: 100%;
    transform: scale(0.9);
  }
}

.custom-gap {
  column-gap: 150px;
}
</style>
