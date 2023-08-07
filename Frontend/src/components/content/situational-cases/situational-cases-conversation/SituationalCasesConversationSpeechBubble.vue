<template>
  <div
    ref="speechBubble"
    class="situational-cases__speech-bubble absolute bg-gray-900 p-5 rounded-lg text-white z-10 hidden tablet:block"
  >
    <span
      class="situational-cases__dialog-arrow absolute bg-gray-900"
      :style="directionStyle"
    />
    <span v-html="$options.filters.formatContent(text)" />
  </div>
</template>

<script>
export default {
  props: {
    text: {
      type: String,
      required: true,
    },
    direction: {
      type: String,
      required: false,
      default: 'right',
    },
  },
  computed: {
    directionStyle() {
      return `${this.direction}: -2%`;
    },
  },
};
</script>

<style lang="scss" scoped>

  .situational-cases {
    &__speech-bubble {
      width: 30%;
      min-height: 25%;
    }

    &__dialog-arrow{
      top: 35%;
      width: 50px;
      height: 50px;
      transform: rotate(45deg);
      z-index: -1;
    }

    @media only screen and (min-width: 950px) {
      &__dialog-arrow{
        top: 44%;
      }
    }

   .situational-cases__speech-bubble {
      &--pharmacist {
        .situational-cases__dialog-arrow{

        }
      }

      &--customer {
          .situational-cases__dialog-arrow{
            top: 20%;
          }
         @media only screen and (min-width: 950px) {
            .situational-cases__dialog-arrow{
              top: 44%;
            }
          }
      }
    }
  }
</style>
