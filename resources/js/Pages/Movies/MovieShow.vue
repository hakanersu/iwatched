<template>
    <app-layout :title="movie.original_title">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight" v-text="movie.primary_title" />
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex">
                    <div class="max-w-md bg-black rounded-md overflow-hidden relative" v-if="movie">
                        <div
                            class="poster"
                            href="/movies/1"
                        >
                            <img
                                :src="`/storage/posters/${movie.poster.image}`"
                                :alt="movie.original_title"
                            >
                        </div>
                            <movie-watched-button v-if="$page.props.user"/>
                    </div>
                    <div class="flex-1 px-5">
                        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                            <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                               <div>
                                   <h3 class="text-2xl leading-6 font-medium text-gray-900" v-text="movie.primary_title" />
                                   <p class="mt-1 max-w-2xl text-sm text-gray-500" v-text="movie.start_year"/>
                               </div>
                                <div class="flex">
                                    <star />
                                    <div >
                                        {{ movie.rating.average_rating }} / 10
                                    </div>
                                </div>
                            </div>
                            <div class="border-t border-gray-200">
                                <dl>
                                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Director
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            {{ directorList }}
                                        </dd>
                                    </div>
                                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Cast
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                           <ul class="comma-list">
                                               <template v-for="actor in actors">
                                                   <li>
                                                       <a target="_blank" class="text-indigo-700 hover:text-indigo-900" :href="`https://www.imdb.com/name/${actor.name.nconst}`" v-text="actor.name.primary_name" />
                                                   </li>
                                               </template>

                                           </ul>
                                        </dd>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Genre
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            {{ movie.genres }}
                                        </dd>
                                    </div>
                                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Running time
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            {{ movie.runtime_minutes }} minutes
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import {defineComponent} from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import Star from '@/Components/Star.vue'
import MovieWatchedButton from "@/Components/MovieWatchedButton";

export default defineComponent({
    props: {
        movie: {
            type: Object,
            default: undefined
        },
        directors: {
            type: Array,
            default: undefined
        }
    },
    components: {
        AppLayout,
        Star,
        MovieWatchedButton
    },
    computed: {
        directorList () {
            return this.directors.map(item => {
                return item.primary_name
            }).join()
        },
        actors () {
            return this.movie.principal.filter(item => {
                return item.category === 'actor'
            })
        }
    }
})
</script>
