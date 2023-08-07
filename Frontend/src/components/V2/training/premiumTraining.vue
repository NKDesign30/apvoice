<template>
  <div class="relative flex flex-row flex-wrap w-full ">
    <div
      v-if="showError"
      class="absolute z-10 mx-auto mb-10 w-full max-w-2xl p-4 rounded-full bg-red-300 text-white shadow-hard"
      style="left: 0; right: 0; top: 0px;"
    >
      <div class="notification-inner mx-auto relative w-11/12">
        <p
          class="w-5/6 mx-auto"
          v-html="errorMessage"
        />
        <span
          class="absolute top-0 right-0"
        >
          <apo-icon
            class="w-5 cursor-pointer"
            src="close"
            @click="closeError()"
          />
        </span>
      </div>
    </div>
    <div class="flex flex-col w-full tablet:w-1/4">
      <div class="h-40 flex justify-between overflow-hidden rounded-lg">
        <img
          class="object-cover rounded-lg object-top w-2/3 tablet:w-full h-full"
          style="box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2)"
          :src="premium.thumbnail"
        >
        <div class="tablet:hidden  block">
          <div
            class="relative flex items-center justify-center"
          >
            <div
              class="absolute flex flex-col items-center justify-center text-white"
            >
              <div
                v-if="!premium.unlocked"
                class="flex flex-col items-center justify-center"
              >
                <span class="text-3xl">
                  {{ premium.apo_points }}
                </span>
                <span class="-mt-3"> apoPoints </span>
              </div>
              <div v-else>
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 24 24"
                  width="50px"
                  fill="#ffffff"
                ><path
                  d="M0 0h24v24H0V0z"
                  fill="none"
                /><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6h2c0-1.66 1.34-3 3-3s3 1.34 3 3v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm0 12H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z" /></svg>
              </div>
            </div>
            <img
              src="/assets/img/apo_points_unlocked.svg"
              alt=""
            >
          </div>
        </div>
      </div>
      <button
        v-if="premium.unlocked && premium.is_complete"
        class="hidden w-full py-2 mt-5 mr-auto text-center text-white rounded-full tablet:block"
        style="background-color: #d5b03a"
        @click="download(premium.trainings[0])"
      >
        {{ $t("trainings.download") }}
      </button>
      <router-link
        v-if="premium.unlocked && !premium.is_complete"
        class="hidden w-full py-2 mt-5 mr-auto text-center text-white rounded-full tablet:block"
        style="background-color: #d5b03a"
        tag="apo-button"
        :to="getTrainingsLink()"
      >
        {{ $t("trainings.start") }}
      </router-link>


      <button
        v-else
        class="hidden w-full py-2 mt-5 mr-auto text-center text-white rounded-full tablet:block"
        :class="disabled ? 'disabled cursor-not-allowed' : ''"
        :style="disabled ? 'box-shadow: 0px 0px 10px #00000029; color: #ffffff; background-color: #eeeeee' : 'background-color: #d5b03a'"
        :disabled="disabled"
        @click="!disabled && !loading && !isPending && unlockPremium(premium.id)"
      >
        <span v-if="!loading">{{ $t("trainings.unlock") }}</span>
        <apo-spinner
          v-else
          size="small"
        />
      </button>
    </div>
    <p
      v-if="premium.category && premium.category.length"
      class="px-3 mt-5 ml-0 mr-auto text-sm text-right text-gray-700 tablet:hidden"
    >
      {{ premium.category[0] }}
    </p>
    <div class="w-full tablet:w-2/4">
      <p class="pl-4 mt-2">
        {{ premium.title }}
      </p>
      <p class="pl-4 text-sm">
        {{ premium.informations.description }}
      </p>
    </div>

    <div class="flex-col hidden w-1/4 tablet:flex">
      <p
        v-if="premium.category && premium.category.length"
        class="text-sm text-right text-gray-700"
      >
        {{ premium.category[0] }}
      </p>
      <div
        class="relative flex items-center justify-center mt-2 ml-auto"
      >
        <div
          class="absolute flex flex-col items-center justify-center text-white"
        >
          <div
            v-if="!premium.unlocked"
            class="flex flex-col items-center justify-center"
          >
            <span class="text-3xl">
              {{ premium.apo_points }}
            </span>
            <span class="-mt-3"> apoPoints </span>
          </div>
          <div v-else>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 24 24"
              width="50px"
              fill="#ffffff"
            ><path
              d="M0 0h24v24H0V0z"
              fill="none"
            /><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6h2c0-1.66 1.34-3 3-3s3 1.34 3 3v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm0 12H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z" /></svg>
          </div>
        </div>
        <img
          src="/assets/img/apo_points_unlocked.svg"
          alt=""
        >
      </div>
    </div>

    
    <div class="flex w-full justify-center button block tablet:hidden">
      <button
        v-if="premium.unlocked && premium.is_complete"
        class="block tablet:hidden py-2 px-4 mt-5 text-center text-white rounded-full"
        style="background-color: #d5b03a"
        @click="download(premium.trainings[0])"
      >
        {{ $t("trainings.download") }}
      </button>
      <router-link
        v-if="premium.unlocked && !premium.is_complete"
        class="block tablet:hidden py-2 px-4 mt-5 text-center text-white rounded-full"
        style="background-color: #d5b03a"
        tag="apo-button"
        :to="getTrainingsLink()"
      >
        {{ $t("trainings.start") }}
      </router-link>
      <button
        v-else
        class="block tablet:hidden py-2 px-4 mt-5 text-center text-white rounded-full"
        :class="disabled ? 'disabled cursor-not-allowed' : ''"
        :style="disabled ? 'box-shadow: 0px 0px 10px #00000029; color: #ffffff; background-color: #eeeeee' : 'background-color: #d5b03a'"
        :disabled="disabled"
        @click="!disabled && !loading &&  !isPending && unlockPremium(premium.id)"
      >
        <span v-if="!loading">{{ $t("trainings.unlock") }}</span>
        <apo-spinner
          v-else
          size="small"
        />
      </button>
    </div>

    <div class="flex flex-row justify-start w-full mt-2">
      <div
        v-if="premium.unlocked"
        class="flex flex-row w-full"
      >
        <router-link
          v-for="lesson in lessons"
          :key="lesson.id"
          :to="getTrainingsLink(lesson.lesson)"
          class="flex-row items-center justify-between hidden h-10 p-3 mr-3 rounded-lg tablet:flex w-72"
          :style="
            user.trainingResults[premium.trainings[0].training.ID] &&
              user.trainingResults[premium.trainings[0].training.ID]['completed_lessons'][
                lesson.lesson.lesson_id
              ]
              ? 'background: #fff; box-shadow: 0px 0px 10px #ccc'
              : 'background: linear-gradient(to right, #d5b03a, #d5b03a, #d5b03a, #f4e2ab, #f4e2ab);'
          "
        >
          <span
            class="text-xs"
            :style="
              user.trainingResults[premium.trainings[0].training.ID] &&
                user.trainingResults[premium.trainings[0].training.ID]['completed_lessons'][
                  lesson.lesson.lesson_id
                ]
                ? 'color: #ccc;'
                : 'color: #fff'
            "
          >
            {{ lesson.lesson.meta_infos.duration.time }}
          </span>
          <span
            class="ml-1 text-sm"
            :style="
              user.trainingResults[premium.trainings[0].training.ID] &&
                user.trainingResults[premium.trainings[0].training.ID]['completed_lessons'][
                  lesson.lesson.lesson_id
                ]
                ? 'color: #ccc;'
                : 'color: #fff'
            "
          >
            {{ lesson.lesson.meta_infos.duration.type }}
          </span>
          <span
            class="w-1/2 h-5 mx-auto text-sm text-center"
            style="overflow: hidden;
            text-overflow: ellipsis
            white-space: nowrap;"
            :style="
              user.trainingResults[premium.trainings[0].training.ID] &&
                user.trainingResults[premium.trainings[0].training.ID]['completed_lessons'][
                  lesson.lesson.lesson_id
                ]
                ? 'color: #ccc;'
                : 'color: #fff'
            "
          >
            {{ lesson.lesson.meta_infos.title }}
          </span>
          <div
            class="flex items-center justify-center w-5 h-5 bg-white rounded-full "
          >
            <apo-icon
              v-if="
                user.trainingResults[premium.trainings[0].training.ID] &&
                  user.trainingResults[premium.trainings[0].training.ID]['completed_lessons'][
                    lesson.lesson.lesson_id
                  ]
              "
              src="radio_checked"
              class="w-6 h-6 training-lesson__icon--unchecked text-training-500"
            />
            <apo-icon
              v-else
              src="radio"
              class="w-6 h-6 training-lesson__icon--checked text-training-500"
            />
          </div>
        </router-link>
        <div class="block tablet:hidden">
          <carousel
            class="w-full mx-auto"
            :pagination-enabled="false"
            :per-page="lessons.length > 1 ? 1.5 : 1.5"
          >
            <slide
              v-for="lesson in lessons"
              :key="lesson.id"
              class="px-2"
            >
              <router-link
                :to="getTrainingsLink(lesson.lesson)"
                class="flex flex-row items-center justify-between h-10 p-3 my-5 mr-3 rounded-lg w-44"
                :class="
                  user.trainingResults[premium.trainings[0].training.ID] &&
                    user.trainingResults[premium.trainings[0].training.ID]['completed_lessons'][
                      lesson.lesson.lesson_id
                    ]
                    ? 'ml-2 '
                    : ''
                "
                :style="
                  user.trainingResults[premium.trainings[0].training.ID] &&
                    user.trainingResults[premium.trainings[0].training.ID]['completed_lessons'][
                      lesson.lesson.lesson_id
                    ]
                    ? 'background: #fff; box-shadow: 0px 0px 10px #ccc'
                    : 'background: linear-gradient(to right, #d5b03a, #d5b03a, #d5b03a, #f4e2ab, #f4e2ab);'
                "
              >
                <span
                  class="text-xs"
                  :style="
                    user.trainingResults[premium.trainings[0].training.ID] &&
                      user.trainingResults[premium.trainings[0].training.ID]['completed_lessons'][
                        lesson.lesson.lesson_id
                      ]
                      ? 'color: #ccc;'
                      : 'color: #fff'
                  "
                >
                  {{ lesson.lesson.meta_infos.duration.time }}
                </span>
                <span
                  class="ml-1 mr-auto text-sm"
                  :style="
                    user.trainingResults[premium.trainings[0].training.ID] &&
                      user.trainingResults[premium.trainings[0].training.ID]['completed_lessons'][
                        lesson.lesson.lesson_id
                      ]
                      ? 'color: #ccc;'
                      : 'color: #fff'
                  "
                >
                  {{ lesson.lesson.meta_infos.duration.type }}
                </span>
                <div
                  class="flex items-center justify-center w-5 h-5 bg-white rounded-full "
                >
                  <apo-icon
                    v-if="
                      user.trainingResults[premium.trainings[0].training.ID] &&
                        user.trainingResults[premium.trainings[0].training.ID]['completed_lessons'][
                          lesson.lesson.lesson_id
                        ]
                    "
                    src="radio_checked"
                    class="w-4 h-4 training-lesson__icon--unchecked text-training-500"
                  />
                  <apo-icon
                    v-else
                    src="radio"
                    class="w-4 h-4 training-lesson__icon--checked text-training-500"
                  />
                </div>
              </router-link>
            </slide>
          </carousel>
        </div>
      </div>
    </div>
    <div class="flex flex-row justify-start w-full self-center desktop:p-5 p-0">  
        <img v-show="liketest"
          @click="handleClick"
          class="h-auto max-w-full cursor-pointer	hearthover"
          style="margin-top: 20px;"
          src="@/assets/img/heart_full.svg"
          :alt="$t('template.navigation.logo.alt')">
          
           <img v-show="!liketest"
          @click="handleClick"
          class="h-auto max-w-full cursor-pointer hearthover"
          style="margin-top: 20px;"
          src="@/assets/img/heart_empty.svg"
          :alt="$t('template.navigation.logo.alt')">
          <span class=" pl-3 pt-5" style="text-align: center;">{{this.countLike}}</span>
    </div>  </div>
