<template>
  <div class="profile-picture">
    <div
      class="profile-picture-wrapper"
      :class="{
        'flex justify-center items-center': isLoading,
        [imageClass]: true,
      }"
    >
      <apo-spinner
        v-if="isLoading"
        size="small"
      />
      <img
        v-else
        :alt="$t('pages.profile.pictureCaption', { name: fullName })"
        class="profile-picture-image"
        :src="profilePicture"
        v-bind="$attrs"
      >
    </div>

    <button
      v-if="isEditable"
      class="mt-2 underline text-gray-900 relative"
      type="button"
    >
      <span v-text="$t('pages.profile.changePicture')" />
      <input
        ref="picture"
        class="absolute left-0 top-0 opacity-0 cursor-pointer"
        type="file"
        @change="onFileChanged"
      >
    </button>
  </div>
</template>

<script>

import { readInputFile } from '@/services/utils';

export default {
  props: {
    user: {
      type: Object,
      default() {
        return {
          profilePicture: {},
          firstName: '',
          lastName: '',
        };
      },
    },

    imageClass: {
      type: String,
      default: '',
    },

    placeholderImage: {
      type: String,
      default: '/assets/img/user/no-profile-picture.png',
    },

    isEditable: {
      type: Boolean,
      default: false,
    },
  },

  data() {
    return {
      profilePicture: '',
      isLoading: true,
    };
  },

  computed: {
    fullName() {
      return `${this.user.firstName} ${this.user.lastName}`;
    },
  },

  methods: {
    onFileChanged(event) {
      this.renderProfilePicturePreview();

      this.$emit('input', event);
    },

    async renderProfilePicturePreview() {
      if (!this.$refs.picture.files || this.$refs.picture.files.length === 0) {
        return;
      }

      this.profilePicture = await readInputFile(this.$refs.picture.files[0]);
    },
  },

  created() {
    const imageToLoad = this.user.profilePicture['250'] || this.user.profilePicture.full || this.placeholderImage;

    const img = new Image();

    img.onload = () => {
      this.profilePicture = imageToLoad;
      this.isLoading = false;
    };

    img.onerror = () => {
      this.profilePicture = this.placeholderImage;
      this.isLoading = false;
    };

    img.src = imageToLoad;
  },
};

</script>

<style lang="scss" scoped>

.profile-picture {
  @apply inline-flex;
  @apply flex-col;
  @apply items-center;

  &-wrapper {
    @apply rounded-full;
    @apply border-10;
    @apply border-white;
    @apply w-32;
    @apply h-32;

    box-shadow: 0 4px 0 1px rgba(0, 0, 0,0.2), inset 0 1px 60px rgba(0, 0, 0, 0.35);
  }

  &-image {
    @apply rounded-full;
    @apply w-full;
    @apply h-full;
  }
}

/deep/ .vue-simple-spinner {
  border-color:
    transparent
    theme('colors.white')
    theme('colors.white')
    #{!important};
  }

</style>
