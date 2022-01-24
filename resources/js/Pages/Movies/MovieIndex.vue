<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Movies
            </h2>
        </template>
        <template #filters>
            <filters/>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-4 gap-4">
                <movie
                    v-for="movie in movies.data"
                    :src="movie.poster.fetched ? `/storage/posters/${movie.poster.image}` : movie.poster.image"
                    :movie="movie"
                    :type="type"
                />
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex justify-between mt-5">
                <Link class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition" :href="prevPage(movies)" v-if="movies.current_page>1">Previous</Link>
                <span v-else></span>
                <Link class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition" :href="nextPage(movies)">Next</Link>
            </div>
        </div>
    </app-layout>
</template>

<script>
import {defineComponent} from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import Movie from '@/Components/Movie.vue'
import iButton from "../../Jetstream/Button";
import Filters from "../../Components/Filters";
import { Link } from '@inertiajs/inertia-vue3'

export default defineComponent({
    props: {
        movies: {
            type: [Object, Array],
            default: undefined
        },
        type: {
            type: String,
            default: 'movies'
        }
    },
    components: {
        AppLayout,
        Movie,
        iButton,
        Filters,
        Link
    },
    methods: {
        nextPage (movie) {
           return this.page(movie, 1)
        },
        prevPage (movie) {
            return this.page(movie, -2)
        },
        page (movie, page) {
            const urlParams = new URLSearchParams(window.location.search);
            let url = `/${this.type}?page=${movie.current_page+page}`
            const year = urlParams.get("year")
            if (year) {
                url += `&year=${year}`
            }
            const rating = urlParams.get("rating");
            if (rating) {
                url += `&rating=${rating}`
            }
            const not_watched = urlParams.get("not_watched");
            if (not_watched) {
                url += `&not_watched=${not_watched}`
            }
            return url
        }
    }
})
</script>
