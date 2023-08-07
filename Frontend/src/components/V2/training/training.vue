<template>
  <div class="flex flex-col">
    <div class="flex flex-col w-full mb-5 tablet:flex-row tablet:items-start">
      <div class="flex flex-col w-full px-2 py-3 tablet:w-1/4" v-if="!relation">
        <div class="flex justify-between h-40 overflow-hidden rounded-lg">
          <img
            class="object-cover object-top w-2/3 h-full rounded-lg tablet:w-full"
            style="box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2)"
            :src="training.informations.image.url"
          />
          <div class="block w-1/4 pl-5 tablet:hidden">
            <div
              v-if="training.informations.apo_points"
              class="relative flex items-center justify-center"
            >
              <span class="absolute text-3xl text-white top-10">
                {{ training.informations.apo_points }}
              </span>
              <img src="/assets/img/apo_points.svg" alt="" />
            </div>
          </div>
        </div>
      </div>
      <p class="px-3 mt-5 ml-0 mr-auto text-sm text-right text-gray-700 tablet:hidden">
        {{ categoriesNames(training.categories) }}
      </p>
      <div class="w-full px-1 py-3 pl-3 tablet:w-2/4">
        <p class="mt-2">
          {{ training.title }}
        </p>
        <p class="text-sm">
          {{ training.informations.description }}
        </p>
      </div>
      <div class="flex-col hidden w-1/4 py-3 pl-5 tablet:flex">
        <p class="text-sm text-right text-gray-700">
          {{ categoriesNames(training.categories) }}
        </p>
        <div
          v-if="training.informations.apo_points"
          class="relative flex items-center justify-center mt-2 ml-auto"
        >
          <span class="absolute text-3xl text-white top-10">
            {{ training.informations.apo_points }}
          </span>
          <img src="/assets/img/apo_points.svg" alt="" />
        </div>
      </div>
    </div>
    <router-link
      v-if="nextLesson"
      :class="
        `hidden w-1/4 py-2 my-5 text-center text-white rounded-full tablet:block ${buttonClass}`
      "
      :to="{
        name: `${this.$route.name}`,
        params: {
          series_id: training.id,
          series_slug: training.slug,
          id: training.trainings[0].id,
          training_slug: training.trainings[0].slug,
          lesson_id: nextLesson
        }
      }"
    >
      {{ $t("trainings.start") }}
    </router-link>
    <div class="hidden tablet:flex justify-start">
      <button
        v-if="complete()"
        :class="
          `max-w-3xl box-border w-1/2 desktop:w-1/4 py-2 my-5 text-white rounded-full ${buttonClass}`
        "
        @click="download(training.trainings[0])"
      >
        {{ $t("trainings.download") }}
      </button>

      <router-link
        v-if="complete()"
        :to="{
          name: 'training-summary',
          params: { slug: training.slug, id: training.id, theme: theme, origin: this.$route.name }
        }"
        :class="
          `max-w-3xl box-border ml-2 w-1/2 desktop:w-1/4 py-2 my-5 text-white rounded-full text-center ${buttonClass}`
        "
        v-text="$t('general.summary')"
      />
    </div>

    <div class="flex flex-row justify-start w-full" v-if="!relation">
      <div class="flex flex-row w-full">
        <router-link
          v-for="(lesson, index) in lessons"
          :key="lesson.id"
          :to="getTrainingsLink(lesson.lesson, index)"
          class="flex-row items-center justify-between hidden h-10 p-3 mr-3 rounded-lg tablet:flex w-72"
          :style="lessonLinkStyle(lesson)"
        >
          <span
            class="text-xs"
            :style="userHasCompletedLesson(lesson) ? 'color: #ccc;' : 'color: #fff'"
            >{{ lesson.meta_infos.duration.time }}
          </span>
          <span
            class="ml-1 text-sm"
            :style="userHasCompletedLesson(lesson) ? 'color: #ccc;' : 'color: #fff'"
            >{{ lesson.meta_infos.duration.type }}
          </span>
          <span
            class="w-1/2 h-5 mx-auto text-sm text-center"
            style="overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;"
            :style="userHasCompletedLesson(lesson) ? 'color: #ccc;' : 'color: #fff'"
          >
            {{ lesson.meta_infos.title }}
          </span>
          <div class="flex items-center justify-center w-5 h-5 bg-white rounded-full ">
            <apo-icon
              v-if="userHasCompletedLesson(lesson)"
              src="radio_checked"
              class="w-6 h-6 training-lesson__icon--unchecked"
              :class="checkBoxClass"
            />
            <apo-icon
              v-else
              src="radio"
              class="w-6 h-6 training-lesson__icon--checked"
              :class="checkBoxClass"
            />
          </div>
        </router-link>

        <div class="w-full tablet:hidden">
          <carousel
            class="w-full mx-auto"
            :pagination-enabled="false"
            :per-page="lessons.length > 1 ? 1.5 : 1.5"
          >
            <slide v-for="(lesson, index) in lessons" :key="lesson.id" class="px-2">
              <router-link
                :to="getTrainingsLink(lesson.lesson, index)"
                class="flex flex-row items-center justify-between w-full h-10 p-3 my-5 mr-3 rounded-lg "
                :style="lessonLinkStyle(lesson)"
              >
                <span
                  class="text-xs"
                  :style="userHasCompletedLesson(lesson) ? 'color: #ccc;' : 'color: #fff'"
                  >{{ lesson.meta_infos.duration.time }}</span
                >
                <span
                  class="ml-1 mr-auto text-sm"
                  :style="userHasCompletedLesson(lesson) ? 'color: #ccc;' : 'color: #fff'"
                  >{{ lesson.meta_infos.duration.type }}</span
                >
                <div class="flex items-center justify-center w-5 h-5 bg-white rounded-full ">
                  <apo-icon
                    v-if="userHasCompletedLesson(lesson)"
                    src="radio_checked"
                    class="w-4 h-4 training-lesson__icon--unchecked"
                    :class="checkBoxClass"
                  />
                  <apo-icon
                    v-else
                    src="radio"
                    class="w-4 h-4 training-lesson__icon--checked"
                    :class="checkBoxClass"
                  />
                </div>
              </router-link>
            </slide>
          </carousel>
        </div>
      </div>
    </div>
    <div class="flex flex-row justify-start w-full self-center desktop:p-5 p-0" v-if="!relation">
      <img
        v-show="liketest"
        class="h-auto max-w-full cursor-pointer	hearthover"
        @click="handleClick"
        style="margin-top: 20px;"
        src="@/assets/img/heart_full.svg"
        :alt="$t('template.navigation.logo.alt')"
      />

      <img
        v-show="!liketest"
        class="h-auto max-w-full cursor-pointer hearthover"
        @click="handleClick"
        style="margin-top: 20px;"
        src="@/assets/img/heart_empty.svg"
        :alt="$t('template.navigation.logo.alt')"
      />
      <span class=" pl-3 pt-5" style="text-align: center;">{{ this.countLike }}</span>
    </div>

    <span
      class="ml-auto mr-0 text-sm text-right text-gray-700 cursor-pointer mandatory"
      style="color: #575757; text-decoration: underline; margin-top: 20px;"
      v-if="hasDutyText"
      @click="showDutyText = !showDutyText"
    >
      {{ $t("trainings.dutyText") }}
    </span>
    <apo-collapsible-content class="mt-8" style="box-shadow: none" :show="showDutyText">
      <div
        class="container p-6 mx-auto break-all"
        style="font-size: 14px!important;"
        v-if="hasDutyText"
        v-html="training.dutyText"
      />
    </apo-collapsible-content>
    <div class="flex tablet:hidden">
      <router-link
        v-if="nextLesson"
        :class="
          `block w-2/3 py-2 mx-auto mt-5 text-center text-white rounded-full tablet:hidden ${buttonClass}`
        "
        :to="{
          name: 'trainings',
          params: {
            series_id: training.id,
            series_slug: training.slug,
            id: training.trainings[0].id,
            training_slug: training.trainings[0].slug,
            lesson_id: nextLesson
          }
        }"
      >
        {{ $t("trainings.start") }}
      </router-link>
    </div>
    <div class="block tablet:hidden">
      <button
        v-if="complete()"
        :class="
          `block w-2/3  py-2 mx-auto mt-5 text-center text-white rounded-full  ${buttonClass}`
        "
        @click="download(training.trainings[0])"
      >
        {{ $t("trainings.download") }}
      </button>

      <router-link
        v-if="complete()"
        :to="{
          name: 'training-summary',
          params: { slug: training.slug, id: training.id, theme: theme, origin: this.$route.name }
        }"
        :class="
          `block w-2/3  py-2 mx-auto mt-5 text-center text-white rounded-full  ${buttonClass}`
        "
        v-text="$t('general.summary')"
      />
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import get from "lodash/get";
import downloadCertificate from "@/mixins/download-certificate";
import TrainingMapper from "@/services/mapper/TrainingMapper";
import TrainingService from "@/services/api/TrainingService";

