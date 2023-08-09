<template>
  <apo-wait for="auth.user">
    <template #waiting>
      <apo-loading-overlay
        class="my-15"
        :message="$t('loaders.profile')"
      />
    </template>

    <div class="flex flex-col items-center profile spacer-module-top">
      <apo-profile-picture
        class="w-32 h-32"
        :user="user"
      />

      <small
        v-if="!hasProfilePicture"
        class="inline-block mt-2 text-sm text-white"
        v-text="$t('pages.profile.noPicture')"
      />

      <h2
        class="mt-8 text-4xl font-bold text-white font-display"
        v-text="fullName"
      />

      <h3
        v-if="user.job"
        class="text-2xl font-normal text-white font-display"
        v-text="$t(`data.profile.job.${user.job}`)"
      />

      <p class="mt-4 text-center text-white text-md font-display">
        <span
          class="block"
          v-text="$t('pages.profile.workingSince', { date: user.workingSince })"
        />

        <small
          v-if="!user.workingSince"
          class="block mb-2 text-sm text-white"
          v-text="$t('pages.profile.pleaseAddInformation')"
        />
        <span
          class="block"
          v-text="$t('pages.profile.yearsOld', { age: user.age })"
        />

        <small
          v-if="!user.age"
          class="block text-sm text-white"
          v-text="$t('pages.profile.pleaseAddInformation')"
        />
      </p>

      <apo-button
        class="mt-12 text-blue-600 button--naked shadow-hard-dark"
        tag="apo-button"
        @click.native="$router.push({ name: 'profile.edit' })"
        v-text="$t('pages.profile.editProfile')"
      />

      <div class="flex flex-col items-center mt-20 desktop:flex-row desktop:items-start">
        <apo-expert-points
          class="w-40 h-40"
          :points="Number(expertPoints)"
        />

        <div class="mt-4 text-center text-white desktop:ml-10 desktop:text-left">
          <h4
            class="mt-2 text-4xl leading-tight font-display"
            v-html="$t('pages.profile.yourExpertPoints')"
          />
          <h5
            class="px-12 mt-4 text-2xl tablet:px-0"
            v-text="$t('pages.profile.collectedPremiums', { premiums: 2 })"
          />
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

      <div class="flex flex-col items-center w-full py-24 mt-16 text-gray-800 bg-blue-50">
        <h2
          class="px-12 text-3xl text-center tablet:px-0 tablet:text-5xl font-display"
          v-text="$t('pages.profile.tasksAndPriorities')"
        />

        <div class="flex-wrap w-full max-w-4xl px-16 mt-24 tablet:flex tablet:px-20 desktop:px-0">
          <apo-profile-listing
            class="tablet:w-1/2"
            :headline="$t('pages.profile.tasks')"
            :items="user.tasks"
            icon="training"
          >
            <template #item="{ item }">
              <span v-text="$t(`data.profile.task.${item}`)" />
            </template>
          </apo-profile-listing>
          <apo-profile-listing
            class="mt-12 tablet:mt-0 tablet:w-1/2 tablet:flex tablet:flex-col tablet:items-end"
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

        <apo-button
          class="mt-12 text-blue-600 button--naked shadow-hard-dark"
          tag="apo-button"
          @click.native="$router.push({ name: 'profile.edit', hash: '#tasks-and-priorities' })"
          v-text="$t('general.edit')"
        />
      </div>

      <div class="flex flex-col items-center w-full pt-24 pb-64 text-gray-800 bg-blue-200">
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
              <div class="mt-12 text-xl">
                <strong v-text="$t('general.pun')" /><br>
                <span>
                  {{ pharmacy.pharmacy_unique_number | formattedNumber }}
                </span>
              </div>
              <div class="mt-8 text-xl">
                <strong v-text="$t('general.pharmacy')" /><br>
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
              class="mt-12 text-blue-600 button--naked shadow-hard-dark"
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
                <strong v-text="$t('general.email')" /><br>
                <span v-text="user.email" />
              </div>
              <div class="mt-8 text-xl">
                <strong v-text="$t('general.password')" /><br>
                <span v-text="$t('general.passwordPlaceholder')" />
              </div>

              <apo-button
                class="mt-12 text-blue-600 button--naked shadow-hard-dark"
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

export default {
  components: {
    'apo-expert-points': ExpertPoints,
    'apo-cms-content-renderer': CmsContentRenderer,
    'apo-loading-overlay': LoadingOverlay,
    'apo-profile-listing': ProfileListing,
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

  computed: {
    ...mapGetters(['expertPoints']),
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
};

</script>

<style lang="scss" scoped>

.profile {
  background: linear-gradient(120deg, theme('colors.blue.600'), theme('colors.blue.400'));
}

</style>
