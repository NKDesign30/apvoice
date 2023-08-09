<template>
  <apo-wait for="surveys">
    <div v-if="showHeaderSection" id="welcome-section-2">
      <div
        class="flex flex-col max-w-7xl mx-auto justify-left pt-5 pb-10 pl-4 pr-4 text-white"
        style="position: relative;"
      >
        <img
          src="/assets/img/Survey.svg"
          class="absolute top-0 hidden tablet:block responsive-image"
        />
        <div class="flex flex-wrap  text-5xl tablet:text-4xl leading-3">
          <h1 class="pr-8 text-5xl tablet:text-5xl">
            <span class="w-full font-bold leading-3"
              >{{ $t("surveys.salutation") }} {{ user.firstName }}!</span
            ><br />
            <span class="w-full leading-4">
              {{ $t("surveys.section") }}<br />
              {{ $t("surveys.section2") }}
            </span>
          </h1>
        </div>
        <div class="flex flex-wrap w-full mt-5 tablet:w-1/3 desktop:w-full tablet:mt-0">
          <div class="w-full desktop:w-1/2 mr-4 flex-1">
            <p class="mb-3 text-xl">{{ $t("surveys.overview_text") }}:</p>
            <div class="flex flex-row tablet:flex-col desktop:flex-row">
              <div
                class="w-1/2 pr-2 tablet:w-full desktop:w-1/2 tablet:pr-0 desktop:pr-5 pr-5 card-res"
              >
                <div
                  class="w-full px-2 rounded-lg "
                  style="
                    background: transparent linear-gradient(244deg, #ffffff 0%, #f9f3d1 100%) 0% 0% no-repeat padding-box;
                    color: #3c3c3b;
                    box-shadow: 0px 0px 10px #00000029;
                    height: 172px;
                  "
                >
                  <h3
                    class="desktop:py-6 py-7 text-center text-black tablet:text-6xl "
                    style="font-size:5rem;    padding-top: 2.5rem;
    padding-bottom: 3.5rem;"
                  >
                    {{ surveys.length - completedSurveysCount - countUncompletedTraining }}
                  </h3>
                  <div class="flex flex-row justify-between text-xs tablet:text-base">
                    <p class="mr-2">
                      {{ $t("surveys.available") }}
                    </p>
                  </div>
                </div>
              </div>

              <div
                class="w-1/2 tablet:mt-4 desktop:mt-0 tablet:w-full desktop:w-1/2 desktop:pr-5 card-res"
              >
                <div
                  class="w-full px-2  rounded-lg"
                  style="
                    background: transparent linear-gradient(244deg, #ffffff 0%, #f9f3d1 100%) 0% 0% no-repeat padding-box;
                    color: #3c3c3b;
                    box-shadow: 0px 0px 10px #00000029;
                     height: 172px;
                  "
                >
                  <h3
                    class="desktop:py-6 py-7 text-center text-black tablet:text-6xl"
                    style="font-size:5rem;    padding-top: 2.5rem;
    padding-bottom: 3.5rem;"
                  >
                    {{ completedSurveysCount }}
                  </h3>
                  <div class="flex flex-row justify-between text-xs tablet:text-base">
                    <p class="mr-2">
                      {{ $t("surveys.completed") }}
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="w-2/3 flex-1">
            <p class="mb-3 text-xl">{{ $t("redeem.your") }} {{ $t("surveys.PointsOverview") }}:</p>
            <div class="flex flex-wrap w-full">
              <div
                class="relative  px-2 py-1 rounded-lg  "
                style="
                  background: transparent linear-gradient(245deg, #ffb80f 0%, #ff7000 100%) 0% 0% no-repeat padding-box;
                  box-shadow: 0px 0px 10px #00000029;
                  min-width: 250px;
                  max-width: 350px;
                  width: 350px;
                "
              >
                <div class="relative">
                  <img
                    src="/assets/img/Apo-Info.svg"
                    class="ml-auto cursor-pointer"
                    alt="info"
                    @click="showTooltipAchievements"
                  />
                  <div
                    id="tooltip-default"
                    role="tooltip"
                    class="absolute right-0 z-10 inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm top-10 tooltip dark:bg-gray-700"
                    :class="showAchTooltip ? 'opacity-1' : 'opacity-0'"
                    :style="showAchTooltip ? 'z-index: 999' : 'z-index: -1'"
                  >
                    {{ $t("general.apoCoinsTooltip") }}
                    <div class="tooltip-arrow" data-popper-arrow />
                  </div>
                </div>
                <img src="/assets/img/coins.svg" class="absolute left-5" alt="" />
                <h3 class="py-8 text-center tablet:text-6xl" style="font-size: 5rem;">
                  {{ user.expertPoints }}
                </h3>
                <div class="flex flex-row justify-between text-xs tablet:text-base">
                  <p class="mr-2">
                    {{ $t("general.apoCoins") }}
                  </p>
                  <router-link class="underline" to="/redeem">
                    {{ $t("surveys.buttons.redeem") }}
                  </router-link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div
      id="text-section"
      class="flex flex-col justify-center py-8 mx-auto space-x-12 container-2 tablet:flex-col max-w-7xl"
    >
      <h3 v-if="surveysTitleText" class="mb-5 text-center">
        {{ surveysTitleText }}
      </h3>
      <apo-wait for="surveys">
        <template #waiting>
          <apo-loading-overlay class="my-15" :message="$t('loaders.surveys')" />
        </template>
        <div v-if="surveys.length > 0" class="block tablet:hidden">
          <carousel :per-page="1.5" :pagination-enabled="false" class="px-5 tablet:hidden">
            <slide
              v-for="survey in sortedSurveys"
              v-if="userHasCompletedTraining(survey)"
              :key="survey.id"
            >
              <div class="w-full px-1 py-2 mb-2 rounded-lg tablet:mr-4 tablet:w-1/4">
                <router-link
                  :to="'/surveys/' + survey.id"
                  class="flex flex-col justify-end px-2 py-2 mb-2 text-white rounded-lg tablet:px-5"
                  :style="
                    isSurveyDone(survey)
                      ? 'min-height:140px; box-shadow: 0px 0px 10px #00000029; color: #cccccc'
                      : 'min-height:140px; background: transparent linear-gradient(245deg, #FFB80F 0%, #FF7000 100%) 0% 0% no-repeat padding-box;'
                  "
                >
                  <p class="text-center">
                    {{ survey.title }}
                  </p>
                  <div class="flex flex-row items-center justify-between pt-5">
                    <p class="text-xs">
                      5 Min.
                    </p>
                    <div class="w-4 h-4 bg-white rounded-full" />
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
              v-if="userHasCompletedTraining(survey)"
              :key="survey.id"
              class="w-full h-full px-1 py-2 mb-2 rounded-lg"
            >
              <router-link
                :to="'/surveys/' + survey.id"
                class="flex flex-col justify-end h-full px-2 py-2 text-white rounded-lg tablet:px-5"
                :style="
                  isSurveyDone(survey)
                    ? 'min-height:140px; box-shadow: 0px 0px 10px #00000029; color: #cccccc'
                    : 'min-height:140px; background: transparent linear-gradient(245deg, #FFB80F 0%, #FF7000 100%) 0% 0% no-repeat padding-box;'
                "
              >
                <p class="text-center">
                  {{ survey.title }}
                </p>
                <div class="flex flex-row items-center justify-between pt-5">
                  <p class="text-xs">
                    5 Min.
                  </p>
                  <div class="w-4 h-4 bg-white rounded-full" />
                </div>
              </router-link>
            </div>
          </div>
          <div v-if="showAllSurveysLink" class="flex flex-row justify-center mt-8">
            <router-link
              to="/surveys"
              style="background: #FF7000 0% 0% no-repeat padding-box;"
              class="w-full py-3 mx-5 mt-5 text-sm text-center text-white tablet:mx-0 tablet:w-56 rounded-xl "
            >
              {{ $t("welcome.surveys_button") }}
            </router-link>
          </div>
        </div>

        <div
          v-else
          class="flex justify-center w-full"
          v-text="$t('surveys.messages.noSurveysAvailable')"
        />
      </apo-wait>
    </div>
  </apo-wait>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import {
  SURVEYS_FETCH_ALL,
  LATESTS_SURVEYS,
  TAXONOMIES_FETCH_TRAINING_CATEGORIES,
  TRAININGS_FETCH_ALL_SERIES
} from "@/store/types/action-types";

export default {
  name: "AvailableSurveys",
  props: {
    showHeaderSection: {
      type: Boolean,
      default: false
    },
    showAllSurveysLink: {
      type: Boolean,
      default: false
    },
    surveysTitleText: {
      type: String,
      required: false
    }
  },

  data() {
    return {
      showAchTooltip: false,
      trainings: []
    };
  },
  computed: {
    ...mapGetters(["surveys"]),
    ...mapGetters(["user"]),
    ...mapGetters(["trainingCategory", "user"]),
    pageData() {
      return this.$store.state.pages.pageContent.filter(
        page => page.slug === this.$route.path.replace(/^\/|\/$/g, "")
      ).length > 0
        ? this.$store.state.pages.pageContent.filter(
            page => page.slug === this.$route.path.replace(/^\/|\/$/g, "")
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
    countUncompletedTraining() {
      let count = 0;
      this.surveys.forEach(survey => {
        if (survey.isActivatable) {
          if (this.user.trainingResults[survey.training_id] === undefined) {
            count++;
          } else if (
            !this.user.trainingResults[survey.training_id].completed_lessons.is_complete === "1"
          ) {
            count++;
          }
        }
      });
      return count;
    }
  },

  methods: {
    ...mapActions([
      SURVEYS_FETCH_ALL,
      LATESTS_SURVEYS,
      TAXONOMIES_FETCH_TRAINING_CATEGORIES,
      TRAININGS_FETCH_ALL_SERIES
    ]),

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
    userHasCompletedTraining(survey) {
      if (survey.isActivatable) {
        console.log("activable");
        if (this.user.trainingResults[survey.training_id] === undefined) {
          console.log("udni_activable");
          return false;
        }
        console.log("udni_activable2");
        return this.user.trainingResults[survey.training_id].is_complete === "1";
      }
      console.log("udni_activable_true");
      return true;
    }
  },

  created() {
    this[SURVEYS_FETCH_ALL]().catch(error => {
      console.log("error retrieving the surveys", error);
    });
    this[TRAININGS_FETCH_ALL_SERIES]().then(data => {
      this.trainings = data;
    });
  }
};
</script>

<style scoped>
#welcome-section-2 {
  background: transparent linear-gradient(249deg, #ffb80f 0%, #ff7000 100%) 0% 0% no-repeat
    padding-box;
}

.max-w-7xl {
  max-width: 85rem !important;
}

@media (max-width: 480px) {
  .card-res h3 {
    padding-bottom: 40px !important;
  }
  .card-res div {
    margin-bottom: 50px;
    height: 157px !important;
    width: 110%;
  }
}
@media (min-width: 767px) {
  .responsive-image {
    top: 0%;
    right: -15%;
    height: 100%;
    transform: scale(1);
  }
}
</style>
