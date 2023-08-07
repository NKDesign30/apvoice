<template>
  <div class="situational-cases__conversation my-15">
    <div class="relative mb-8 situational-cases__background-image">
      <apo-situational-cases-conversation-speech-bubble
        v-if="showPharmacistSpeechBubble"
        :text="speechBubbles.pharmacist"
        class="situational-cases__speech-bubble--pharmacist"
      />
      <apo-situational-cases-conversation-speech-bubble
        v-if="showCustomerSpeechBubble"
        :text="speechBubbles.customer"
        direction="left"
        class="situational-cases__speech-bubble--customer"
      />
      <img
        :src="image"
        :alt="alt"
        class="w-full h-auto"
      >
    </div>

    <div class="p-8 flex flex-wrap border-t-4 border-l-4 situational-cases__mobile-dialog border-training-500 rounded-tl-4xl tablet:hidden">
      <apo-situational-cases-conversation-mobile-dialog-item
        v-if="showPharmacistSpeechBubble"
        :avatar="pharmacistAvatar"
        :text="speechBubbles.pharmacist"
      />

      <apo-situational-cases-conversation-mobile-dialog-item
        v-if="showCustomerSpeechBubble"
        :avatar="customerAvatar"
        :text="speechBubbles.customer"
        reverse
        :class="firstSpeaker === 'Customer' ? 'order-first mb-8' : 'mt-8'"
      />
    </div>
  </div>
</template>

<script>

import get from 'lodash/get';
import SituationalCasesConversationMobileDialogItem from '@/components/content/situational-cases/situational-cases-conversation/SitualCasesConversationMobileDialogItem.vue';
import SituationalCasesConversationSpeechBubble from '@/components/content/situational-cases/situational-cases-conversation/SituationalCasesConversationSpeechBubble.vue';

export default {

  components: {
    'apo-situational-cases-conversation-mobile-dialog-item': SituationalCasesConversationMobileDialogItem,
    'apo-situational-cases-conversation-speech-bubble': SituationalCasesConversationSpeechBubble,
  },

  props: {
    backgroundImage: {
      type: Object,
      required: true,
    },
    firstSpeaker: {
      type: String,
      required: true,
    },
    speechBubbles: {
      type: Object,
      required: true,
    },
    avatars: {
      type: Object,
      required: true,
    },
    startTimeout: {
      type: Boolean,
      required: true,
      default: false,
    },
  },

  data() {
    return {
      showPharmacistSpeechBubble: this.firstSpeaker === 'Pharmacist',
      showCustomerSpeechBubble: this.firstSpeaker === 'Customer',
      secondSpeechBubbleTimeout: null,
    };
  },

  computed: {
    pharmacistAvatar() {
      return get(this.avatars, 'pharmacist.sizes.thumbnail', '');
    },
    customerAvatar() {
      return get(this.avatars, 'customer.sizes.thumbnail', '');
    },
    image() {
      return get(this.backgroundImage, 'sizes.post-thumbnail', '');
    },
    alt() {
      return get(this.backgroundImage, 'alt', '');
    },
  },

  watch: {
    startTimeout: {
      handler(isVisible) {
        if (isVisible) {
          this.secondSpeechBubbleTimeout = setTimeout(() => {
            if (this.firstSpeaker === 'Pharmacist') {
              this.showCustomerSpeechBubble = true;
            } else {
              this.showPharmacistSpeechBubble = true;
            }
          }, 1000);
        }
      },
    },
  },

  destroyed() {
    clearTimeout(this.secondSpeechBubbleTimeout);
  },
};
</script>

<style lang="scss" scoped>
  .rounded-tl-4xl {
    border-top-left-radius: 4rem;
  }

  .situational-cases {

    &__speech-bubble {

      &--pharmacist {
        top: 10%;
        left: 5%;
      }

      &--customer {
        top: 17%;
        right: 5%;
      }

    }
  }
</style>
