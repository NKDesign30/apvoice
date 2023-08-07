<template>
  <div>
    <div class="mb-9 w-full pl-1" style="height: 192px !important;"
         v-show="achievementsData.length  === 0">
      <div class="h-9 text-left text-2xl">
        {{ $t('welcome.achievments') }}
      </div>
      <div class="text-left py-8">{{ $t('loaders.yourData') }}</div>
    </div>
    <apo-wait for="trainings.series">
      <div class="mb-9 fade-in" v-cloak v-show="achievementsData.length > 0">
        <div class="h-9 pl-0 tablet:pl-1 text-left text-2xl">
          {{ $t('welcome.achievments') }}
        </div>
        <div class="block" v-cloak>
          <carousel
            :per-page="carouselItemsDisplayed"
            :pagination-enabled="false"
            class="custom"
          >
            <slide v-for="(achievement, index) in achievementsData" :key="index"
                   class="cursor-pointer flex justify-start">
              <achievement-item :available="achievement.available"
                                :completed="achievement.completed"
                                :image-complete="achievement.imageComplete"
                                :image-incomplete="achievement.imageIncomplete"
                                :category-name="achievement.category"
                                :slug="achievement.slug"
                                :id="achievement.id"

              >
              </achievement-item>
            </slide>
          </carousel>
        </div>
      </div>
    </apo-wait>
  </div>
</template>

<script>
import AchievementItem from '@/components/user/performance/AchievementItem.vue';
import {mapActions, mapGetters} from 'vuex';
import {
  TRAININGS_FETCH_ALL_SERIES,
  TAXONOMIES_FETCH_TRAINING_CATEGORIES, TRAININGS_UPDATE_CURRENT_TRAINING,
} from '@/store/types/action-types';
import LoadingOverlay from "@/components/ui/LoadingOverlay";

const screens = require('@/tailwind/Screens');

