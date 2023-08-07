<template>
  <div class="welcome-page">
    <apo-wait for="user">
      <div v-if="user.id > 0">
        <div
          id="welcome-section"
        >
          <div
            class="font-display relative flex flex-wrap justify-center w-full pt-5 pb-10 pl-4 pr-4 tablet:pl-10  mx-auto space-x-12 text-white desktop:py-20 tablet:overflow-hidden max-w-7xl"
          >
            <div class="flex flex-col w-full tablet:w-1/2">
              <div
                class="mt-4 tablet:my-0 pr-8 text-4xl desktop:text-5xl"
                style="line-height: 3.675rem !important;"
              >
                {{ $t('welcome.welcome') }}, {{ user.firstName }}!<br>
                <span class="w-full leading-4">
                  {{ $t('welcome.nice_day') }}
                </span>
              </div>
              <div class="mt-auto">
                <level
                  v-if="language != 'de' && language != 'at'"
                  :show-edit-icon="true"
                  :user="user"
                  :profile-picture="profilePicture"
                  class="mt-6 desktop:mt-12 desktop:py-2"
                />

                <achievements
                  class="tablet:hidden mt-6"
                />
              </div>
            </div>
            <div class="flex flex-col w-full mt-0 tablet:w-1/2">
              <achievements
                class="hidden tablet:block"
              />
              <p
                v-if="language != 'es'"
                class="mt-auto mb-3 text-xl"
              >
                {{ $t('welcome.achievments_Expert') }}
              </p>
              <div class="flex flex-row w-full ">
                <div
                  v-if="language != 'de' && language != 'at'"
                  class="w-1/2  py-1 px-2 mr-3 rounded-lg tablet:mt-4 desktop:mt-0 tablet:w-full desktop:w-1/2 "
                  style="background: transparent linear-gradient(244deg, #ADDDEF 0%, #0099FF 100%) 0% 0% no-repeat padding-box;"
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
                      class="absolute right-0 inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm top-10 tooltip dark:bg-gray-700"
                      :class="showApopTooltip ? 'opacity-1' : 'opacity-0'"
                      :style="showApopTooltip ? 'z-index: 999' : 'z-index: -1'"
                    >
                      {{ $t('general.apoPointsTooltip') }}
                      <div
                        class="tooltip-arrow"
                        data-popper-arrow
                      />
                    </div>
                  </div>

                  <img
                    src="/assets/img/star.svg"
                    class="absolute left-5"
                    alt="coins"
                  >

                  <h3
                    class="py-10 text-center tablet:text-6xl"
                    style="font-size:5rem"
                  >
                    {{ user.apoPoints }}
                  </h3>
                  <div class="flex flex-row justify-between text-xs tablet:text-base">
                    <p class="mr-2">
                      {{ $t('general.apoPoints') }}
                    </p>
                    <router-link
                      class="underline"
                      to="/trainings#premium"
                    >
                      {{ $t('welcome.redeem') }}
                    </router-link>
                  </div>
                </div>

                <div
                  class="flex flex-row w-1/2 pr-2 tablet:1/2 desktop:1/2 tablet:pr-0 desktop:pr-2 space-between"
                >
                  <div
                    class="relative  px-2 py-1 rounded-lg w-full"
                    style=";background: transparent linear-gradient(245deg, #FFB80F 0%, #FF7000 100%) 0% 0% no-repeat padding-box;"
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
                        class="absolute right-0 inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm top-10 tooltip dark:bg-gray-700"
                        :class="showAchTooltip ? 'opacity-1 ' : 'opacity-0 '"
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
                      alt="coins"
                    >
                    <h3
                      class="py-10  text-center tablet:text-6xl"
                      style="font-size:5rem"
                    >
                      {{ user.expertPoints }}
                    </h3>
                    <div class="z-50 flex flex-row justify-between text-xs tablet:text-base">
                      <p class="mr-2">
                        {{ $t('general.apoCoins') }}
                      </p>
                      <router-link
                        class="underline"
                        to="/redeem"
                      >
                        {{ $t('welcome.redeem') }}
                      </router-link>
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

        <!-- Divider -->
        <div
          class="w-11/12 h-2 mx-auto mb-5 bg-red-400 container-2 tablet:w-full"
          style="
          background: transparent linear-gradient(270deg, #ADDDEF 0%, #0099FF 100%) 0% 0% no-repeat
            padding-box;
          "
        />

        <div
          id="text-section"
          class="flex flex-col justify-center px-5 py-10 mx-auto space-x-12 container-2 tablet:flex-col max-w-7xl tablet:px-0"
        >
          <h2
            class="mb-5 text-5xl text-center"
            style="color: #0099FF;"
            v-text="$t('trainings.overview.headline')"
          />
          <p
            class="text-md tablet:text-center tablet:px-40 tablet:text-base"
            v-text="$t('trainings.overview.message')"
          />
          <p
            class="text-md tablet:text-center tablet:px-40 tablet:text-base"
            v-text="$t('trainings.overview.submessage')"
          />
        </div>

        <div
          class="w-11/12 h-2 mx-auto mb-5 bg-red-400 container-2 tablet:w-full"
          style="
          background: transparent linear-gradient(270deg, #ADDDEF 0%, #0099FF 100%) 0% 0% no-repeat
          padding-box;
          "
        />
        <div
          id="text-section"
          class="flex flex-col justify-center py-10 mx-auto space-x-12 container-2 tablet:flex-col max-w-7xl "
        >
          <h2
            v-if="categoryTrainingSeries.length > 0"
            class="px-5 mb-5 text-3xl text-left tablet:text-4xl"
          >
            {{ $t('welcome.latest_categories') }}
          </h2>
          <apo-wait for="trainings.latestCategoryTrainings">
            <template #waiting>
              <apo-loading-overlay
                class="my-15"
              />
            </template>
            <div class="block tablet:hidden">
              <carousel
                :per-page="1.5"
                :pagination-enabled="false"
                class="px-5"
              >
                <slide
                  v-for="training in categoryTrainingSeries"
                  :key="training.id"
                >
                  <router-link
                    v-if="training.trainings.length > 0"
                    :to="getTrainingLink(training)"
                    class="flex flex-col w-full px-5 mb-5 tablet:w-1/4 tablet:mr-4 tablet:mb-0"
                  >
                    <div
                      class="relative px-1 py-2 mb-2 bg-gray-600 rounded-lg tablet:px-10"
                      style="min-height:200px"
                    >
                      <div class="absolute inset-0 w-full h-40 h-full overflow-hidden rounded-lg">
                        <img
                          class="object-cover object-top w-full h-full ml-auto rounded-lg"
                          style="box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2)"
                          :src="training.informations.image.url"
                        >
                      </div>
                    </div>
                    <p class="text-center">
                      {{ training.title.rendered }}
                    </p>
                  </router-link>
                </slide>
              </carousel>
            </div>
            <div
              class="flex-col hidden px-5 tablet:flex-row tablet:flex-wrap tablet:px-0 tablet:flex"
            >
              <router-link
                v-for="training in categoryTrainingSeries"
                :key="training.id"
                :to="getTrainingLink(training)"
                class="flex flex-col w-full px-1 mb-5 tablet:w-1/4 tablet:mb-0"
              >
                <div
                  v-if="training.trainings.length > 0"
                  class="relative px-1 py-2 mb-2 bg-gray-600 rounded-lg tablet:px-10"
                  style="min-height:200px"
                >
                  <div class="absolute inset-0 w-full h-40 h-full overflow-hidden rounded-lg">
                    <img
                      class="object-cover object-top w-full h-full ml-auto rounded-lg"
                      style="box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2)"
                      :src="training.informations.image.url"
                    >
                  </div>
                </div>
                <p class="text-center">
                  {{ training.title.rendered }}
                </p>
              </router-link>
            </div>
            <div
              v-if="categoryTrainingSeries.length > 0"
              class="flex flex-row justify-center mt-8"
            >
              <router-link
                to="/trainings#category"
                style="background: #0099FF 0% 0% no-repeat padding-box;"
                class="w-full py-3 mx-5 mt-5 text-sm text-center text-white tablet:mx-0 tablet:w-64 rounded-xl tablet:block"
              >
                {{ $t('welcome.category_trainings_button') }}
              </router-link>
            </div>
          </apo-wait>
        </div>
        <div
          id="text-section"
          class="flex flex-col justify-center py-10 mx-auto space-x-12 container-2 tablet:flex-col max-w-7xl "
        >
          <h2
            v-if="productTrainingSeries.length > 0"
            class="px-5 mb-5 text-3xl text-left tablet:text-4xl"
          >
            {{ $t('welcome.latest_products') }}
          </h2>
          <apo-wait for="trainings.latestProductTrainings">
            <template #waiting>
              <apo-loading-overlay
                class="my-15"
              />
            </template>
            <div class="block tablet:hidden">
              <carousel
                :per-page="1.5"
                :pagination-enabled="false"
                class="px-5"
              >
                <slide
                  v-for="training in productTrainingSeries"
                  :key="training.id"
                >
                  <router-link
                    v-if="training.trainings.length > 0"
                    :to="getTrainingLink(training)"
                    class="flex flex-col w-full px-5 mb-5 tablet:w-1/4 tablet:mr-4 tablet:mb-0"
                  >
                    <div
                      class="relative px-1 py-2 mb-2 bg-gray-600 rounded-lg tablet:px-10"
                      style="min-height:200px"
                    >
                      <div class="absolute inset-0 w-full h-40 h-full overflow-hidden rounded-lg">
                        <img
                          class="object-cover object-top w-full h-full ml-auto rounded-lg"
                          style="box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2)"
                          :src="training.informations.image.url"
                        >
                      </div>
                    </div>
                    <p class="text-center">
                      {{ training.title.rendered }}
                    </p>
                  </router-link>
                </slide>
              </carousel>
            </div>
            <div
              class="flex-col hidden px-5 tablet:flex-row tablet:flex-wrap tablet:px-0 tablet:flex"
            >
              <router-link
                v-for="training in productTrainingSeries"
                :key="training.id"
                :to="getTrainingLink(training)"
                class="flex flex-col w-full px-1 mb-5 tablet:w-1/4 tablet:mb-0"
              >
                <div
                  v-if="training.trainings.length > 0"
                  class="relative px-1 py-2 mb-2 bg-gray-600 rounded-lg tablet:px-10"
                  style="min-height:200px"
                >
                  <div class="absolute inset-0 w-full h-40 h-full overflow-hidden rounded-lg">
                    <img
                      class="object-cover object-top w-full h-full ml-auto rounded-lg"
                      style="box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2)"
                      :src="training.informations.image.url"
                    >
                  </div>
                </div>
                <p class="text-center">
                  {{ training.title.rendered }}
                </p>
              </router-link>
            </div>
            <div
              v-if="productTrainingSeries.length > 0"
              class="flex flex-row justify-center mt-8"
            >
              <router-link
                to="/trainings#products"
                style="background: #0099FF 0% 0% no-repeat padding-box;"
                class="w-full py-3 mx-5 mt-5 text-sm text-center text-white tablet:mx-0 tablet:w-64 rounded-xl tablet:block"
              >
                {{ $t('welcome.product_trainings_button') }}
              </router-link>
            </div>
            <div class="flex flex-row justify-center mt-8">
              {{ $t('welcome.star') }}
            </div>
          </apo-wait>
        </div>
        <div
          id="text-section"
          class="flex flex-col justify-center py-10 mx-auto space-x-12 container-2 tablet:flex-col max-w-7xl"
        >
          <h2
            v-if="lastestPremiumSeries.length > 0"
            class="px-5 mb-5 text-3xl text-left tablet:text-4xl"
          >
            {{ $t('welcome.latest_premium') }}
          </h2>
          <apo-wait for="trainings.latestPremiumTrainings">
            <template #waiting>
              <apo-loading-overlay
                class="my-15"
              />
            </template>
            <div class="block tablet:hidden">
              <carousel
                :per-page="1.5"
                :pagination-enabled="false"
                class="px-5"
              >
                <slide
                  v-for="training in lastestPremiumSeries"
                  :key="training.id"
                >
                  <router-link
                    v-if="training.trainings.length > 0"
                    :to="getTrainingLink(training)"
                    class="flex flex-col w-full px-5 mb-5 tablet:w-1/4 tablet:mr-4 tablet:mb-0"
                  >
                    <div
                      class="relative px-1 py-2 mb-2 bg-gray-600 rounded-lg tablet:px-10"
                      style="min-height:200px"
                    >
                      <div class="absolute inset-0 w-full h-40 h-full overflow-hidden rounded-lg">
                        <img
                          class="object-cover object-top w-full h-full ml-auto rounded-lg"
                          style="box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2)"
                          :src="training.informations.image.url"
                        >
                      </div>
                    </div>
                    <p class="text-center">
                      {{ training.title.rendered }}
                    </p>
                  </router-link>
                </slide>
              </carousel>
            </div>
            <div class="flex-col hidden px-5 tablet:flex tablet:flex-row tablet:px-0">
              <router-link
                v-for="training in lastestPremiumSeries"
                :key="training.id"
                :to="getTrainingLink(training)"
                class="flex flex-col w-full px-1 mb-5 tablet:w-1/4 tablet:mb-0"
              >
                <div
                  v-if="training.trainings.length > 0"
                  class="relative px-1 py-2 mb-2 bg-gray-600 rounded-lg tablet:px-10"
                  style="min-height:200px"
                >
                  <div class="absolute inset-0 w-full h-40 h-full overflow-hidden rounded-lg">
                    <img
                      class="object-cover object-top w-full h-full ml-auto rounded-lg"
                      style="box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2)"
                      :src="training.informations.image.url"
                    >
                  </div>
                </div>
                <p class="text-center">
                  {{ training.title.rendered }}
                </p>
              </router-link>
            </div>
            <div
              v-if="lastestPremiumSeries.length > 0"
              class="flex flex-row justify-center mt-8"
            >
              <router-link
                to="/trainings#premium"
                style="background: #D4AF37 0% 0% no-repeat padding-box;"
                class="w-56 py-3 mt-5 text-sm text-center text-white rounded-xl tablet:block"
              >
                {{ $t('welcome.premium_button') }}
              </router-link>
            </div>
          </apo-wait>
        </div>

        <!--Scientific trainings -->
        <!-- Divider -->
        <div
          v-if="latestScientificCategoryTrainingSeries.length > 0"
          class="w-11/12 h-2 mx-auto mb-5 bg-red-400 container-2 tablet:w-full"
          style="background: transparent linear-gradient(270deg, #9BD442 0%, #00B041 100%) 0% 0% no-repeat padding-box;opacity: 1;"
        />

        <div
          v-if="latestScientificCategoryTrainingSeries.length > 0"
          id="text-section5"
          class="flex flex-col justify-center px-5 py-10 mx-auto space-x-12 container-2 tablet:flex-col max-w-7xl tablet:px-0"
        >
          <h2
            class="mb-5 text-5xl text-center"
            style="color: #00b041"
            v-text="$t('trainings.scientific.overview.headline')"
          />
          <p
            class="text-md tablet:text-center tablet:px-40 tablet:text-base"
            v-text="$t('trainings.scientific.overview.message')"
          />
          <p
            class="text-md tablet:text-center tablet:px-40 tablet:text-base"
            v-text="$t('trainings.scientific.overview.submessage')"
          />
        </div>

        <div
          v-if="latestScientificCategoryTrainingSeries.length > 0"
          class="w-11/12 h-2 mx-auto mb-5 bg-red-400 container-2 tablet:w-full"
          style="background: transparent linear-gradient(270deg, #9BD442 0%, #00B041 100%) 0% 0% no-repeat padding-box;opacity: 1;"
        />

        <div class="flex flex-col justify-center py-10 mx-auto space-x-12 container-2 tablet:flex-col max-w-7xl ">
          <h2
            v-if="latestScientificCategoryTrainingSeries.length > 0"
            class="px-5 mb-5 text-3xl text-left tablet:text-4xl"
          >
            {{ $t('welcome.latest_scientific') }}
          </h2>
          <apo-wait for="trainings.series">
            <template #waiting>
              <apo-loading-overlay
                class="my-15"
              />
            </template>
            <div
              v-if="latestScientificCategoryTrainingSeries.length > 0"
              class="block tablet:hidden"
            >
              <carousel
                :per-page="1.5"
                :pagination-enabled="false"
                class="px-5"
              >
                <slide
                  v-for="training in latestScientificCategoryTrainingSeries"
                  :key="training.id"
                >
                  <router-link
                    v-if="training.trainings.length > 0"
                    :to="{
                      name: 'scientific',
                      params: {
                        series_id: training.id,
                        series_slug: training.slug,
                        id: training.trainings[0].id,
                        training_slug: training.trainings[0].slug,
                        lesson_id: training.trainings[0].lessons[0].lesson_id,
                      },
                    }"
                    class="flex flex-col w-full px-5 mb-5 tablet:w-1/4 tablet:mr-4 tablet:mb-0"
                  >
                    <div
                      class="relative px-1 py-2 mb-2 bg-gray-600 rounded-lg tablet:px-10"
                      style="min-height:200px"
                    >
                      <div class="absolute inset-0 w-full h-40 h-full overflow-hidden rounded-lg">
                        <img
                          class="object-cover object-top w-full h-full ml-auto rounded-lg"
                          style="box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2)"
                          :src="training.informations.image.url"
                        >
                      </div>
                    </div>
                    <p class="text-center">
                      {{ training.title }}
                    </p>
                  </router-link>
                </slide>
              </carousel>
            </div>
            <div
              v-if="latestScientificCategoryTrainingSeries.length > 0"
              class="flex-col hidden px-5 tablet:flex-row tablet:flex-wrap tablet:px-0 tablet:flex"
            >
              <router-link
                v-for="training in latestScientificCategoryTrainingSeries"
                :key="training.id"
                :to="{
                  name: 'scientific',
                  params: {
                    series_id: training.id,
                    series_slug: training.slug,
                    id: training.trainings[0].id,
                    training_slug: training.trainings[0].slug,
                    lesson_id: training.trainings[0].lessons[0].lesson_id,
                  },
                }"
                class="flex flex-col w-full px-1 mb-5 tablet:w-1/4 tablet:mb-0"
              >
                <div
                  v-if="training.trainings.length > 0"
                  class="relative px-1 py-2 mb-2 bg-gray-600 rounded-lg tablet:px-10"
                  style="min-height:200px"
                >
                  <div class="absolute inset-0 w-full h-40 h-full overflow-hidden rounded-lg">
                    <img
                      class="object-cover object-top w-full h-full ml-auto rounded-lg"
                      style="box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2)"
                      :src="training.informations.image.url"
                    >
                  </div>
                </div>
                <p class="text-center">
                  {{ training.title }}
                </p>
              </router-link>
            </div>
            <div
              v-if="latestScientificCategoryTrainingSeries.length > 0"
              class="flex flex-row justify-center mt-8"
            >
              <router-link
                to="/scientific"
                style="background: #00b041 0% 0% no-repeat padding-box;"
                class="w-full py-3 mx-5 mt-5 text-sm text-center text-white tablet:mx-0 tablet:w-64 rounded-xl tablet:block"
              >
                {{ $t('welcome.scientific_trainings_button') }}
              </router-link>
            </div>
          </apo-wait>
        </div>
        <!-- Scientific end -->

        <!-- Divider -->
        <div
          v-if="this.countDone > 0"
          class="w-11/12 h-2 mx-auto mb-5 bg-red-400 container-2 tablet:w-full"
          style="
          background: transparent linear-gradient(270deg, #FFB80F 0%, #FF7000 100%) 0% 0% no-repeat padding-box;

          "
        />
        <!-- /Divider -->

        <div
          v-if="this.countDone > 0"
          id="text-section"
          class="flex flex-col justify-center px-5 py-10 mx-auto space-x-12 container-2 tablet:flex-col max-w-7xl tablet:px-0"
        >
          <h2
            class="mb-5 text-5xl text-center"
            style="color: #FF7000;"
          >
            {{ $t('welcome.surveys') }}
          </h2>
          <p class="text-md tablet:text-center tablet:px-40 tablet:text-base">
            {{ $t('welcome.surveys_description') }}
          </p>
        </div>

        <!-- Divider -->
        <div
          v-if="this.countDone > 0"
          class="w-11/12 h-2 mx-auto mb-5 bg-red-400 container-2 tablet:w-full"
          style="
          background: transparent linear-gradient(270deg, #FFB80F 0%, #FF7000 100%) 0% 0% no-repeat padding-box;

          "
        />
        <div
          v-if="this.countDone > 0"
          class="block tablet:hidden"
        >
          <carousel
            :pagination-enabled="false"
            :per-page="1.5"
            class="px-5"
          >
            <slide
              v-for="survey in surveysSeries"
              :key="survey.id"
            >
              <div class="w-full px-1 py-2 mb-2 rounded-lg tablet:mr-4 tablet:w-1/4">
                <router-link
                  :to="'/surveys/' + survey.id"
                  class="flex flex-col justify-end px-2 py-2 mb-2 text-white rounded-lg tablet:px-5"
                  style="min-height:140px; background: transparent linear-gradient(245deg, #FFB80F 0%, #FF7000 100%) 0% 0% no-repeat padding-box;"
                >
                  <p class="text-center">
                    {{ survey.title.rendered }}
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
        <div
          v-if="this.countDone > 0"
          id="text-section"
          class="flex-col justify-center hidden py-10 mx-auto space-x-12 tablet:flex container-2 tablet:flex-col max-w-7xl"
        >
          <div class="flex flex-col px-5 tablet:flex-row tablet:flex-wrap tablet:px-0">
            <div
              v-for="survey in surveysSeries"
              v-show="!isSurveyDone(survey.id)"
              :key="survey.id"
              class="w-full px-1 py-2 mb-2 rounded-lg tablet:w-1/4"
            >
              <router-link
                :to="'/surveys/' + survey.id"
                class="flex flex-col justify-end px-2 py-2 mb-2 text-white rounded-lg tablet:px-5"
                style="min-height:140px; background: transparent linear-gradient(245deg, #FFB80F 0%, #FF7000 100%) 0% 0% no-repeat padding-box;"
              >
                <p class="text-center">
                  {{ survey.title.rendered }}
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
          <div
            v-if="this.countDone > 0"
            class="flex flex-row justify-center mt-8"
          >
            <router-link
              to="/surveys"
              style="background: #FF7000 0% 0% no-repeat padding-box;"
              class="w-full py-3 mx-5 mt-5 text-sm text-center text-white tablet:mx-0 tablet:w-56 rounded-xl tablet:block"
            >
              {{ $t('welcome.surveys_button') }}
            </router-link>
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
        <!-- /Divider -->
      </div>
    </apo-wait>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import themeSettings from '@/mixins/theme-settings';
import CmsContentRenderer from '@/components/cms/CmsContentRenderer.vue';
import { canonicalTag } from '@/services/utils';
import LoadingOverlay from '@/components/ui/LoadingOverlay.vue';

import Achievements from '@/components/user/performance/Achievements';
import Level from '@/components/user/performance/Level';
import {
  TAXONOMIES_FETCH_TRAINING_CATEGORIES,
  TRAININGS_FETCH_ALL_SERIES,
} from '@/store/types/action-types';


export default {

  components: {
    'apo-cms-content-renderer': CmsContentRenderer,
    'apo-loading-overlay': LoadingOverlay,
    achievements: Achievements,
    level: Level,
  },

  data() {
    return {
      showAchTooltip: false,
      showApopTooltip: false,
      scientificCategory: null,
    };
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

  mixins: [themeSettings('welcome')],

  computed: {
    ...mapGetters(['user', 'profilePicture']),
    ...mapGetters(['trainingSeries', 'productTrainingSeries', 'categoryTrainingSeries', 'latestPremiumTrainingSeries', 'surveysTrainingSeries']),
    ...mapGetters(['language']),
    uncompletedSeries() {
      return this.$store.state.trainings.uncompletedTrainingSeries;
    },
    lastestPremiumSeries() {
      return this.$store.state.trainings.latestPremiumTrainingSeries;
    },
    countDone() {
      let CT = 0;
      this.surveysSeries.forEach(element => {
        if (this.isSurveyDone(element.id)) {
          CT++;
        }
      });
      return this.surveysSeries.length - CT;
    },
    latestScientificCategoryTrainingSeries() { // add sort by id and then limit to four
      const series = this.trainingSeries.filter(item => item.trainings.length > 0 && this.isScientificCategoryTraining(item) && parseInt(item.trainings[0].isPremium) === 0);
      return series.sort((a, b) => this.sortSeries(a, b)).slice(0, 4); // highest id's first then first 4
    },
    surveysSeries() {
      return this.$store.state.trainings.surveysTrainingSeries;
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
  },
  methods: {
    ...mapActions(['fetchLatestProductTraining', 'fetchLatestCategoryTraining', 'TRAININGS_FETCH_ALL_SERIES',
      'TAXONOMIES_FETCH_TRAINING_CATEGORIES']),
    ...mapActions(['fetchLatestPremiumTrainingSeries']),
    ...mapActions(['fetchSurveysTrainingSeries']),
    isSurveyDone(id) {
      return (Object.keys(this.user.surveyResults).includes(`${id}`));
    },
    showTooltipAchievements() {
      this.showAchTooltip = !this.showAchTooltip;
    },
    showTooltipApopoints() {
      this.showApopTooltip = !this.showApopTooltip;
    },
    getTrainingLink(training) {
      if (training.trainings.length <= 0) {
        return '';
      }
      const url = `/trainings/${training.slug}/${training.trainings[0].training.post_name}/${training.trainings[0].lessons[0].lesson.lesson_id}`;
      return url;
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
    sortSeries(a, b) {
      if (a.id < b.id) {
        return 1;
      }
      return -1;
    },
  },
  created() {
    this[TRAININGS_FETCH_ALL_SERIES]();
    this.fetchLatestProductTraining();
    this.fetchLatestCategoryTraining();
    this.fetchLatestPremiumTrainingSeries();
    this.fetchSurveysTrainingSeries();
    this[TAXONOMIES_FETCH_TRAINING_CATEGORIES]().then(data => {
      this.scientificCategory = data.find(item => item.slug === 'scientific');
    });
  },
};
</script>

<style scoped lang="scss">
#welcome-section {
 background-image: linear-gradient(to right, #0243b9, #0058ca, #006cda, #0080e8, #1894f6);
 column-gap: 150px;
}

.container-2 {
  max-width: 1350px;
}


</style>
<style>
header .container .justify-end {
  padding-left: 0;
}

</style>
