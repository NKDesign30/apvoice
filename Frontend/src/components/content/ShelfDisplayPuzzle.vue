<template>
  <div class="puzzle container">
    <div ref="puzzleContainer">
      <h3
        class="text-center"
        v-html="$options.filters.formatContent(shelf_display_puzzle.headline)"
      />

      <h6
        class="mt-4 text-center"
        v-html="$options.filters.formatContent(shelf_display_puzzle.subheadline)"
      />

      <div
        v-observe-visibility="visibilityChanged"
        class="puzzle-pieces-container mt-16 flex flex-wrap relative focus:outline-none"
        :style="{
          width: `${puzzleWidth}px`,
          height: `${puzzleHeight}px`,
        }"
      >
        <div
          v-for="piece in sortedPuzzle"
          :key="`${componentKey}${piece.id}`"
          class="puzzle-piece relative"
          :class="{ 'with-outline' : !isFinished}"
          :data-id="piece.id"
          :style="{
            width: `${getPieceDimensions().width}px`,
            height: `${getPieceDimensions().height}px`,
            backgroundImage: `url(${image})`,
            backgroundRepeat: 'no-repeat',
            backgroundSize: `${puzzleWidth}px ${puzzleHeight}px`,
            backgroundPosition: `${getPieceXOffset(piece)} ${getPieceYOffset(piece)}`,
          }"
        >
          <div
            class="puzzle-piece-indicator w-full h-full opacity-50 bg-blue-400"
          />
        </div>
      </div>
    </div>

    <div
      v-if="isFinished"
      class="mt-4"
    >
      <h2
        v-if="hasSuccessMessage"
        class="mb-4 px-8 text-center"
        v-html="$options.filters.formatContent(successMessage)"
      />

      <div class="flex justify-center">
        <apo-button
          class="puzzle-restart-button button button--tiny button--outlined"
          type="button"
          @click="restart"
          v-text="$t('modules.shelfDisplay.restart')"
        />
      </div>
    </div>
  </div>
</template>

<script>

import clone from 'lodash/clone';
import get from 'lodash/get';
import sortBy from 'lodash/sortBy';
import { Swappable } from '@shopify/draggable/lib/es5/draggable.bundle.legacy';

