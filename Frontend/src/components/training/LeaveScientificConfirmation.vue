<template>
  <div
    v-if="showModal"
    class="leave-modal-wrapper"
    style="z-index: 100;"
  >
    <div class="leave-modal-content">
      <p class="leave-title">
        {{ $t('trainings.scientific.leavePopup.popuptitle') }}
      </p>
      <p class="leave-info">
        {{ $t('trainings.scientific.leavePopup.popupdis') }}
      </p>
      <div
        class="flex flex-col flex-wrap items-center justify-center mt-6 tablet:flex-row tablet:mt-12">
        <div class="button order-2 px-8 py-3 m-2 button--secondary tablet:order-1"
             style="background: 0% 0% no-repeat padding-box padding-box rgb(0, 176, 65);border-radius: 50px;color: #fff;">
          <button @click="showModal = false">
            {{ $t('trainings.scientific.leavePopup.popupbtnstay') }}
          </button>
        </div>

        <div class="button order-1 px-8 py-3 m-2 button--primary tablet:order-2"
             style="background: 0% 0% no-repeat padding-box padding-box rgb(255, 255, 255); border: 2px solid rgb(0, 183, 49); color: rgb(0, 183, 49);border-radius: 50px;">
          <button @click="navigateTarget">
            {{ $t('trainings.scientific.leavePopup.popupbtnleave') }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import bus from '@/bus';

export default {
  data: () => ({
    showModal: false,
    target: '',
  }),
  methods: {
    navigateTarget() {
      this.showModal = false;
      setTimeout(() => {
        window.location = this.target;
      }, 100);
    },
  },
  created() {
    this.showModal = false;
  },
  mounted() {
    // router has indicated a navigation away from 'scientific' to 'to.fullPath'
    bus.$on('routeLeaveScientific', to => {
      this.showModal = true;
      this.target = to.fullPath;
    });
  },
}
</script>

<style scoped>
.leave-modal-wrapper {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background-color: rgba(0, 0, 0, .5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.leave-modal-content {
  background-color: #fff;
  width: 95%;
  max-width: 700px;
  padding: 2em 2em;
  text-align: center;
  animation: .3s pop linear;
}

@keyframes pop {
  0% {
    opacity: 0;
    transform: scale(.6);
  }
  100% {
    opacity: 1;
    transform: scale(1);
  }
}

.leave-title {
  font-size: 1.5em;
  font-weight: bold;
  color: rgb(74, 74, 74);
}

.leave-info {
  font-size: .75em;
}

.leave-footer {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  gap: 2em;
  margin-top: 3em;
}

.leave-footer button {
  background-color: #00b731;
  color: #fff;
  border: none;
  outline: none;
  width: 170px;
  padding: .5em 0;
  border-radius: 20px;
  box-sizing: border-box;
}

.leave-footer button:last-child {
  background-color: #fff;
  color: #00b731;
  border: 2px solid #00b731;
}
</style>
