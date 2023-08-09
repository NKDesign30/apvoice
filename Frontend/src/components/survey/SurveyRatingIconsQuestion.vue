<template>
  <div class="survey-rating-question">
    <div class="text-center survey-rating-question__headlines">
      <h4
        class="text-3xl text-gray-900"
        v-html="$options.filters.formatContent(question)"
      />
      <p
        v-if="subheadline"
        class="mt-2 italic text-gray-700 text-lg"
        v-html="$options.filters.formatContent(subheadline)"
      />
    </div>

    <apo-survey-optional-hint v-if="isOptional" />

    <div class="flex flex-wrap justify-center text-center my-4">
      <div
        v-for="index in 5"
        :key="index"
        class="flex flex-col flex-wrap justify-center"
      >
        <div
          class="flex justify-around flex-auto"
        >
          <!-- eslint-disable max-len -->
          <label
            class="survey-rating-question-label rating-icons"
            :class=" value >= index ? ratingType + ' is-active' : ratingType"
            :title="index"
            @mouseover="onHover(index)"
            @mouseleave="onHover(0)"
          >
            <!-- eslint-enablde max-len -->
            <input
              :id="index"
              class="w-full h-full cursor-pointer"
              :name="`survey-question-${id}`"
              type="radio"
              :value="index"
              @change="$emit('input', ''+index)"
            >

            <div
              class="survey-rating-question-number"
              v-html="getIcon(ratingType, (value >= index || hoveredOption >= index), index)"
            />
          </label>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import SurveyOptionalHint from '@/components/survey/SurveyOptionalHint.vue';

