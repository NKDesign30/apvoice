<template>
  <div>
    <apo-wait for="raffle">
      <template #waiting>
        <apo-loading-overlay
          class="my-15"
          :message="$t('loaders.raffle')"
        />
      </template>
      <apo-not-found-page v-if="isOverview" />
      <div v-else>
        <div v-if="raffleDetail">
          <apo-stage
            v-if="stage"
            :stage-data="stage"
          />
          <component
            :is="`apo-cms-${renderer}-renderer`"
            v-for="(components, renderer) in content"
            :key="`${renderer}-renderer`"
            :components="components || []"
          />
          <div v-if="participationCheck">
            <form
              v-if="
                !submitSuccessful &&
                  (!hasParticipated ||
                  raffleDetail.configuration.participation === 'Several times') &&
                  !participationLimitReached &&
                  !raffleExpired
              "
              ref="submitForm"
              @submit.prevent="submit"
            >
              <div
                v-if="contest"
                class="py-10"
              >
                <div class="container">
                  <div
                    v-if="contest.headline"
                    class="text-center mb-4"
                  >
                    {{ contest.headline }}
                  </div>
                  <div class="choice-container">
                    <div
                      v-if="contest.type === 'Choice'"
                      class="flex items-center justify-center flex-wrap"
                    >
                      <label
                        v-for="choice in contest.choices"
                        :key="choice.choice"
                        :for="choice.choice"
                        class="choice-label"
                        :class="{ 'is-active': choice.choice === selectedChoice }"
                        :title="choice.choice"
                      >
                        <input
                          :id="choice.choice"
                          v-model="selectedChoice"
                          class="h-full w-full cursor-pointer"
                          name="contest"
                          type="radio"
                          :value="choice.choice"
                          required
                        >

                        <div
                          class="choice-text"
                          v-text="choice.choice"
                        />
                      </label>
                    </div>
                    <div
                      v-else-if="contest.type === 'Text Input'"
                      class="w-full"
                    >
                      <apo-textarea
                        class="mt-4 w-full h-40"
                        :maxlength="-1"
                        name="contest"
                        :value="textInput"
                        required
                        @input="onTextInputChange"
                      />
                    </div>
                    <div
                      v-else-if="contest.type === 'Upload'"
                      class="flex flex-col items-center justify-center"
                    >
                      <apo-icon
                        class="w-16 h-16 mb-8"
                        src="upload"
                      />
                      <apo-button
                        class="button button--primary button--tiny shadow-hard relative
                               cursor-pointer"
                      >
                        <span
                          class="cursor-pointer"
                          v-text="$t('raffle.chooseFile')"
                        />
                        <input
                          ref="fileUpload"
                          class="absolute left-0 top-0 opacity-0 w-full h-full cursor-pointer"
                          type="file"
                          name="contest"
                          required
                          @change="onUploadFileChange"
                        >
                      </apo-button>
                      <div
                        v-if="fileName"
                        class="my-6"
                      >
                        <span>{{ fileName }}</span>
                        <apo-icon
                          class="delete w-3 h-3 ml-2 cursor-pointer"
                          src="close"
                          @click="resetFile"
                        />
                      </div>
                      <div
                        v-if="uploadError"
                        class="container text-center"
                      >
                        <p
                          class="text-red-500"
                          v-text="$t('raffle.uploadFormat')"
                        />
                      </div>
                    </div>
                    <div
                      v-else
                    >
                      <input
                        type="hidden"
                        name="contest"
                        value=""
                      >
                    </div>
                  </div>
                </div>
              </div>
              <div
                v-if="form.inputfields.length > 0 || form.checkboxes.length > 0"
                class="container py-10"
              >
                <div class="w-full tablet:flex tablet:justify-between tablet:flex-wrap">
                  <div
                    v-for="inputfield in form.inputfields"
                    :key="inputfield.name"
                    class="w-full tablet:w-5/12 mt-8"
                  >
                    <apo-input-label v-text="$t('raffle.form.' + inputfield.name)" />
                    <apo-input
                      :id="inputfield.name"
                      v-model="inputfield.value"
                      :name="inputfield.name"
                      class="mt-2"
                      :required="true"
                      @keydown.enter="$emit('submit')"
                    />
                  </div>
                </div>
                <div
                  v-for="checkbox in form.checkboxes"
                  :key="checkbox.name"
                  class="w-full mt-12 tablet:flex tablet:justify-start tablet:items-center"
                >
                  <Input
                    :id="checkbox.name"
                    v-model="checkbox.value"
                    :name="checkbox.name"
                    type="checkbox"
                    :required="checkbox.required"
                  />
                  <label
                    :for="checkbox.name"
                    class="inline ml-2 cursor-pointer href-decoration"
                    v-html="checkbox.name"
                  />
                </div>
                <div class="w-full mt-12 flex justify-center">
                  <apo-button
                    class="button button--primary button--tiny shadow-hard relative cursor-pointer"
                    type="submit"
                    :disabled="isBusy"
                  >
                    <apo-spinner
                      v-if="isBusy"
                      class="mr-4"
                      size="small"
                    />
                    <span
                      class="cursor-pointer"
                      v-text="$t('raffle.participate')"
                    />
                  </apo-button>
                </div>
              </div>
            </form>
            <div v-else>
              <div
                v-if="
                  (hasParticipated && raffleDetail.configuration.participation === 'Once') ||
                    (hasParticipated && (participationLimitReached || raffleExpired)) ||
                    submitSuccessful
                "
                class="container text-center"
              >
                <h2 v-text="$t('raffle.congratulation')" />
                <div class="border-green-300 border-8 rounded-full p-8 my-8 inline-block">
                  <apo-icon
                    class="w-16 h-16 text-green-300"
                    src="check"
                  />
                </div>
              </div>
              <div v-else>
                <div
                  v-if="participationLimitReached"
                  class="container text-center"
                >
                  <h2 v-text="$t('raffle.maxParticipants')" />
                  <div class="border-red-500 border-8 rounded-full p-8 my-8 inline-block">
                    <apo-icon
                      class="w-16 h-16 text-red-500"
                      src="close"
                    />
                  </div>
                </div>
                <div
                  v-if="raffleExpired"
                  class="container text-center"
                >
                  <h2 v-text="$t('raffle.expired')" />
                  <div class="border-red-500 border-8 rounded-full p-8 my-8 inline-block">
                    <apo-icon
                      class="w-16 h-16 text-red-500"
                      src="close"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <apo-not-found-page v-else />
      </div>
    </apo-wait>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import NotFoundPage from '@/components/cms/NotFoundPage.vue';
