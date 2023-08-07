<template>
  <div
    v-if="showModal"
    class="enter-modal-wrapper"
    style="z-index: 100;"
  >
    <div class="enter-modal-content">
      <p class="enter-title">
        {{ $t('trainings.scientific.enterPopup.popuptitle') }}
      </p>
      <p class="enter-info">
        {{ $t('trainings.scientific.enterPopup.popupdis') }}
      </p>
      <div
        class="flex flex-col flex-wrap items-center justify-center my-4 tablet:flex-row"
      >
        <div
          class="button order-1 px-8 py-3 m-2 button--primary tablet:order-1"
          style="background: 0% 0% no-repeat padding-box padding-box rgb(0, 176, 65);border-radius: 50px;color: #fff;"
        >
          <button @click="closeModal()">
            {{ $t('trainings.scientific.leavePopup.popupbtnstay') }}
          </button>
        </div>
        <div
          class="button order-2 px-8 py-3 m-2 button--secondary tablet:order-2"
          style="background: 0% 0% no-repeat padding-box padding-box rgb(255, 255, 255); border: 2px solid rgb(0, 183, 49); color: rgb(0, 183, 49);border-radius: 50px;"
        >
          <button @click="goBack()">
            {{ $t('trainings.scientific.leavePopup.popupbtnleave') }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import localStore from '@/local-store';

export default {
  data: () => ({
    showModal: false,
  }),
  computed: {
    prevRoutePath() {
      return this.prevRoute ? this.prevRoute.path : '/';
    },
  },
  methods: {
    closeModal() {
      this.showModal = false;
      localStore.commit('saveEnterScientificModalState', false);
    },
    goBack() {
      this.showModal = false;
      localStore.commit('saveEnterScientificModalState', true);
      this.$router.go(-1);
    },
  },
  created() {
    this.showModal = localStore.state.showEnterScientificModal;
  },
};
</script>

<style scoped>
.enter-modal-wrapper {
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

.enter-modal-content {
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

.enter-title {
  font-size: 1.5em;
  font-weight: bold;
  color: rgb(74, 74, 74);
}

.enter-info {
  font-size: .75em;
}

.enter-footer {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  gap: 2em;
  margin-top: 3em;
}

.enter-footer button {
  background-color: #00b731;
  color: #fff;
  border: none;
  outline: none;
  width: 170px;
  padding: .5em 0;
  border-radius: 20px;
  box-sizing: border-box;
}

.enter-footer button:last-child {
  background-color: #fff;
  color: #00b731;
  border: 2px solid #00b731;
}
</style>