</template>

<script>
import { mapState, mapActions, mapGetters } from 'vuex';
import get from 'lodash/get';
import downloadCertificate from '@/mixins/download-certificate';
import TrainingMapper from '@/services/mapper/TrainingMapper';
import TrainingService from '@/services/api/TrainingService';

export default {
  mixins: [downloadCertificate()],
  props: {
    premium: {
      type: Object,
      required: true,
    },

    disabled: {
      type: Boolean,
      default: false,
    },
  },

  data() {
    return {
      errorMessage: '',
      showError: false,
      loading: false,
      countLike:0,
      liked:false,
    };
  },

  computed: {
    ...mapGetters(['trainingCategory', 'user']),
    ...mapGetters(['language']),
    ...mapState({
      settings: state => state.settings.settings,
    }),

    isPending() {
      return !this.settings.showVoucher.is_available;
    },
    lessons() {
      return get(this.premium.trainings[0], 'lessons', []);
    },
    nextLesson() {
      const nextLesson = this.lessons.find(
        lesson => !(
          Object.keys(this.user.trainingResults).includes(this.premium.trainings[0].training.ID)
            && this.user.trainingResults[this.premium.trainings[0].training.ID].completed_lessons[
              lesson.lesson_id
            ]
        ),
      );
      return get(nextLesson, 'lesson_id', null);
    },
    liketest(){
      return(this.liked);
    },
  },
  methods: {
    ...mapActions(['unlockPremiumContent', 'unlockPremiumTrainingSeries']),
    handleClick(event){
      event.target.classList.toggle(".disable");
     if(this.liked){
      this.storeDisLike()
     }else{
      this.storeLike()
     }
     event.target.classList.toggle(".disable");
    },
    refresh(){
     this.isliked();
     this.countLikes();
    },
      storeLike() {
      const params = {
        TRAINING_SERIES_ID: this.premium.id,
      };
      TrainingService.storeLike(
        params
      ).then(response => {
         
        console.log(response);
         this.isliked();
     this.countLikes();
        })
        .catch(error => {
          console.log('error storing training like result', error);
        });
    },
    storeDisLike() {
      const params = {
        TRAINING_SERIES_ID: this.premium.id,
      };
      TrainingService.storeDisLike(
        params
      ).then(response => {
          this.isliked();
     this.countLikes();
        
        })
        .catch(error => {
          console.log('error storing training like result', error);
        });
    },
     isliked(){
      const params = {
        TRAINING_SERIES_ID: this.premium.id,
      };
      TrainingService.checkLike(
        params
      ).then(response => {
        this.liked=response;
        })
        .catch(error => {
          console.log('error storing training like result', error);
        });
    },
    countLikes(){
      const params = {
        TRAINING_SERIES_ID: this.premium.id,
      };
      TrainingService.countLikes(
        params
      ).then(response => {
        if(response.length!=0){
          this.countLike=response[0].count;
        }else{
          this.countLike=0;
        }

        })
        .catch(error => {
          console.log('error storing training like result', error);
        });
    },
    unlockPremium(id) {
      this.loading = true;
      this.unlockPremiumContent(id).then(result => {
        console.log(result);
        if (typeof result !== 'object') {
          this.unlockPremiumTrainingSeries(id);
        } else {
          this.showError = true;
          this.errorMessage = result[0];
        }
        this.loading = false;
      });
    },
    closeError() {
      this.showError = false;
      this.errorMessage = '';
    },
    complete() {
      return Boolean(
        this.user.trainingResults[this.premium.trainings[0].id]
          && this.user.trainingResults[this.premium.trainings[0].id]
            .is_complete === '1',
      );
    },
    getTrainingsLink(lesson = null) {
      const url = `/trainings/${this.premium.slug}/${this.premium.trainings[0].training.post_name}/${lesson ? lesson.lesson_id : this.premium.trainings[0].lessons[0].lesson.lesson_id}`;
      return url;
    },
    categoriesNames(categories) {
      if (categories.length > 0) {
        return categories
          .map(id => this.premiumCategory(id))
          .map(category => (category ? category.name : ''))
          .join(', ');
      }
      return null;
    },
  },
  created(){
     this.refresh();
  }
};
</script>


<style scoped>

.disable{
  pointer-events:none
}

@media (min-width: 767px) {
.hearthover:hover{
 	transform: scale(1.3);
}
 
}

</style>