import { RAFFLE_FETCH_ALL } from '@/store/types/action-types';
import RaffleService from '@/services/api/RaffleService';
import themeSettings from '@/mixins/theme-settings';
import LoadingOverlay from '@/components/ui/LoadingOverlay.vue';
import Stage from '@/components/template/Stage.vue';
import CmsContentRenderer from '@/components/cms/CmsContentRenderer.vue';
import Textarea from '@/components/form-renderer/Textarea.vue';
import Input from '@/components/form/Input.vue';
import InputLabel from '@/components/form-renderer/InputLabel.vue';
import Checkbox from '@/components/form/Checkbox.vue';

export default {
  components: {
    'apo-loading-overlay': LoadingOverlay,
    'apo-not-found-page': NotFoundPage,
    'apo-stage': Stage,
    'apo-cms-content-renderer': CmsContentRenderer,
    'apo-textarea': Textarea,
    'apo-input': Input,
    'apo-input-label': InputLabel,
    'apo-checkbox': Checkbox,
  },

  mixins: [themeSettings('raffle')],

  data() {
    return {
      isOverview: true,
      hasParticipated: false,
      raffleExpired: false,
      participationLimitReached: false,
      participationCheck: false,
      selectedChoice: null,
      textInput: '',
      fileName: '',
      fileUpload: '',
      form: {
        inputfields: [],
        checkboxes: [],
      },
      isBusy: false,
      submitSuccessful: false,
      uploadError: false,
    };
  },

  computed: {
    ...mapGetters(['isAuthenticated', 'language', 'raffle', 'user']),

    raffleDetail() {
      if (this.$route.params.slug && this.raffle.length) {
        return this.raffle.find(object => String(object.slug) === String(this.$route.params.slug));
      }
      return null;
    },

    stage() {
      return {
        minimum_height: this.raffleDetail.stage.minimum_height,
        slides: this.raffleDetail.stage.slides,
      };
    },

    content() {
      return { content: this.raffleDetail.content };
    },

    contest() {
      return this.raffleDetail.contest;
    },

    formFields() {
      return this.raffleDetail ? this.raffleDetail.form : null;
    },
  },

  watch: {
    $route: {
      immediate: true,
      handler(route) {
        if (route.params.slug) {
          this.isOverview = false;
        } else {
          this.isOverview = true;
        }
      },
    },
  },

  methods: {
    ...mapActions([RAFFLE_FETCH_ALL]),

    raffleDetails(slug) {
      this.$router.push({ name: 'raffles', params: { slug } });
    },

    checkParticipation(data) {
      this.participations = data.data.filter(
        participant => Number(participant.raffle_id) === Number(this.raffleDetail.id),
      );
      this.participationLimitReached = this.raffleDetail.configuration.participant_limitation
        ? !(
          this.participations.length
            < Number(this.raffleDetail.configuration.participant_limitation)
        )
        : false;
      this.raffleExpired = this.raffleDetail.configuration.expire_date
        ? new Date(this.raffleDetail.configuration.expire_date) < new Date()
        : false;
      this.hasParticipated = this.participations.filter(
        participant => Number(participant.user_id) === Number(this.user.id),
      ).length > 0;
      this.participationCheck = true;
    },

    onTextInputChange(event) {
      this.textInput = event;
    },

    onUploadFileChange() {
      this.handleUploadFile();
    },

    async handleUploadFile() {
      if (!this.$refs.fileUpload.files || this.$refs.fileUpload.files.length === 0) {
        return;
      }

      this.fileName = this.$refs.fileUpload.files[0].name;
    },

    resetFile() {
      this.fileName = '';
      this.fileUpload = '';
    },

    createFormData() {
      if (!this.formFields) {
        return;
      }

      this.form.inputfields = [
        { name: 'firstName', value: this.user.firstName },
        { name: 'lastName', value: this.user.lastName },
        { name: 'pharmacyName', value: '' },
        { name: 'pharmacyCountry', value: '' },
        { name: 'pharmacyStreet', value: '' },
        { name: 'pharmacyStreetNumber', value: '' },
        { name: 'pharmacyZipCode', value: '' },
        { name: 'pharmacyCity', value: '' },
      ];
      if (this.formFields.checkboxes.length > 0) {
        this.form.checkboxes = this.formFields.checkboxes.map(checkbox => ({
          ...checkbox,
          value: 'off',
        }));
      }
    },

    submit() {
      const formData = new FormData(this.$refs.submitForm);
      formData.append('raffle_id', Number(this.raffleDetail.id));
      if (this.contest.type === 'Upload') formData.append('contest', this.fileName);

      this.isBusy = true;

      RaffleService.store(formData)
        .then(response => {
          this.isBusy = false;
          this.submitSuccessful = true;
          const data = JSON.parse(response.data);
          if (data.state === false) {
            this.hasParticipated = false;
            this.submitSuccessful = false;
            this.uploadError = true;
          }
        })
        .catch(() => {
          this.isBusy = false;
        });

      /* UserService.updateUserProfile(this.user, data)
        .then(() => {
          this.$store.dispatch(AUTH_FETCH_CURRENT_USER);
        })
        .catch(({ response }) => {
          this.errors.clear();

          if (response.status === 400 && response.data.code === 'rest_invalid_param') {
            this.errors.assign(response.data.data.params);
          }
        })
        .finally(() => {
          this.isBusy = false;
        }); */
    },
  },

  created() {
    this[RAFFLE_FETCH_ALL]()
      .then(() => {
        this.createFormData();
        RaffleService.getStored().then(data => {
          this.checkParticipation(data);
        });
      })
      .catch(error => {
        console.log('error retrieving the posts', error);
      });
  },
};
</script>

<style lang="scss" scoped>
.choice-container {
  display: flex;
  align-items: center;
  justify-content: center;
  max-width: 700px;
  margin: 0 auto;
}

.choice {
  &-label {
    @apply border-gray-700;
    @apply block;
    @apply border-4;
    @apply cursor-pointer;
    @apply h-16;
    @apply overflow-hidden;
    @apply relative;
    @apply rounded-full;
    width: 300px;
    @apply m-2;

    &:hover,
    &.is-active {
      @apply border-gray-900;
    }
  }

  &-text {
    @apply absolute;
    @apply bg-white;
    @apply border-5;
    @apply border-white;
    @apply flex;
    @apply h-full;
    @apply items-center;
    @apply left-0;
    @apply justify-center;
    @apply rounded-full;
    @apply text-gray-700;
    @apply text-xl;
    @apply top-0;
    @apply w-full;
  }

  &-label:hover &-text,
  &-label.is-active &-text {
    @apply bg-gray-900;
    @apply text-white;
  }
}

.delete {
  position: relative;
  top: -10px;
}

.href-decoration {
  /deep/ a {
    text-decoration: underline !important;
  }
}

</style>