export default {
  mixins: [downloadCertificate()],
  props: {
    training: {
      type: Object,
      required: true
    },
    theme: {
      type: String,
      required: true
    },
    relation: {
      type: Boolean
    }
  },
  data() {
    return {
      showDutyText: false,
      countLike: 0,
      liked: false
    };
  },
  computed: {
    ...mapGetters(["trainingCategory", "user"]),
    ...mapGetters(["language"]),
    lessons() {
      return get(this.training.trainings[0], "lessons", []);
    },
    nextLesson() {
      const nextLesson = this.lessons.find(
        lesson =>
          !(
            this.user.trainingResults[lesson.training_id] &&
            this.user.trainingResults[lesson.training_id].completed_lessons[lesson.lesson_id]
          )
      );
      return get(nextLesson, "lesson_id", null);
    },
    liketest() {
      return this.liked;
    },

    hasDutyText() {
      return (
        this.training.dutyText && this.training.dutyText.length && this.training.dutyText.length > 0
      );
    },
    buttonClass() {
      if (this.theme === "training") {
        return "bg-training-500"; // was '#069bff';
      } else if (this.theme === "scientific") {
        return "bg-scientific-500";
      }
    },
    checkBoxClass() {
      if (this.theme === "training") {
        return "text-training-500";
      } else if (this.theme === "scientific") {
        return "text-scientific-500";
      }
    }
  },
  methods: {
    handleClick(event) {
      event.target.classList.toggle(".disable");
      if (this.liked) {
        this.storeDisLike();
      } else {
        this.storeLike();
      }
      event.target.classList.toggle(".disable");
    },
    refresh() {
      this.isliked();
      this.countLikes();
    },
    storeLike() {
      console.log(this.training.id);
      const params = {
        TRAINING_SERIES_ID: this.training.id
      };
      TrainingService.storeLike(params)
        .then(response => {
          console.log(response);
          this.isliked();
          this.countLikes();
        })
        .catch(error => {
          console.log("error storing training like result", error);
        });
    },
    storeDisLike() {
      console.log(this.training.id);
      const params = {
        TRAINING_SERIES_ID: this.training.id
      };
      TrainingService.storeDisLike(params)
        .then(response => {
          this.isliked();
          this.countLikes();
        })
        .catch(error => {
          console.log("error storing training like result", error);
        });
    },
    isliked() {
      const params = {
        TRAINING_SERIES_ID: this.training.id
      };
      TrainingService.checkLike(params)
        .then(response => {
          this.liked = response;
        })
        .catch(error => {
          console.log("error storing training like result", error);
        });
    },
    countLikes() {
      const params = {
        TRAINING_SERIES_ID: this.training.id
      };
      TrainingService.countLikes(params)
        .then(response => {
          if (response.length != 0) {
            this.countLike = response[0].count;
          } else {
            this.countLike = 0;
          }
        })
        .catch(error => {
          console.log("error storing training like result", error);
        });
    },
    getTrainingsLink(lesson = null, index) {
      const url = `/${this.$route.name}/${this.training.slug}/${this.training.trainings[0].slug}/${
        lesson ? lesson.lesson_id : this.training.trainings[0].lessons[index].lesson_id
      }`;
      return url;
    },
    lessonLinkStyle(lesson) {
      if (this.theme === "training") {
        return this.userHasCompletedLesson(lesson)
          ? "background: #fff; box-shadow: 0px 0px 10px #ccc"
          : "background: linear-gradient(261deg, #adddef 0%, #0099ff 100%) 0% 0% no-repeat padding-box";
      } else if (this.theme === "scientific") {
        return this.userHasCompletedLesson(lesson)
          ? "background: #fff; box-shadow: 0px 0px 10px #ccc"
          : "background: transparent linear-gradient(259deg, #9BD442 0%, #00B041 100%) 0% 0% no-repeat padding-box;";
      }
    },
    userHasCompletedLesson(lesson) {
      return (
        this.user.trainingResults[lesson.training_id] &&
        this.user.trainingResults[lesson.training_id]["completed_lessons"][lesson.lesson_id]
      );
    },
    complete() {
      return Boolean(
        this.user.trainingResults[this.training.trainings[0].id] &&
          this.user.trainingResults[this.training.trainings[0].id].is_complete === "1"
      );
    },
    categoriesNames(categories) {
      if (categories.length > 0) {
        return categories
          .map(id => this.trainingCategory(id))
          .filter(
            category =>
              category !== undefined &&
              category.slug !== "products" &&
              category.slug !== "category" &&
              category.slug !== "scientific"
          )
          .map(category => (category ? category.name : ""))
          .join(", ");
      }
      return null;
    }
  },
  created() {
    this.refresh();
  }
};
</script>
<style scoped>
.disable {
  pointer-events: none;
}

@media (min-width: 767px) {
  .hearthover:hover {
    transform: scale(1.3);
  }
}
</style>
