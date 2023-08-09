<template>
  <apo-wait for="surveys">
    <div v-if="showHeaderSection" id="welcome-section-2">
      <div
        class="relative flex flex-wrap justify-center pt-5 pb-10 pl-4 pr-4 mx-auto space-x-12 text-white tablet:py-20 tablet:flex-row max-w-7xl tablet:px-20"
      >
        <div class="flex flex-col w-full tablet:w-2/3 desktop:w-1/2">
          <h1 class="pr-8 text-5xl tablet:text-5xl">
            <span class="w-full font-bold leading-4">{{
                $t("surveys.salutation")
              }} {{ user.firstName }}!</span>
            <span class="w-full leading-4">
                  {{ $t("surveys.section") }}
                </span>
          </h1>
          <img
            src="/assets/img/Survey.svg"
            class="absolute bottom-0 hidden tablet:block"
            style="width: 383px; height: 324px"
          >
        </div>
        <div class="flex flex-col w-full mt-5 tablet:w-1/3 desktop:w-1/2 tablet:mt-0">
          <p class="mb-3 text-xl">
            {{ $t('redeem.your') }} {{ $t("surveys.PointsOverview") }}:
          </p>
          <div class="flex flex-wrap w-full">
            <div
              class="relative w-64 px-2 py-1 rounded-lg tablet:w-full desktop:w-64 max-w-100"
              style="
                  background: transparent linear-gradient(245deg, #ffb80f 0%, #ff7000 100%) 0% 0% no-repeat padding-box;
                  box-shadow: 0px 0px 10px #00000029;
                "
            >
              <div class="relative">
                <img
                  src="/assets/img/Apo-Info.svg"
                  class="ml-auto cursor-pointer"
                  alt="info"
                  @click="showTooltipAchievements"
                >
                <div
                  id="tooltip-default"
                  role="tooltip"
                  class="absolute right-0 z-10 inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm top-10 tooltip dark:bg-gray-700"
                  :class="showAchTooltip ? 'opacity-1' : 'opacity-0'"
                  :style="showAchTooltip ? 'z-index: 999' : 'z-index: -1'"
                >
                  {{ $t('general.apoCoinsTooltip') }}
                  <div
                    class="tooltip-arrow"
                    data-popper-arrow
                  />
                </div>
              </div>
              <img
                src="/assets/img/coins.svg"
                class="absolute left-5"
                alt=""
              >
              <h3
                class="py-8 text-5xl text-center tablet:text-6xl"
              >
                {{ user.expertPoints }}
              </h3>
              <div
                class="flex flex-row justify-between text-xs tablet:text-base"
              >
                <p class="mr-2">
                  {{ $t("general.apoCoins") }}
                </p>
                <router-link
                  class="underline"
                  to="/redeem"
                >
                  {{ $t("surveys.buttons.redeem") }}
                </router-link>
              </div>
            </div>
          </div>
          <p class="mt-5 mb-3 text-xl">
            {{ $t("surveys.overview_text") }}:
          </p>
          <div class="flex flex-wrap">
            <div
              class="w-1/2 pr-2 tablet:w-full desktop:w-1/2 tablet:pr-0 desktop:pr-2"
            >
              <div
                class="w-full px-2 py-1 rounded-lg "
                style="
                    background: transparent linear-gradient(244deg, #ffffff 0%, #f9f3d1 100%) 0% 0% no-repeat padding-box;
                    color: #3c3c3b;
                    box-shadow: 0px 0px 10px #00000029;
                  "
              >
                <h3
                  class="py-4 pt-6 text-5xl text-center text-black tablet:text-6xl"
                >
                  {{ surveys.length - completedSurveysCount }}
                </h3>
                <div
                  class="flex flex-row justify-between text-xs tablet:text-base"
                >
                  <p class="mr-2">
                    {{ $t("surveys.available2") }}
                  </p>
                </div>
              </div>
            </div>
            <div
              class="w-1/2 tablet:mt-4 desktop:mt-0 tablet:w-full desktop:w-1/2"
            >
              <div
                class="w-full px-2 py-1 rounded-lg"
                style="
                    background: transparent linear-gradient(244deg, #ffffff 0%, #f9f3d1 100%) 0% 0% no-repeat padding-box;
                    color: #3c3c3b;
                    box-shadow: 0px 0px 10px #00000029;
                  "
              >
                <h3
                  class="py-4 pt-6 text-5xl text-center text-black tablet:text-6xl"
                >
                  {{ completedSurveysCount }}
                </h3>
                <div
                  class="flex flex-row justify-between text-xs tablet:text-base"
                >
                  <p class="mr-2">
                    {{ $t("surveys.completed") }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-if="content && contentPosition === 'before'">
      <component
        :is="`apo-cms-${renderer}-renderer`"
        v-for="(components, renderer) in content"
        :key="`${renderer}-renderer`"
        :components="components || []"
      />
    </div>
    <div
      id="text-section"
      class="flex flex-col justify-center py-20 mx-auto space-x-12 container-2 tablet:flex-col max-w-7xl"
    >
      <h3 class="mb-5 text-center">
        {{ $t("surveys.available_title2") }}
      </h3>
      <apo-wait for="surveys">
        <template #waiting>
          <apo-loading-overlay
            class="my-15"
            :message="$t('loaders.surveys')"
          />
        </template>
        <div
          v-if="surveys.length > 0"
          class="block tablet:hidden"
        >
          <carousel
            :per-page="1.5"
            :pagination-enabled="false"
            class="px-5 tablet:hidden"
          >
            <slide
              v-for="survey in sortedSurveys"
              :key="survey.id"
            >
              <div class="w-full px-1 py-2 mb-2 rounded-lg tablet:mr-4 tablet:w-1/4">
                <router-link
                  :to="'/surveys/' + survey.id"
                  class="flex flex-col justify-end px-2 py-2 mb-2 text-white rounded-lg tablet:px-5"
                  :style="isSurveyDone(survey) ? 'min-height:140px; box-shadow: 0px 0px 10px #00000029; color: #cccccc' : 'min-height:140px; background: transparent linear-gradient(245deg, #FFB80F 0%, #FF7000 100%) 0% 0% no-repeat padding-box;'"
                >
                  <p class="text-center">
                    {{ survey.title }}
                  </p>
                  <div class="flex flex-row items-center justify-between pt-5">
                    <p class="text-xs">
                      5 Min.
                    </p>
                    <div class="w-4 h-4 bg-white rounded-full"/>
                  </div>
                </router-link>
              </div>
            </slide>
          </carousel>
        </div>
        <div v-if="surveys.length > 0">
          <div

            class="flex-wrap hidden px-5 tablet:grid tablet:px-0 "
            style="
              overflow: hidden;
              grid-template-columns: repeat(4, 1fr);
              grid-auto-rows: 1fr;
              grid-column-gap: 5px;
              grid-row-gap: 5px;
            "
          >
            <div
              v-for="survey in sortedSurveys"
              :key="survey.id"
              class="w-full h-full px-1 py-2 mb-2 rounded-lg"
            >
              <router-link
                :to="'/surveys/' + survey.id"
                class="flex flex-col justify-end h-full px-2 py-2 text-white rounded-lg tablet:px-5"
                :style="isSurveyDone(survey) ? 'min-height:140px; box-shadow: 0px 0px 10px #00000029; color: #cccccc' : 'min-height:140px; background: transparent linear-gradient(245deg, #FFB80F 0%, #FF7000 100%) 0% 0% no-repeat padding-box;'"
              >
                <p class="text-center">
                  {{ survey.title }}
                </p>
                <div class="flex flex-row items-center justify-between pt-5">
                  <p class="text-xs">
                    5 Min.
                  </p>
                  <div class="w-4 h-4 bg-white rounded-full"/>
                </div>
              </router-link>
            </div>
          </div>
          <div v-if="showAllSurveysLink" class="flex flex-row justify-center mt-8">
            <router-link
              to="/surveys"
              style="background: #FF7000 0% 0% no-repeat padding-box;"
              class="w-full py-3 mx-5 mt-5 text-sm text-center text-white tablet:mx-0 tablet:w-56 rounded-xl tablet:block"
            >
              {{ $t('welcome.surveys_button') }}
            </router-link>
          </div>
        </div>

        <div
          v-else
          class="flex justify-center w-full"
          v-text="$t('surveys.messages.noSurveysAvailable')"
        />
      </apo-wait>

      <div v-if="content && contentPosition === 'after'">
        <component
          :is="`apo-cms-${renderer}-renderer`"
          v-for="(components, renderer) in content"
          :key="`${renderer}-renderer`"
          :components="components || []"
        />
      </div>
    </div>
  </apo-wait>
</template>

<script>

import {mapGetters, mapActions} from 'vuex';
import {SURVEYS_FETCH_ALL, LATESTS_SURVEYS} from '@/store/types/action-types';
import CmsContentRenderer from "@/components/cms/CmsContentRenderer";

export default {
  name: "AvailableSurveys",
  props: {
    showHeaderSection: {
      type: Boolean,
      default: false,
    },
    showAllSurveysLink: {
      type: Boolean,
      default: false,
    }
  },

  data() {
    return {
      showAchTooltip: false,
    };
  },
  computed: {
    ...mapGetters(['surveys']),
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

    completedSurveysCount() {
      return this.surveys.reduce((prev, item) => {
        if (this.isSurveyDone(item)) {
          return prev + 1;
        }
        return prev;
      }, 0);
    },

    sortedSurveys() {
      const result = this.surveys.sort((a, b) => {
        if ((this.isSurveyDone(a) ? 1 : 0) >= (this.isSurveyDone(b) ? 1 : 0)) {
          return 1;
        }
        if ((this.isSurveyDone(a) ? 1 : 0) < (this.isSurveyDone(b) ? 1 : 0)) {
          return -1;
        }
        if ((this.isSurveyDone(a) ? 1 : 0) === (this.isSurveyDone(b) ? 1 : 0)) {
          return 0;
        }
        return 0;
      });
      return result;
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

  methods: {
    ...mapActions([SURVEYS_FETCH_ALL, LATESTS_SURVEYS]),

    isSurveyDone(survey) {
      if (Object.keys(this.user.surveyResults).includes(survey.id)) {
        return true;
      }
      return false;
    },
    showTooltipAchievements() {
      this.showAchTooltip = !this.showAchTooltip;
    },
    showTooltipApopoints() {
      this.showApopTooltip = !this.showApopTooltip;
    },
  },

  created() {
    this[SURVEYS_FETCH_ALL]().catch(error => {
      console.log('error retrieving the surveys', error);
    });
  },
}
</script>

<style scoped>
#welcome-section-2 {
  background: transparent linear-gradient(249deg, #ffb80f 0%, #ff7000 100%) 0% 0% no-repeat padding-box;
}
</style>