export default {
  props: {
    shelf_display_puzzle: {
      type: Object,
      required: true,
    },
  },

  data() {
    return {
      image: '',
      originalImageWidth: 0,
      originalImageHeight: 0,
      puzzle: [],
      puzzleWidth: 0,
      currentSwap: {
        sourceId: null,
        targetId: null,
      },
      isFinished: false,
      // This property is used in conjunction as the key for each puzzle piece item
      // and is being counted up every time the DOM has been manipulated by the Swappable
      // library. This causes vue to re-render all the list items to reflect the current
      // data state correctly.
      componentKey: 0,
    };
  },

  computed: {
    rows() {
      const rows = get(this.shelf_display_puzzle, 'size.rows') || 4;

      return parseInt(rows, 10);
    },

    columns() {
      const columns = get(this.shelf_display_puzzle, 'size.columns') || 4;

      return parseInt(columns, 10);
    },

    columnWidth() {
      return 100 / this.columns;
    },

    columnHeight() {
      return 100 / this.rows;
    },

    puzzleHeight() {
      const heightRatio = this.puzzleWidth / this.originalImageWidth;

      return this.originalImageHeight * heightRatio;
    },

    sortedPuzzle() {
      return sortBy(this.puzzle, 'index');
    },

    hasSuccessMessage() {
      return this.successMessage && this.successMessage.length > 0;
    },

    successMessage() {
      return this.shelf_display_puzzle.success_message;
    },
  },

  watch: {
    shelf_display_puzzle: {
      immediate: true,
      deep: true,
      handler(shelfDisplayPuzzle) {
        const image = get(shelfDisplayPuzzle, 'image.sizes.post-thumbnail');

        if (image && image.length > 0) {
          this.image = image;
        }
      },
    },

    image: {
      immediate: true,
      handler(image) {
        if (!image || image.length === 0) {
          return;
        }

        this.imageInstance = new Image();

        this.imageInstance.onload = () => {
          this.generatePuzzle();
        };

        this.imageInstance.src = image;
      },
    },
  },

  methods: {
    generatePuzzle() {
      this.storeOriginalImageDimensions();
      this.createPuzzlePieces();
      this.shufflePuzzlePieces();

      this.$nextTick(() => {
        this.createSwappableInstance();
      });
    },

    createPuzzlePieces() {
      let index = 0;
      const puzzle = [];

      for (let row = 0; row < this.rows; row += 1) {
        for (let column = 0; column < this.columns; column += 1) {
          puzzle.push({
            id: `${row}-${column}`,
            row,
            column,
            originalIndex: index,
            index,
          });

          index += 1;
        }
      }

      this.puzzle = puzzle;
    },

    shufflePuzzlePieces() {
      const availableIndices = [...Array(this.columns * this.rows).keys()];

      this.puzzle = this.puzzle.map(piece => {
        const index = availableIndices
          .splice(Math.floor(Math.random() * availableIndices.length), 1);

        /* eslint-disable prefer-destructuring, no-param-reassign */
        piece.index = index[0];
        /* eslint-enable */

        return piece;
      });
    },

    createSwappableInstance() {
      const container = this.$refs.puzzleContainer.querySelector('.puzzle-pieces-container');

      this.swappable = new Swappable(container, {
        draggable: '.puzzle-piece',
      });

      this.swappable.on('swappable:swapped', payload => {
        this.currentSwap.sourceId = payload.data.dragEvent.data.source.dataset.id;
        this.currentSwap.targetId = payload.data.swappedElement.dataset.id;
      });
      this.swappable.on('swappable:stop', () => {
        if (this.isCurrentSwapValid()) {
          const sourcePiece = this.puzzle.find(piece => piece.id === this.currentSwap.sourceId);
          const targetPiece = this.puzzle.find(piece => piece.id === this.currentSwap.targetId);

          const sourceIndex = clone(sourcePiece.index);

          sourcePiece.index = clone(targetPiece.index);
          targetPiece.index = sourceIndex;

          this.$nextTick(() => {
            this.componentKey += 1;

            this.checkWinConditions();
          });
        }

        this.resetCurrentSwap();
      });
    },

    checkWinConditions() {
      this.isFinished = this.puzzle.every(piece => piece.index === piece.originalIndex);
    },

    determinePuzzleWidth() {
      this.puzzleWidth = this.$refs.puzzleContainer.getBoundingClientRect().width;
    },

    storeOriginalImageDimensions() {
      this.originalImageWidth = this.imageInstance.width;
      this.originalImageHeight = this.imageInstance.height;
    },

    getPieceDimensions() {
      return {
        width: this.puzzleWidth / this.columns,
        height: this.puzzleHeight / this.rows,
      };
    },

    getPieceXOffset(piece) {
      const pieceWidth = this.getPieceDimensions().width;
      const pieceOffset = pieceWidth * piece.column * -1;

      return `${pieceOffset}px`;
    },

    getPieceYOffset(piece) {
      const pieceHeight = this.getPieceDimensions().height;
      const pieceOffset = pieceHeight * piece.row * -1;

      return `${pieceOffset}px`;
    },

    isCurrentSwapValid() {
      return this.currentSwap.sourceId !== null && this.currentSwap.targetId !== null;
    },

    resetCurrentSwap() {
      this.currentSwap.sourceId = null;
      this.currentSwap.targetId = null;
    },

    restart() {
      this.isFinished = false;
      this.shufflePuzzlePieces();
    },

    visibilityChanged(isVisible) {
      if (isVisible) {
        this.determinePuzzleWidth();
      }
    },
  },

  mounted() {
    this.determinePuzzleWidth();

    const onResizeListener = () => {
      this.determinePuzzleWidth();
    };

    window.addEventListener('resize', onResizeListener);

    this.$once('hook:destroyed', () => {
      window.removeEventListener('resize', onResizeListener);
    });
  },
};

</script>

<style lang="scss" scoped>

.puzzle {
  &-piece {

    &.with-outline {
      outline: 2px solid #0099FF;
    }

    &-indicator {
      @apply opacity-0;

      transition: opacity 0.1s ease;
    }

    &.draggable-source--is-dragging &-indicator {
      @apply opacity-75;
    }
  }

  &-win-overlay {
    @apply absolute;
    @apply left-0;
    @apply top-0;
    @apply w-full;
    @apply h-full;
    @apply bg-blue-500;
    @apply z-10;
    @apply opacity-50;

    animation-name: flash;
    animation-duration: 1s;
    animation-timing-function: ease;
  }

  &-restart-button {
    @apply p-0;
    @apply text-gray-900;
    @apply underline;
    @apply text-3xl;
    @apply font-normal;
  }

  /deep/ .draggable-mirror {
    @apply opacity-75;
  }
}

@keyframes flash {
  0%,
  25%,
  75% {
    @apply opacity-0;
  }

  50%,
  100% {
    @apply opacity-50;
  }
}

</style>
