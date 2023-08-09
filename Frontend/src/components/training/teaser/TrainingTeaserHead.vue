<template>
  <div class="flex flex-wrap justify-between mb-6 text-lg training-teaser__head">
    <p
      class="w-full mb-4 text-gray-700 training-teaser__label tablet:hidden"
      v-html="$options.filters.formatContent(categorieNames)"
    />
    <div class="flex flex-col tablet:flex-row tablet:flex-no-wrap training-teaser__description-container">
      <div class="w-full training-teaser__product-image tablet:mr-0 tablet:w-2/6">
        <img
          :src="infos.image.url"
          :alt="infos.image.alt"
          :title="infos.image.title"
          class="w-full h-auto"
        >
      </div>
      <div class="self-center mt-6 tablet:mt-0 tablet:pl-6 training-teaser__product-info w-full tablet:self-auto">
        <h3
          class="headline-4 font-bold training-teaser__product-name tablet:mb-4"
          v-html="$options.filters.formatContent(infos.name)"
        />
        <p
          class="hidden training-teaser__product-description tablet:block"
          v-html="$options.filters.formatContent(infos.description)"
        />
      </div>
    </div>
    <div class="mt-6 training-teaser__product-description tablet:hidden">
      <p v-html="$options.filters.formatContent(infos.description)" />
    </div>
    <div class="w-full my-6 text-center training-teaser__cta tablet:mt-0 tablet:w-1/4 tablet:text-right">
      <p
        class="hidden mb-4 text-gray-700 training-teaser__label tablet:block"
        v-html="$options.filters.formatContent(categorieNames)"
      />
      <router-link
        v-if="hasNextLesson"
        class="button--primary button--tiny shadow-hard-dark"
        tag="apo-button"
        :to="{ name: 'trainings', params: {
          series_id: id,
          series_slug: slug,
          id: training.id,
          training_slug: training.slug,
          lesson_id: nextLesson } }"
      >
        {{ buttonLabel }}
      </router-link>
      <apo-button
        v-if="!hasNextLesson && isComplete(training, user)"
        class="button--primary button--tiny shadow-hard-dark"
        @click="download(training)"
      >
        {{ buttonLabel }}
      </apo-button>
      <p class="mt-4 text-base font-bold">
        <router-link
          v-if="!hasNextLesson && isComplete(training, user)"
          tag="span"
          :to="{name: 'training-summary', params: { slug, id} }"
          class="border-b border-gray-900 cursor-pointer"
          v-text="$t('general.summary')"
        />
      </p>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';
import downloadCertificate from '@/mixins/download-certificate';

export default {

  mixins: [
    downloadCertificate(),
  ],

  props: {
    infos: {
      type: Object,
      required: true,
    },
    id: {
      type: Number,
      required: true,
    },
    slug: {
      type: String,
      required: true,
    },
    firstLesson: {
      type: String,
      required: true,
    },
    nextLesson: {
      required: true,
      validator: prop => typeof prop === 'string' || prop === null,
    },
    // required for downloadCertificate mixin
    training: {
      required: true,
      type: Object,
    },
    // required for downloadCertificate mixin
    currentTrainingId: {
      required: true,
      validator: prop => typeof prop === 'number' || prop === null,
    },
    categories: {
      type: Array,
      required: false,
      default: () => [],
    },
  },

  computed: {
    ...mapGetters(['trainingCategory', 'user']),
    buttonLabel() {
      if (!this.hasNextLesson) {
        return this.$t('trainings.certificate');
      } if (this.firstLesson === this.nextLesson) {
        return this.$t('trainings.buttons.startTraining');
      }
      return this.$t('general.continue');
    },
    hasNextLesson() {
      return this.nextLesson !== null;
    },
    categorieNames() {
      if (this.categories.length > 0) {
        return this.categories
          .map(id => this.trainingCategory(id))
          .map(category => category.name)
          .join(', ');
      }
      return null;
    },
  },
};
</script>

<style lang="scss" scoped>

.training-teaser__description-container {
  width: 80%;
}

.training-teaser__cta {
  width: 20%;
}

</style>
