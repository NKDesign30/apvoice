<template>
  <div
    class="accordion"
    :class="{'is-open': isOpen, 'is-checked': isChecked}"
    @click="toggle()"
  >
    <div class="accordion-title">
      <div
        class="accordion-container container font-display"
        v-html="$options.filters.formatContent(title)"
      />
    </div>
    <div class="accordion-content">
      <div
        class="accordion-container container"
        v-html="$options.filters.formatContent(content)"
      />
    </div>
  </div>
</template>

<script>

export default {
  props: {
    title: {
      type: String,
      required: true,
    },

    content: {
      type: String,
      required: false,
      default: '',
    },

    open: {
      type: Boolean,
      required: false,
      default: false,
    },

    checked: {
      type: Boolean,
      required: false,
      default: false,
    },
  },


  data() {
    return {
      isOpen: this.open,
      isChecked: this.checked,
      events: {
        open: 'apo-accordion-opened',
      },
    };
  },

  watch: {
    isOpen(val) {
      if (val) {
        window.eventBus.$emit(this.events.open, this.$el);

        this.$el.scrollIntoView({
          behavior: 'smooth',
        });
      }
    },
  },

  methods: {
    close() {
      if (this.isOpen) {
        this.isChecked = true;
      }

      this.isOpen = false;
    },

    toggle() {
      this.isOpen = !this.isOpen;

      if (!this.isOpen) {
        this.isChecked = true;
      }
    },
  },

  mounted() {
    window.eventBus.$on(this.events.open, el => {
      if (el !== this.$el) {
        this.close();
      }
    });
  },
};
</script>

<style lang="scss" scoped>
  .accordion {
    @apply w-full;

    & + .accordion {
      @apply mt-4;
    }

    &-title {
      @apply bg-green-100;
      @apply cursor-pointer;

      .accordion-container {
        @apply relative;
        @apply pl-12;
        @apply py-2;
        @apply text-3xl;

        &::before {
          @apply absolute;
          @apply -mt-2;
          @apply -ml-12;
          @apply w-8;
          @apply h-full;
          @apply bg-contain;
          @apply bg-center;
          @apply bg-no-repeat;

          content: "";
          background-image: url("../../assets/svg/radio.svg");
        }

        .is-checked & {
          &::before {
            background-image: url("../../assets/svg/radio_checked.svg");
          }
        }
      }
    }

    .accordion-content {
      @apply overflow-hidden;

      max-height: 0;
      transition: max-height .25s, padding .25s;

      .accordion-container {
        @apply py-2;
      }
    }

    &.is-open {
      .accordion-content {
        max-height: 100%;
      }
    }

    &-container {
      @apply mx-auto;
    }
  }
</style>
