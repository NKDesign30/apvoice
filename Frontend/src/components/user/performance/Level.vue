<template>
  <div class="w-full">
    <div class="mb-9 w-full pl-1"
         v-show="level === null">
      <div class="text-left py-8">{{ $t('loaders.yourData') }}</div>
    </div>
    <apo-wait for="user">
      <apo-wait for="training.series">
        <div class="fade-in desktop:hidden ml-0" v-cloak v-show="level !== null">
          <div class="flex flex-row">
            <div class="pr-3">
              <img
                v-if="showProfileItems"
                :src="profilePicture"
                alt=""
                class="w-20 h-20 border-4 border-white rounded-full tablet:w-32 tablet:h-32"
              >
            </div>
            <div class="w-1/2 text-2xl pl-3 text-left" v-if="showProfileItems">
              <p>{{ user.firstName }} {{ user.lastName }}</p>
              <p class="-mt-1 capitalize">
                {{ user.job }}
              </p>
            </div>
            <div class="w-1/4 px-4 py-2 relative">
          <span class="absolute top-0 right-0 mr-2"  v-if="showEditIcon">
            <router-link
              to="/profile"
              class="w-12 h-12 text-center rounded-xl"
              :title="$t('welcome.edit_profile')"
            >
                   <font-awesome-icon icon="fa-solid fa-pen"
                                      class="text-white h-3 w-3 tablet:h-4 tablet:w-4 border-2 border-white rounded-full p-2 font-bold"/>
                  </router-link>
          </span>
            </div>
          </div>
          <div class="flex flex-row">
            <div class="w-1/4 uppercase text-left tablet:text-center" style="line-height: 20px;">
              {{ $t('level_component.level') }}<span
              class="text-5xl" style="line-height: 50px;">{{ level }}</span>
            </div>
            <div class="w-3/4 px-4 py-2">
              <div class="w-full text-sm text-right pr-1">{{ trainingsLeftText }}</div>
              <div class="w-full flex pt-1">
                <div class="w-1/5 h-2 rounded-full bg-white px-1 mr-1"
                     :class="opacityClass(1)"></div>
                <div class="w-1/5 h-2 rounded-full bg-white px-1 mr-1"
                     :class="opacityClass(2)"></div>
                <div class="w-1/5 h-2 rounded-full bg-white px-1 mr-1"
                     :class="opacityClass(3)"></div>
                <div class="w-1/5 h-2 rounded-full bg-white px-1 mr-1"
                     :class="opacityClass(4)"></div>
                <div class="w-1/5 h-2 rounded-full bg-white px-1 mr-1"
                     :class="opacityClass(5)"></div>
              </div>
            </div>
          </div>
        </div>

        <div class="hidden desktop:block w-full fade-in" v-cloak v-show="level !== null && trainingsThisLevel !== null">
          <div class="flex flex-row">
            <div class="mr-2 tablet:mr-5" v-if="showProfileItems">
              <img
                :src="profilePicture"
                alt=""
                class="w-20 h-20 border-8 border-white rounded-full tablet:w-32 tablet:h-32"
              >
            </div>
            <div class="w-3/4">
              <div class="flex flex-row" v-if="showProfileItems">
                <div class="w-3/4 text-2xl text-left">
                  <p>{{ user.firstName }} {{ user.lastName }}</p>
                  <p class="-mt-1 capitalize">
                    {{ user.job }}
                  </p>
                </div>
                <div class="w-1/4 text-right py-2 relative">
                    <span class="absolute top-0 right-0 mr-4">
                      <router-link
                        v-if="showEditIcon"
                        to="/profile"
                        class="w-12 h-12 text-center rounded-xl"
                        :title="$t('welcome.edit_profile')"
                      >
                         <font-awesome-icon icon="fa-solid fa-pen"
                                            class="text-white h-4 w-4 border-2 border-white rounded-full p-2 font-bold"
                         />
                        </router-link>
                    </span>
                </div>
              </div>
              <div class="flex flex-row">
                <div class="w-1/4 uppercase">{{ $t('level_component.level') }}<span
                  class="text-5xl">{{ level }}</span>
                </div>
                <div class="w-3/4 px-4 pt-5">
                  <div class="w-full text-sm text-right pr-1">{{ trainingsLeftText }}</div>
                  <div class="w-full flex pt-1">
                    <div class="w-1/5 h-2 rounded-full bg-white px-1 mr-1"
                         :class="opacityClass(1)"></div>
                    <div class="w-1/5 h-2 rounded-full bg-white px-1 mr-1"
                         :class="opacityClass(2)"></div>
                    <div class="w-1/5 h-2 rounded-full bg-white px-1 mr-1"
                         :class="opacityClass(3)"></div>
                    <div class="w-1/5 h-2 rounded-full bg-white px-1 mr-1"
                         :class="opacityClass(4)"></div>
                    <div class="w-1/5 h-2 rounded-full bg-white px-1 mr-1"
                         :class="opacityClass(5)"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </apo-wait>
    </apo-wait>
  </div>
</template>

<script>
import {mapActions} from 'vuex';
import {
  AUTH_FETCH_USER_LEVEL_DATA
} from '@/store/types/action-types';

export default {
  name: "Level",
  props: {
    user: {
      type: Object,
      required: true
    },
    profilePicture: {
      type: String,
      required: true
    },
    showEditIcon: {
      type: Boolean,
      required: true
    },
    showProfileItems: {
      type: Boolean,
      default: true
    }
  },
  data() {
    return {
      level: null,
      trainingsThisLevel: null
    }
  },
  created() {
    this[AUTH_FETCH_USER_LEVEL_DATA]().then(data => {
      let completed = data.completed_trainings;
      this.level = data.level;
      this.trainingsThisLevel = completed % 5;
    });
  },
  methods: {
    ...mapActions([
      'fetchAvailableAndCompletedSeries',
      AUTH_FETCH_USER_LEVEL_DATA
    ]),
    opacityClass(itemNumber) {
      return itemNumber <= this.trainingsThisLevel ? "opacity-100" : "opacity-50";
    }
  },
  computed: {
    trainingsLeftText() {
      if (5 - this.trainingsThisLevel === 1) {
        return this.$t('level_component.get_extra_points') + ' - ' + this.$t('level_component.one_training_left');
      } else {
        return this.$t('level_component.get_extra_points') + ' - ' + this.$t('level_component.trainings_left', {number: (5 - this.trainingsThisLevel)});
      }
    }
  }
}
</script>

<style scoped>
  fade-in {
    animation: fadeIn 4s;
    -webkit-animation: fadeIn 5s;
    -moz-animation: fadeIn 5s;
    -o-animation: fadeIn 5s;
    -ms-animation: fadeIn 5s;
  }

  @keyframes fadeIn {
    0% {
      opacity: 0;
    }
    100% {
      opacity: 1;
    }
  }

  @-moz-keyframes fadeIn {
    0% {
      opacity: 0;
    }
    100% {
      opacity: 1;
    }
  }

  @-webkit-keyframes fadeIn {
    0% {
      opacity: 0;
    }
    100% {
      opacity: 1;
    }
  }

  @-o-keyframes fadeIn {
    0% {
      opacity: 0;
    }
    100% {
      opacity: 1;
    }
  }

  @-ms-keyframes fadeIn {
    0% {
      opacity: 0;
    }
    100% {
      opacity: 1;
    }
  }

</style>
