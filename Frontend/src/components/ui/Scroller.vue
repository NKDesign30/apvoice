<template>
  <span
    class="mouse-indicator no-animation"
    @click="scrollDown()"
  >
    <span class="mouse">
      <span class="wheel" />
    </span>
  </span>
</template>

<script>

export default {

  methods: {
    onScroll() {
      if (window.scrollY > 100) {
        this.$el.classList.add('opacity-0');
      } else {
        this.$el.classList.remove('opacity-0');
      }
    },

    scrollDown() {
      window.scrollTo({
        top: window.innerHeight,
        behavior: 'smooth',
      });
    },
  },
  created() {
    window.setTimeout(() => {
      this.$el.classList.remove('no-animation');
    }, 1000);
  },

  mounted() {
    window.addEventListener('scroll', this.onScroll);
  },

  beforeDestroy() {
    window.removeEventListener('scroll', this.onScroll);
  },
};

</script>

<style lang="scss" scoped>
  /* Mouse indicator */
  .mouse-indicator {
    position: fixed;
    bottom: 150px;
    left: 50%;
    cursor: pointer;
    transform: translateX(-50%);
    transition: all 1s cubic-bezier(0.19, 1, 0.22, 1);
  }

  .mouse-indicator .mouse {
    display: block;
    width: 20px;
    height: 30px;
    background-color: #FFF;
    border-radius: 16px;
    opacity: 1;
    animation: bounce 2.5s linear infinite 1s;

    @apply border-2;
    @apply border-gray-800;
  }

  .mouse-indicator .mouse:after {
    content: '';
    display: block;
    position: absolute;
    bottom: -14px;
    left: 0;
    right: 0;
    margin: auto;
    width: 6px;
    height: 6px;
    border-bottom: 1px solid #06C;
    border-right: 1px solid #06C;
    transform: rotate(45deg);

    @apply border-b;
    @apply border-gray-800;
  }

  .mouse-indicator .mouse .wheel {
    display: block;
    width: 4px;
    height: 20px;
    margin: 5px auto auto;
    overflow: hidden;
    border-radius: 2px;
    // eslint-disable-next-line max-len
    -webkit-mask-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxOC4wLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkNhbHF1ZV8xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCINCgkgdmlld0JveD0iMCAwIDQgMjAiIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDQgMjAiIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KPHBhdGggZD0iTTIsMjBMMiwyMGMtMS4xLDAtMi0wLjktMi0yVjJjMC0xLjEsMC45LTIsMi0yaDBjMS4xLDAsMiwwLjksMiwydjE2QzQsMTkuMSwzLjEsMjAsMiwyMHoiLz4NCjwvc3ZnPg0K);
    transform: translateZ(0);
  }

  .mouse-indicator .mouse .wheel:before {
    content: '';
    display: block;
    width: inherit;
    height: inherit;
    background-color: #494949;
    border-radius: 2px;
    transform: translateY(-60%);
    animation: wheel 2.5s linear infinite 1s;
  }

  /* Initial state */
  .mouse-indicator.no-animation {
    opacity: 0;
    transform: translateY(25px);
  }

  .mouse-indicator.no-animation .mouse,
  .mouse-indicator.no-animation .mouse .wheel:before {
    animation: none;
  }

  /* Keyframes definition */
  @keyframes wheel {
    0% {
      transform: translateY(-60%);
      animation-timing-function: cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    20% {
      transform: translateY(60%);
    }
    22% {
      transform: translateY(60%);
      animation-timing-function: cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    42% {
      transform: translateY(-60%);
    }
    100% {
      transform: translateY(-60%);
    }
  }

  @keyframes bounce {
    0% {
      transform: translateY(0);
      animation-timing-function: cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    20% {
      transform: translateY(6px);
    }
    22% {
      transform: translateY(6px);
      animation-timing-function: cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    42% {
      transform: translateY(0);
    }
    100% {
      transform: translateY(0);
    }
  }

</style>
