<template>
  <div
    v-if="movie"
    class="rounded-md overflow-hidden movie-card flex flex-col justify-between relative"
    :class="{'bg-green-800': watched, 'bg-black': !watched}"
  >
    <movie-watched-button
      :watched="watched"
      @toggle="toggleWatched()"
    />
    <div class="triangle absolute top-0 right-0 z-10">
      <a
        :href="`https://www.imdb.com/title/${movie.tconst}`"
        target="_blank"
      >
        <svg
          class="w-4 h-4 mt-1 mr-1 z-50 text-white"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"
          ></path>
        </svg>
      </a>
    </div>
    <Link
      class="poster-card"
      :class="{'poster-green': watched, 'poster': !watched}"
      :href="`/${type}/${movie.tconst}`"
    >
    <img
      :src="src"
      alt="Free Guy"
    >
    </Link>
    <div class="flex items-center justify-between py-5 px-5 text-gray-200 text-lg relative pt-16">
      <Link
        :href="`/${type}/1`"
        class="text-gray-300 hover:text-gray-100"
      >
      {{ movie.primary_title }}
      </Link>
      <div class="flex items-center">
        <star />
        <span>{{ movie.rating.average_rating}}</span>
      </div>
    </div>
  </div>
</template>

<script>
import { defineComponent } from 'vue'
import { Link } from '@inertiajs/inertia-vue3'
import Star from '@/Components/Star.vue'
import MovieWatchedButton from "./MovieWatchedButton"

export default defineComponent({
  props: {
    active: {
      type: Boolean,
      default: false
    },
    type: {
      type: String,
      default: 'movies'
    },
    src: {
      type: String,
      default: undefined
    },
    movie: {
      type: Object,
      default: undefined
    }
  },
  components: {
    Link,
    Star,
    MovieWatchedButton
  },
  data: () => ({
    watched: false,
  }),
  mounted () {
    this.watched = this.active
  },
  methods: {
    toggleWatched () {
      this.watched = !this.watched
    }
  }
})
</script>