export default {
  name: "Achievements",
  components: {
    'achievement-item': AchievementItem,
    'apo-loading-overlay': LoadingOverlay
  },
  data() {
    return {
      availableCategoryTrainings: [],
      achievementsData: [],
      windowWidth: window.innerWidth,
      desktopWidth: screens.desktopWidth,
      tabletWidth: screens.tabletWidth,
      // original static dummy data: no longer in use
      achievements: [
        {
          id: 1,
          category: "Cardiac Health",
          imageComplete: "HerzComplete.png",
          imageIncomplete: "HerzIncomplete.jpg",
          completed: 8,
          available: 8
        },
        {
          id: 2,
          category: "Colds and Flu",
          imageComplete: "HerzComplete.png",
          imageIncomplete: "HerzIncomplete.jpg",
          completed: 2,
          available: 6
        },
        {
          id: 3,
          category: "Sleep",
          imageComplete: "HerzComplete.png",
          imageIncomplete: "HerzIncomplete.jpg",
          completed: 1,
          available: 5
        },
        {
          id: 4,
          category: "Cardiac Health 2",
          imageComplete: "HerzComplete.png",
          imageIncomplete: "HerzIncomplete.jpg",
          completed: 8,
          available: 8
        },
        {
          id: 5,
          category: "Colds and Flu 2",
          imageComplete: "HerzComplete.png",
          imageIncomplete: "HerzIncomplete.jpg",
          completed: 2,
          available: 6
        },
        {
          id: 6,
          category: "Sleep 2",
          imageComplete: "HerzComplete.png",
          imageIncomplete: "HerzIncomplete.jpg",
          completed: 1,
          available: 5
        }
      ]
    }
  },
  computed: {
    ...mapGetters([
      'trainingSeries',
      'trainingCategories',
      'availableTrainingSeries',
      'trainingCategory',
      'user'
    ]),
    carouselItemsDisplayed() {
      if (this.windowWidth >= this.desktopWidth) {
        return 5;
      } else if (this.windowWidth >= this.tabletWidth) {
        return 3;
      } else {
        return 3;
      }
    },
    trainingProductsForFilter() {
      // there must be trainings of this category available
      let availableCategoryIds = this.allProductTrainingSeries.reduce((availableCategories, series) => [...availableCategories, ...series.categories], [])
        .filter((id) => id !== this.categoryCategory.id && id !== this.productCategory)
      return this.trainingCategories.filter((category) => availableCategoryIds.includes(category.id))
    },
     allProductTrainingSeries() {
      return this.trainingSeries.filter(item => {
        return item.trainings.length > 0 && this.isProductTraining(item) && parseInt(item.trainings[0].isPremium) === 0;
    });
    },
    trainingCategoriesForFilter() {
      // there must be trainings of this category available
      let availableCategoryIds = this.allCategoryTrainingSeries.reduce((availableCategories, series) => [...availableCategories, ...series.categories], [])
        .filter((id) => id !== this.categoryCategory.id && id !== this.productCategory)
      return this.trainingCategories.filter((category) => availableCategoryIds.includes(category.id))
    },
     allCategoryTrainingSeries() {
      return this.trainingSeries.filter(item => {
        return item.trainings.length > 0 && this.isCategoryTraining(item) && parseInt(item.trainings[0].isPremium) === 0;
    });
    },
  },
  methods: {
    ...mapActions([
      TAXONOMIES_FETCH_TRAINING_CATEGORIES,
      TRAININGS_FETCH_ALL_SERIES
    ]),
    onResize() {
      this.windowWidth = window.innerWidth
    },
    isCategoryTraining(trainingItem) {
      if (this.categoryCategory === null) {
        return false;
      }
      if (typeof this.categoryCategory === 'object') {
        return trainingItem.categories.includes(this.categoryCategory.id);
      }
      return false;
    },
    isProductTraining(trainingItem) {
      if (this.productCategory === null) {
        return false;
      }
      if (typeof this.productCategory === 'object') {
        return trainingItem.categories.includes(this.productCategory.id);
      }
      return false;
    },
    userHasCompletedTraining(training) {
      let trainingResult = this.user.trainingResults[training.trainings[0].id];
      if (trainingResult !== undefined) {
        return trainingResult.is_complete === '1'
      } else {
        return false;
      }
    }
  },
  mounted() {
    this.$nextTick(() => {
      window.addEventListener('resize', this.onResize);
    });
  },
  beforeDestroy() {
    window.removeEventListener('resize', this.onResize);
  },
  created() {
    this[TAXONOMIES_FETCH_TRAINING_CATEGORIES]().then(data => {
      this.categoryCategory = data.find(item => item.slug === 'category');
      this.productCategory = data.find(item => item.slug === 'products');
    }).then(data => {
      this[TRAININGS_FETCH_ALL_SERIES]().then(data => {
          this.availableCategoryTrainings = this.trainingSeries.filter(item => item.trainings.length > 0 && (this.isCategoryTraining(item)|| this.isProductTraining(item) ) && parseInt(item.trainings[0].isPremium) === 0)
          
          this.trainingCategories.filter(category => category.activeAchievements && category.id !== this.categoryCategory.id && category.id !== this.productCategory.id)
            .map(category => {
              let trainingsThisCategory = this.availableCategoryTrainings.filter(
                training => training.categories.includes(category.id)
              )
              if (trainingsThisCategory.length) {
                 this.trainingProductsForFilter.map((item)=>{ 
                  if(category.id===item.id){
                       category.type="products";
                  }
                  });
               this.trainingCategoriesForFilter.map((item)=>{ 
                  if(category.id===item.id && category.type!="products"){
                       category.type="category";
                  }
                  });

                let numTrainingsCompleted = 0;
                trainingsThisCategory.map(training => {
                  numTrainingsCompleted += this.userHasCompletedTraining(training) ? 1 : 0;
                })
                if (!category.imageComplete
                  || !category.imageIncomplete
                ) {
                  this.achievementsData.push(
                    {
                      id: category.id,
                      category: category.name,
                      imageIncomplete: 'https://apovoicenonprodstorage.blob.core.windows.net/mediauploads/2022/05/HerzIncomplete-6290d8391fc99.jpg',
                      imageComplete: 'https://apovoicenonprodstorage.blob.core.windows.net/mediauploads/2022/05/HerzComplete-6290d8377a8ba.png',
                      completed: numTrainingsCompleted,
                      available: trainingsThisCategory.length,
                      slug: category.type
                    }
                  )
                } else {
                  this.achievementsData.push(
                    {
                      id: category.id,
                      category: category.name,
                      imageComplete: category.imageComplete.url,
                      imageIncomplete: category.imageIncomplete.url,
                      completed: numTrainingsCompleted,
                      available: trainingsThisCategory.length,
                      slug: category.type
                    })
                }
              }
            })
        }
      )
    })
  }
}
</script>

<style scoped>
.VueCarousel-slide {
  flex-basis: auto !important; /* prevents spacing between the discs */
}
.custom{
  max-width: 615px;
}
.custom{
  max-width: 615px;
}

fade-in {
  animation: fadeIn 2s;
  -webkit-animation: fadeIn 2s;
  -moz-animation: fadeIn 2s;
  -o-animation: fadeIn 2s;
  -ms-animation: fadeIn 2s;
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
