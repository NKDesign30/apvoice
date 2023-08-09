<template>
  <apo-wait for="auth.user">
    <template #waiting>
      <apo-loading-overlay
        class="my-15"
        :message="$t('loaders.profile')"
      />
    </template>
    <div
      id="welcome-section-p"
    >
      <div
        class="font-display relative flex flex-wrap justify-center w-full pt-5 pb-10 pl-4 pr-4 tablet:pl-10  mx-auto space-x-12 text-white desktop:py-20 tablet:overflow-hidden max-w-7xl"
      >
        <div class="flex flex-col w-full tablet:w-1/2">
          <div class="mt-4 tablet:my-0 pr-8 text-4xl desktop:text-5xl leading-3">
            {{ $t('welcome.welcome') }}, {{ user.firstName }}!<br>
            <span class="w-full leading-4">
              {{ $t('welcome.nice_day') }}
            </span>
          </div>

          <div
            v-if="language != 'de' && language != 'at'"
            class="mt-auto"
          >
            <level
              v-if="language != 'de' && language != 'at'"
              :show-edit-icon="true"
              :user="user"
              :profile-picture="profilePicture"
              class="mt-6 desktop:mt-12 desktop:py-2"
            />

            <achievements class="tablet:hidden mt-6" />
          </div>
        </div>
        <div class="flex flex-col w-full mt-0 tablet:w-1/2">
          <achievements
            v-if="language != 'de' && language != 'at'"
            class="hidden tablet:block"
          />

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
    <div class="flex flex-col items-center ">
      <div class="flex flex-col items-center w-full py-24 text-gray-800">
        <h2
          class="px-12 text-3xl text-center tablet:px-0 tablet:text-5xl font-display"
          v-text="$t('pages.profile.tasksAndPriorities')"
        />

        <div class="flex-wrap w-full max-w-4xl px-16 desktop:mt-24 tablet:flex tablet:px-20 desktop:px-0">
          <apo-profile-listing
            class="mt-24 tablet:mt-0 tablet:w-1/2 tablet:flex tablet:justify-start"
            :headline="$t('pages.profile.tasks')"
            :items="user.tasks"
            icon="tasks"
          >
            <template #item="{ item }">
              <span v-text="$t(`data.profile.task.${item}`)" />
            </template>
          </apo-profile-listing>
          <apo-profile-listing
            class="mt-24 tablet:mt-0 tablet:w-1/2 tablet:flex tablet:justify-end"
            :headline="$t('pages.profile.priorities')"
            :items="user.priorities"
            icon="training"
          >
            <template #item="{ item }">
              <span
                v-if="$t(`data.profile.priority.${item}`) !== `data.profile.priority.${item}`"
                v-text="$t(`data.profile.priority.${item}`)"
              />
              <span
                v-else
                v-text="item"
              />
            </template>
          </apo-profile-listing>
        </div>
      </div>

      <div
        class="flex flex-col items-center w-full pt-24 pb-64 "
        style="color: #3C3C3B;"
      >
        <div class="flex-wrap w-full max-w-4xl px-16 tablet:flex tablet:px-20 desktop:px-0">
          <div class="tablet:w-1/2">
            <h2
              class="text-3xl tablet:text-5xl font-display"
              v-text="$tc('pages.profile.yourPharmacy', user.associatedPharmacies.length)"
            />

            <div
              v-for="pharmacy in user.associatedPharmacies"
              :key="pharmacy.id"
            >
              <div
                class="mt-12 text-xl "
                style="color: #3C3C3B;"
              >
                <strong v-text="$t('general.pun')" /><br>
                <span style="color: #3C3C3B;">
                  {{ pharmacy.pharmacy_unique_number | formattedNumber }}
                </span>
              </div>
              <div class="mt-8 text-xl">
                <strong
                  style="color: #3C3C3B;"
                  v-text="$t('general.pharmacy')"
                /><br>
                <span v-text="pharmacy.name" />
              </div>
            </div>
            <div
              v-for="pharmacy in user.expertOnlyPharmacies"
              :key="pharmacy.id"
            >
              <div
                v-for="(value, index) in pharmacy"
                :key="index"
              >
                {{ value.title === 'pharmacyCountry' ? $t('modules.pharmacySummary.form.' + value.value) : value.value }}
              </div>
            </div>

            <apo-button
              class="w-64 mt-12 text-white bg-blue-600"
              tag="apo-button"
              @click.native="$router.push({ name: 'profile.edit', hash: '#your-pharmacy' })"
              v-text="$t('general.edit')"
            />
          </div>
          <div class="mt-24 tablet:mt-0 tablet:w-1/2 tablet:flex tablet:justify-end">
            <div>
              <h2
                class="text-3xl tablet:text-5xl font-display"
                v-text="$t('pages.profile.yourAccount')"
              />

              <div class="mt-12 text-xl">
                <span
                  style="color: #3C3C3B;"
                  v-text="$t('general.email')"
                /><br>
                <span v-text="user.email" />
              </div>
              <div class="mt-8 text-xl">
                <span v-text="$t('general.password')" /><br>
                <span v-text="$t('general.passwordPlaceholder')" />
              </div>

              <apo-button
                class="w-64 mt-12 text-white bg-blue-600"
                tag="apo-button"
                @click.native="$router.push({ name: 'profile.edit', hash: '#your-account' })"
                v-text="$t('general.edit')"
              />
            </div>
          </div>
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
    </div>
  </apo-wait>
