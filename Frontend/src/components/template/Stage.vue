<template>
  <div
    v-if="stageData"
    class="stage-container"
  >
    <vue-glide
      class="slider"
      :options="{type: 'carousel', perView: 1, dragThreshold: stageData.slides.length > 1 ? 120 : false}"
    >
      <vue-glide-slide
        v-for="(slide) in stageData.slides"
        :key="slide.title"
        class="slide"
        :style="stageData.minimum_height ? { 'min-height': `${stageData.minimum_height}px` } : null"
      >
        <div
          class="slide-style-container"
          :style="slide.background_color ? {
            background: slide.background_color,
            'min-height': `${stageData.minimum_height}px`
          } : { 'min-height': `${stageData.minimum_height}px` }"
        >
          <div
            class="slide-style-container"
            :style="slide.background_image ? {
              'background-image': `url(${slide.background_image})`,
              'background-repeat': 'no-repeat',
              'background-size': 'cover',
              'background-position': 'center center',
              'min-height': `${stageData.minimum_height}px`
            } : { 'min-height': `${stageData.minimum_height}px` }"
          >
            <div
              class="slide-inner-container"
              :style="stageData.minimum_height ? { 'min-height': `${stageData.minimum_height}px` } : null"
            >
              <div class="container">
                <h2
                  v-if="slide.title"
                  class="text-center mb-2"
                >
                  {{ slide.title }}
                </h2>
                <div
                  v-if="slide.subline"
                  class="text-base text-center mb-8"
                >
                  {{ slide.subline }}
                </div>
                <div
                  v-if="slide.button.label"
                  class="text-center"
                >
                  <router-link
                    class="button--primary shadow-hard-dark text-white"
                    tag="apo-button"
                    :to="slide.button.url"
                  >
                    {{ slide.button.label }}
                  </router-link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </vue-glide-slide>
      <template
        v-if="stageData.slides.length > 1"
        slot="control"
      >
        <button
          class="prev"
          data-glide-dir="<"
        >
          <apo-icon
            class="arrow w-16 h-16"
            src="chevron"
          />
        </button>
        <button
          class="next"
          data-glide-dir=">"
        >
          <apo-icon
            class="arrow w-16 h-16"
            src="chevron"
          />
        </button>
      </template>
    </vue-glide>
  </div>
</template>

<script>

import { Glide, GlideSlide } from 'vue-glide-js';
import 'vue-glide-js/dist/vue-glide.css';

export default {
  components: {
    [Glide.name]: Glide,
    [GlideSlide.name]: GlideSlide,
  },

  props: {
    stageData: {
      type: Object,
      required: true,
    },
  },

  computed: {
    minHeight() {
      return this.stageData.minimum_height ? { 'min-height': `${this.stageData.minimum_height}px` } : null;
    },
  },
};

</script>

<style lang="scss">

.stage-container {
  background: linear-gradient(45deg, theme('colors.blue.700'), theme('colors.blue.500'));
  color: white;

  .theme-survey & {
    background: linear-gradient(120deg, theme('colors.orange.600'), theme('colors.yellow.500'));
  }

  .theme-training & {
    background: linear-gradient(45deg, theme('colors.training.500'), theme('colors.training.200'));
  }

  .theme-knowledge-base &,
  .theme-downloads & {
    background: linear-gradient(120deg, theme('colors.purple.400'), theme('colors.purple.300'));
  }

  .theme-raffle & {
    background: linear-gradient(120deg, theme('colors.green.400'), theme('colors.green.200'));
  }

  .slider {
    .glide__slides {
      align-items: center;
    }
  }
}

.slide-inner-container {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 64px 0;

  @media (min-width: theme('screens.desktop')) {
    padding: 144px 0;
  }

  .container {
    padding-left: 4rem;
    padding-right: 4rem;

    @media (min-width: theme('screens.desktop')) {
      padding-left: 6rem;
      padding-right: 6rem;
    }
  }
}

.controls-container {
  position: absolute;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
}

.prev {
  color: white;
  position: absolute;
  left: 0;
  top: 50%;
  transform: translateY(-50%);

  @media (min-width: theme('screens.desktop')) {
    left: 50%;
    margin-left: -28rem;
    transform: translate(-100%, -50%);
  }

  &:focus {
    outline: none;
  }

  .arrow {
    transform-origin: center center;
    transform: rotate(90deg);
  }
}

.next {
  color: white;
  position: absolute;
  right: 0;
  top: 50%;
  transform: translateY(-50%);

  @media (min-width: theme('screens.desktop')) {
    right: 50%;
    margin-right: -28rem;
    transform: translate(100%, -50%);
  }

  &:focus {
    outline: none;
  }

  .arrow {
    transform-origin: center center;
    transform: rotate(-90deg);
  }
}

.slide,
.slide-style-container,
.slide-inner-container {
  min-height: 380px;

  @media (max-width: theme('screens.desktop')) {
    min-height: 380px !important;
  }
}

</style>
