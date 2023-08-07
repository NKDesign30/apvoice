<template>
  <div class="inline-block h-44 pt-4 mr-5" @click="handleclick">
    <div v-if="allDone" class="relative rounded-full bg-white flex justify-center items-center" :style="getCompletedBackgroundStyle" :title="scorePercent">
    </div>
    <div v-else class="arc-container" :style="getArcContainerBackgroundStyle" :title="scorePercent">
      <div class="arc-inner" :style="getArcInnerBackgroundStyle">
      </div>
    </div>
    <div class="text-center text-sm h-9 pt-2">
      {{ categoryName }}
    </div>
  </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex';
import VueRouter from '../../../router/index'
import {
  FILTER_TRAININGS,
  CLEAR_TRAININGS,
  SHOW_TAB,
  SETCATEGORY,
  SHOW_TAB_CATEGORY
} from '@/store/types/action-types';

export default {
  
  name: "AchievementItem",
  props: {
    id: {
      type: Number,
      required: true
    },
    categoryName: {
      type: String,
      required: true
    },
    imageComplete: {
      type: String,
      required: true
    },
    imageIncomplete: {
      type: String,
      required: true
    },
    completed: {
      type: Number,
      default: 0,
      required: true
    },
    available: {
      type: Number,
      default: 0,
      required: true
    },
    slug: {
      type: String,
      required: true
    },
  
  
  },
  computed: {
    getCompletedBackgroundStyle() {
      return 'width: 106px; height: 106px;background: url(' + this.imageComplete + '); background-size: contain;';
    },
    getArcInnerBackgroundStyle() {
      return 'background: url(' +  this.imageIncomplete +'); background-size: contain;width:90px;height:90px;';
    },
    getArcContainerBackgroundStyle() {
      let degrees = this.scoreDegrees;
      return 'background: conic-gradient(#5AA9F5 ' + degrees +'deg, transparent calc(' + degrees +'deg + 0.5deg) 100%), conic-gradient(#ccebff 360deg, transparent calc(360deg + 0.5deg) 100%);'
    },
    scorePercent() {
      return Math. round((this.completed / this.available) * 100) + '%';
    },
    scoreDegrees() {
      return (this.completed / this.available) * 360;
    },
    allDone() {
      return this.completed === this.available;
    },
    ...mapGetters(['filter', 'categoriesIds']), 

  }
  ,
  methods:{
  ...mapActions([
      FILTER_TRAININGS,
      CLEAR_TRAININGS,
      SHOW_TAB,
      SETCATEGORY,
      SHOW_TAB_CATEGORY
    ]),
    handleclick(){
      if(this.slug=="products"){
        this[CLEAR_TRAININGS]();
        this[FILTER_TRAININGS](this.id );
        this[SHOW_TAB]();
      //  this.$router.push({ name: 'training' ,params: { type: this.slug ,category:this.id },  })  
        this.$router.push({ name: 'trainings' })  
       // window.scrollTo(500, document.body.scrollHeight);
       document.getElementById("products").scrollIntoView();
      }else if(this.slug=="category"){
        this[SETCATEGORY](this.id );
        this[SHOW_TAB_CATEGORY]();
        this.$router.push({ name: 'trainings' })
        document.getElementById("category").scrollIntoView();
        //window.scrollTo(0, document.body.scrollHeight);
      }
      
    },
  },
  created(){
     let items=document.querySelectorAll(".VueCarousel-slide");
      items.forEach((item)=>{
        item.style.setProperty("flex-basis", "0", "important");
    })
  }
}
</script>

<style scoped>

:root {
  --degree: 120deg;
  --color: #1f36aa;
}

.arc-container {
  height: 106px;
  width: 106px;
  border-radius: 50%;
}

.arc-inner {
  height: 84%;
  width: 84%;
  top: 8%;
  left: 8%;
  position: relative;
  border-radius: 50%;
}


</style>