</template>

<script>

import { mapState, mapGetters } from 'vuex';
import LoadingOverlay from '@/components/ui/LoadingOverlay.vue';
import CmsContentRenderer from '@/components/cms/CmsContentRenderer.vue';
import ExpertPoints from '@/components/user/ExpertPoints.vue';
import ProfileListing from '@/components/user/ProfileListing.vue';
import { canonicalTag } from '@/services/utils';
import Achievements from '@/components/user/performance/Achievements';
import Level from '@/components/user/performance/Level';
import themeSettings from '@/mixins/theme-settings';

export default {
  components: {
    'apo-expert-points': ExpertPoints,
    'apo-cms-content-renderer': CmsContentRenderer,
    'apo-loading-overlay': LoadingOverlay,
    'apo-profile-listing': ProfileListing,
    achievements: Achievements,
    level: Level,
  },

  data() {
    return {
      showAchTooltip: false,
      showApopTooltip: false,
    };
  },

  head() {
    return {
      title: {
        inner: this.$t('pages.profile.meta.title'),
      },
      link: [
        canonicalTag(this.$route),
      ],
    };
  },
  mixins: [themeSettings('profile')],
  computed: {
    ...mapGetters(['expertPoints']),
    ...mapGetters(['user', 'profilePicture']),
    ...mapGetters(['language']),
    ...mapState({
      user: state => state.auth.user,
    }),
    pageData() {
      return this.$store.state.pages.pageContent.filter(page => page.slug === this.$route.path.replace(/^\/|\/$/g, '')).length > 0
        ? this.$store.state.pages.pageContent.filter(page => page.slug === this.$route.path.replace(/^\/|\/$/g, ''))[0]
        : null;
    },
    content() {
      if (this.pageData) {
        const {
        /* eslint-disable */
          password, minimum_height, slides, public_resource, content_position, ...filtered
        } = this.pageData.acf;
        /* eslint-enable */
        return filtered;
      }

      return null;
    },

    contentPosition() {
      return this.pageData ? this.pageData.acf.content_position : null;
    },

    hasProfilePicture() {
      return this.user.profilePicture !== null && Object.keys(this.user.profilePicture).length > 0;
    },

    fullName() {
      return `${this.user.firstName} ${this.user.lastName}`;
    },
  },

  methods: {
    showTooltipAchievements() {
      this.showAchTooltip = !this.showAchTooltip;
    },
    showTooltipApopoints() {
      this.showApopTooltip = !this.showApopTooltip;
    },
  },
};

</script>

<style lang="scss" scoped>

.profile {
  background: linear-gradient(120deg, theme('colors.blue.600'), theme('colors.blue.400'));
}

#welcome-section-p{
 background-image: linear-gradient(to right, #0243b9, #0058ca, #006cda, #0080e8, #1894f6);
}

</style>