export default {
  components: {
    'apo-survey-optional-hint': SurveyOptionalHint,
  },

  props: {
    value: {
      type: String,
      required: true,
    },

    id: {
      type: String,
      required: true,
    },

    question: {
      type: String,
      required: true,
    },

    subheadline: {
      type: String,
      required: false,
      default: '',
    },

    isOptional: {
      type: Boolean,
      default: false,
    },

    ratingType: {
      type: String,
      required: true,
    },
  },

  data() {
    return {
      selectedOption: '',
      hoveredOption: '',
    };
  },
  methods: {
    onHover(index) {
      this.hoveredOption = index;
    },

    getIcon(type, isActive, index) {
      let icon = '';
      if (type === 'stars') {
        if (isActive) {
          icon = '<svg version="1.1" width="40" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 40 40" fill="currentcolor" xml:space="preserve"><path d="M39.6,16.8l-9.1,8.5l2.4,12.2c0.1,0.7-0.3,1.4-1.1,1.6c-0.1,0-0.2,0-0.3,0c-0.2,0-0.5-0.1-0.7-0.2l-10.8-6l-10.9,6 c-0.7,0.4-1.5,0.1-1.8-0.5c-0.2-0.3-0.2-0.6-0.1-0.9l2.4-12.2l-9.1-8.5c-0.5-0.5-0.6-1.4-0.1-1.9c0.2-0.2,0.5-0.4,0.8-0.4L13.5,13l5.2-11.3C19,1.2,19.5,0.9,20,0.9s1,0.3,1.2,0.8L26.5,13l12.4,1.5c0.7,0.1,1.3,0.8,1.2,1.5C40,16.3,39.8,16.6,39.6,16.8z"/></svg>';
        } else {
          icon = '<svg version="1.1" width="40" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 40 40" fill="currentcolor" xml:space="preserve"><path d="M30.8,39.2C30.7,39.2,30.7,39.2,30.8,39.2c-0.5,0-0.9-0.1-1.3-0.3L20,33.5l-9.6,5.3c-1.2,0.7-2.8,0.2-3.4-1c-0.3-0.5-0.4-1.1-0.3-1.7l2.1-10.8l-8-7.5c-0.5-0.4-0.8-1-0.8-1.7c0-0.7,0.2-1.3,0.7-1.8c0.4-0.4,1-0.7,1.6-0.8l10.9-1.3l4.6-9.9C18.1,1.4,19,0.9,20,0.8c1,0,1.9,0.6,2.3,1.5l4.6,9.9l10.9,1.3c0.7,0.1,1.3,0.4,1.7,1s0.6,1.2,0.5,1.9c-0.1,0.6-0.4,1.1-0.8,1.6l-8,7.4l2.1,10.7c0.1,0.7,0,1.3-0.4,1.9c-0.4,0.6-1,0.9-1.6,1.1C31.1,39.1,30.9,39.2,30.8,39.2zM20,30.6l10.7,6l-2.3-12.1l9.1-8.4l0.9,0.9l-0.9-0.9l0,0l-12.3-1.5L20,3.4l-5.2,11.2L2.5,16l9,8.4L9.2,36.6L20,30.6z"/></svg>';
        }
      }
      if (type === 'hearts') {
        if (isActive) {
          icon = '<svg version="1.1" width="40" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 40 40" fill="currentcolor" xml:space="preserve"><path d="M20,37L20,37c-0.2,0-0.4-0.1-0.6-0.2c-0.5-0.4-13.2-9.4-17.8-17l0,0c-1-1.7-1.6-3.7-1.6-5.7C0,8,5,3,11.1,3c3.5,0,6.8,1.7,8.9,4.5C22.1,4.7,25.4,3,28.9,3C35,3,40,8,40,14.1c0,2-0.5,4-1.6,5.7l0,0c-4.7,7.6-17.3,16.6-17.8,17C20.4,36.9,20.2,37,20,37z"/></svg>';
        } else {
          icon = '<svg version="1.1" width="40" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 40 40" fill="currentcolor" xml:space="preserve"><path d="M20,37.2L20,37.2c-0.4,0-0.8-0.1-1.2-0.4c-0.5-0.4-12.7-9-17.2-16.4l0,0c-1.1-1.8-1.6-3.8-1.6-6C0,8,5.2,2.8,11.6,2.8c3.2,0,6.3,1.3,8.4,3.7c2.2-2.3,5.2-3.7,8.4-3.7C34.8,2.8,40,8,40,14.4c0,2.1-0.6,4.2-1.7,6l0,0c-4.5,7.4-16.6,16-17.2,16.4C20.8,37,20.4,37.2,20,37.2L20,37.2z M19.9,35.1L19.9,35.1L19.9,35.1z M11.6,5c-5.2,0-9.5,4.2-9.5,9.5c0,1.7,0.5,3.4,1.4,4.9C7.7,26.1,19,34.3,20,35c1.1-0.8,12.3-8.9,16.5-15.7c0.9-1.5,1.4-3.2,1.4-4.9c0-5.2-4.2-9.5-9.5-9.5c-3,0-5.8,1.4-7.6,3.8L20,9.9l-0.8-1.1C17.4,6.4,14.5,5,11.6,5z"/></svg>';
        }
      }
      if (type === 'thumbs_up') {
        if (isActive) {
          icon = '<svg version="1.1" width="40" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 40 40" fill="currentcolor" xml:space="preserve"><path d="M3.2,13.8c-1.3,0-2.4,1.1-2.4,2.4v21.3c0,1.3,1.1,2.4,2.4,2.4h7.1c1.3,0,2.3-1,2.4-2.3l1.5,0.9c1.4,0.9,3.1,1.3,4.8,1.3h10.3c1.2,0,2.5-0.2,3.6-0.7c3.3-1.5,3.8-4,3.6-5.7c1.7-1.5,2.4-3.8,1.6-6c0.8-1,1.2-2.2,1.2-3.5c-0.1-1-0.4-2-1-2.8c0.8-1.8,0.3-3.8-1.1-5.1c-0.1-0.1-0.2-0.2-0.3-0.3c-0.6-0.4-1.2-0.7-1.9-0.8h-0.1c-3.2-0.7-5.4-0.7-8.6-0.7c-0.1-0.7-0.1-2.3,0.8-5.2c0.9-2.7,0.8-4.9-0.2-6.6C26,1.1,24.6,0.2,23,0h-0.2c-1.1,0-2.2,0.7-2.5,1.8c0,0.1,0,0.1,0,0.2l-0.4,2.6c-0.1,0.8-0.3,1.6-0.7,2.3l-3.6,7.5c-0.5,1.2-1.7,2.2-3,2.4v-0.6c0-1.3-1.1-2.4-2.4-2.4C10.2,13.8,3.2,13.8,3.2,13.8z M3.2,37.6V16.2h7.1v21.3L3.2,37.6L3.2,37.6z"/><circle cx="6.7" cy="33.8" r="1.5"/></svg>';
        } else {
          icon = '<svg version="1.1" width="40" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 40 40" fill="currentcolor" xml:space="preserve"><path d="M3.2,13.8c-1.3,0-2.4,1.1-2.4,2.4v21.3c0,1.3,1.1,2.4,2.4,2.4h7.1c1.3,0,2.3-1,2.4-2.3l1.5,0.9c1.4,0.9,3.1,1.3,4.8,1.3h10.3c1.2,0,2.5-0.2,3.6-0.7c3.3-1.5,3.8-4,3.6-5.7c1.7-1.5,2.4-3.8,1.6-6c0.8-1,1.2-2.2,1.2-3.5c-0.1-1-0.4-2-1-2.8c0.8-1.8,0.3-3.8-1.1-5.1c-0.1-0.1-0.2-0.2-0.3-0.3c-0.6-0.4-1.2-0.7-1.9-0.8h-0.1c-3.2-0.7-5.4-0.7-8.6-0.7c-0.1-0.7-0.1-2.3,0.8-5.2c0.9-2.7,0.8-4.9-0.2-6.6C26,1.1,24.6,0.2,23,0h-0.2c-1.1,0-2.2,0.7-2.5,1.8c0,0.1,0,0.1,0,0.2l-0.4,2.6c-0.1,0.8-0.3,1.6-0.7,2.3l-3.6,7.5c-0.5,1.2-1.7,2.2-3,2.4v-0.6c0-1.3-1.1-2.4-2.4-2.4C10.2,13.8,3.2,13.8,3.2,13.8z M3.2,37.6V16.2h7.1v21.3L3.2,37.6L3.2,37.6z M12.9,19.3c2.2-0.4,4-1.9,4.9-3.9L21.3,8c0.4-0.9,0.7-2,0.9-3l0.4-2.5c0,0,0,0,0.1,0c0.9,0.1,1.6,0.6,2.1,1.4c0.6,1,0.6,2.6,0,4.6c-0.9,2.8-1.2,5.1-0.9,6.7c0.2,1,1.1,1.7,2.2,1.7l0,0c3.2,0,5.2,0,8.3,0.7l0,0c0.3,0.1,0.6,0.2,0.9,0.4l0.2,0.1c1.2,1.1,0.5,2.6,0.3,2.8c-0.3,0.5-0.2,1.2,0.2,1.6c0.5,0.5,0.8,1.1,0.8,1.8c0,0.9-0.4,1.8-1.1,2.4c-0.4,0.4-0.4,1-0.2,1.5c0.1,0.1,1.3,2.3-1.2,4.1c-0.4,0.3-0.6,0.9-0.4,1.4c0.1,0.4,0.6,2.4-2,3.6c-0.8,0.4-1.8,0.5-2.7,0.5H18.9c-1.2,0-2.4-0.3-3.5-1l-2.7-1.6V19.3H12.9z"/><circle cx="6.7" cy="33.8" r="1.5"/></svg>';
        }
      }
      if (type === 'smileys') {
        switch (index) {
          case 1:
            if (isActive) {
              icon = '<svg version="1.1" width="40" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 40 40" fill="#E72D4B" xml:space="preserve"><path d="M20,40C9,40,0,31,0,20S9,0,20,0s20,9,20,20S31,40,20,40z M20,2.2c-9.8,0-17.8,8-17.8,17.8s8,17.8,17.8,17.8s17.8-8,17.8-17.8S29.8,2.2,20,2.2z"/><path d="M20,4.3c-8.6,0-15.7,7-15.7,15.7s7,15.7,15.7,15.7s15.7-7,15.7-15.7S28.6,4.3,20,4.3z M10.6,14.7c0-1.6,1.3-2.9,2.9-2.9s2.9,1.3,2.9,2.9s-1.3,2.9-2.9,2.9C11.9,17.6,10.6,16.3,10.6,14.7z M12.2,30.3c0-4.3,3.5-7.8,7.8-7.8s7.8,3.5,7.8,7.8H12.2zM26.5,17.6c-1.6,0-2.9-1.3-2.9-2.9s1.3-2.9,2.9-2.9s2.9,1.3,2.9,2.9S28.1,17.6,26.5,17.6z"/></svg>';
            } else {
              icon = '<svg version="1.1" width="40" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 40 40" fill="#E72D4B" xml:space="preserve"><path d="M20,40C9,40,0,31,0,20S9,0,20,0s20,9,20,20S31,40,20,40z M20,2.2c-9.8,0-17.8,8-17.8,17.8s8,17.8,17.8,17.8s17.8-8,17.8-17.8S29.8,2.2,20,2.2z"/><path d="M12.2,30.3c0-4.3,3.5-7.8,7.8-7.8s7.8,3.5,7.8,7.8"/><circle cx="13.5" cy="14.7" r="2.9"/><circle cx="26.5" cy="14.7" r="2.9"/></svg>';
            }
            break;
          case 2:
            if (isActive) {
              icon = '<svg version="1.1" width="40" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 40 40" fill="#FF7000" xml:space="preserve"><path d="M20,40C9,40,0,31,0,20S9,0,20,0s20,9,20,20S31,40,20,40z M20,2.2c-9.8,0-17.8,8-17.8,17.8s8,17.8,17.8,17.8s17.8-8,17.8-17.8S29.8,2.2,20,2.2z"/><path d="M20,4.3c-8.6,0-15.7,7-15.7,15.7s7,15.7,15.7,15.7s15.7-7,15.7-15.7S28.6,4.3,20,4.3z M10.6,14.7c0-1.6,1.3-2.9,2.9-2.9s2.9,1.3,2.9,2.9s-1.3,2.9-2.9,2.9C11.9,17.6,10.6,16.3,10.6,14.7z M12.2,28.3c0-2.1,3.5-3.9,7.8-3.9s7.8,1.7,7.8,3.9H12.2zM26.5,17.6c-1.6,0-2.9-1.3-2.9-2.9s1.3-2.9,2.9-2.9s2.9,1.3,2.9,2.9S28.1,17.6,26.5,17.6z"/></svg>';
            } else {
              icon = '<svg version="1.1" width="40" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 40 40" fill="#FF7000" xml:space="preserve"><path d="M20,40C9,40,0,31,0,20S9,0,20,0s20,9,20,20S31,40,20,40z M20,2.2c-9.8,0-17.8,8-17.8,17.8s8,17.8,17.8,17.8s17.8-8,17.8-17.8S29.8,2.2,20,2.2z"/><path d="M12.2,28.3c0-2.1,3.5-3.9,7.8-3.9s7.8,1.7,7.8,3.9"/><circle cx="13.5" cy="14.7" r="2.9"/><circle cx="26.5" cy="14.7" r="2.9"/></svg>';
            }
            break;
          case 3:
            if (isActive) {
              icon = '<svg version="1.1" width="40" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 40 40" fill="#FFB80F" xml:space="preserve"><path d="M20,40C9,40,0,31,0,20S9,0,20,0s20,9,20,20S31,40,20,40z M20,2.2c-9.8,0-17.8,8-17.8,17.8s8,17.8,17.8,17.8s17.8-8,17.8-17.8S29.8,2.2,20,2.2z"/><path d="M20,4.3c-8.6,0-15.7,7-15.7,15.7s7,15.7,15.7,15.7s15.7-7,15.7-15.7S28.7,4.3,20,4.3z M13.5,11.8c1.6,0,2.9,1.3,2.9,2.9s-1.3,2.9-2.9,2.9s-2.9-1.3-2.9-2.9S11.9,11.8,13.5,11.8z M27.5,26.7H12.2c-0.5,0-0.9-0.4-0.9-0.9s0.4-0.9,0.9-0.9h15.3c0.5,0,0.9,0.4,0.9,0.9C28.4,26.3,28,26.7,27.5,26.7z M26.5,17.6c-1.6,0-2.9-1.3-2.9-2.9s1.3-2.9,2.9-2.9s2.9,1.3,2.9,2.9S28.1,17.6,26.5,17.6z"/></svg>';
            } else {
              icon = '<svg version="1.1" width="40" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 40 40" fill="#FFB80F" xml:space="preserve"><path d="M20,40C9,40,0,31,0,20S9,0,20,0s20,9,20,20S31,40,20,40z M20,2.2c-9.8,0-17.8,8-17.8,17.8s8,17.8,17.8,17.8s17.8-8,17.8-17.8S29.8,2.2,20,2.2z"/><circle cx="13.5" cy="14.7" r="2.9"/><circle cx="26.5" cy="14.7" r="2.9"/><line fill="none" x1="12.2" y1="25.8" x2="27.5" y2="25.8"/><path d="M27.5,27H12.2c-0.6,0-1.1-0.5-1.1-1.1s0.5-1.1,1.1-1.1h15.3c0.6,0,1.1,0.5,1.1,1.1S28.1,27,27.5,27z"/></svg>';
            }
            break;
          case 4:
            if (isActive) {
              icon = '<svg version="1.1" width="40" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 40 40" fill="#9BD442" xml:space="preserve"><path d="M20,40C9,40,0,31,0,20S9,0,20,0s20,9,20,20S31,40,20,40z M20,2.2c-9.8,0-17.8,8-17.8,17.8s8,17.8,17.8,17.8s17.8-8,17.8-17.8S29.8,2.2,20,2.2z"/><path d="M20,4.3c-8.6,0-15.7,7-15.7,15.7s7,15.7,15.7,15.7c8.6,0,15.7-7,15.7-15.7S28.6,4.3,20,4.3z M10.6,14.7c0-1.6,1.3-2.9,2.9-2.9s2.9,1.3,2.9,2.9s-1.3,2.9-2.9,2.9C11.9,17.6,10.6,16.3,10.6,14.7z M20,28.3c-4.3,0-7.8-1.7-7.8-3.9h15.6C27.8,26.6,24.3,28.3,20,28.3z M26.5,17.6c-1.6,0-2.9-1.3-2.9-2.9s1.3-2.9,2.9-2.9s2.9,1.3,2.9,2.9S28.1,17.6,26.5,17.6z"/></svg>';
            } else {
              icon = '<svg version="1.1" width="40" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 40 40" fill="#9BD442" xml:space="preserve"><path d="M20,40C9,40,0,31,0,20S9,0,20,0s20,9,20,20S31,40,20,40z M20,2.2c-9.8,0-17.8,8-17.8,17.8s8,17.8,17.8,17.8s17.8-8,17.8-17.8S29.8,2.2,20,2.2z"/><path d="M27.8,24.4c0,2.1-3.5,3.9-7.8,3.9s-7.8-1.7-7.8-3.9"/><circle cx="13.5" cy="14.7" r="2.9"/><circle cx="26.5" cy="14.7" r="2.9"/></svg>';
            }
            break;
          case 5:
          default:
            if (isActive) {
              icon = '<svg version="1.1" width="40" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 40 40" fill="#00B041" xml:space="preserve"><path d="M20,40C9,40,0,31,0,20S9,0,20,0s20,9,20,20S31,40,20,40z M20,2.2c-9.8,0-17.8,8-17.8,17.8s8,17.8,17.8,17.8s17.8-8,17.8-17.8S29.8,2.2,20,2.2z"/><path d="M20,4.3c-8.6,0-15.7,7-15.7,15.7s7,15.7,15.7,15.7s15.7-7,15.7-15.7S28.6,4.3,20,4.3z M10.6,14.7c0-1.6,1.3-2.9,2.9-2.9s2.9,1.3,2.9,2.9s-1.3,2.9-2.9,2.9S10.6,16.3,10.6,14.7z M20,30.3c-4.3,0-7.8-3.5-7.8-7.8h15.6C27.8,26.8,24.3,30.3,20,30.3zM26.5,17.6c-1.6,0-2.9-1.3-2.9-2.9s1.3-2.9,2.9-2.9s2.9,1.3,2.9,2.9S28.1,17.6,26.5,17.6z"/></svg>';
            } else {
              icon = '<svg version="1.1" width="40" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 40 40" fill="#00B041" xml:space="preserve"><path d="M20,40C9,40,0,31,0,20S9,0,20,0s20,9,20,20S31,40,20,40z M20,2.2c-9.8,0-17.8,8-17.8,17.8s8,17.8,17.8,17.8s17.8-8,17.8-17.8S29.8,2.2,20,2.2z"/><path d="M27.8,22.5c0,4.3-3.5,7.8-7.8,7.8s-7.8-3.5-7.8-7.8"/><circle cx="13.5" cy="14.7" r="2.9"/><circle cx="26.5" cy="14.7" r="2.9"/></svg>';
            }
            break;
        }
      }
      return icon;
    },
  },
};

</script>

<style lang="scss" scoped>

@import '../../assets/scss/utilities';

.survey-rating-question {
  @apply w-full;
  width: 270px;

  &-label {
    @apply border-gray-700;
    @apply block;
    @apply border-4;
    @apply cursor-pointer;
    @apply h-12;
    @apply overflow-hidden;
    @apply relative;
    @apply w-12;

    @extend .transition-border-color;
    @extend .transition-ease;
    @extend .transition-fast;

    &.rating-icons{
      border: none;
      background: none;

      &.stars{
        color: #FFB80F;
      }

      &.hearts{
        color: #E72D4B;
      }

      &.thumbs_up{
        color: #3C3C3B;
      }
    }
  }

  &-number {
    @apply absolute;
    @apply bg-white;
    @apply border-5;
    @apply border-white;
    @apply flex;
    @apply h-full;
    @apply items-center;
    @apply left-0;
    @apply justify-center;
    @apply text-xl;
    @apply top-0;
    @apply w-full;

    @extend .transition-fast;
    @extend .transition-ease;
    @extend .transition-background-color;
  }

  .survey-cluster-question &{

    &__headlines{
      h4{
        @apply text-xl;
      }
      p{
        @apply mt-0;
      }
    }
  }
}

</style>
