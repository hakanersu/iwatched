<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Breaking Bad
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex">
                    <div class="w-64 bg-black rounded-md overflow-hidden">
                        <div
                            class="poster"
                        >
                            <img
                                :src="`/storage/posters/${series.poster.image}`"
                                :alt="series.original_title"
                            >
                        </div>
                    </div>
                    <div class="flex-1 pl-5">
                        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                            <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                                <div>
                                    <h3 class="text-2xl leading-6 font-medium text-gray-900" v-text="series.original_title"></h3>
                                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                        {{ series.start_year }} - {{ series.end_year }}
                                    </p>
                                </div>
                                <div class="flex">
                                    <star/>
                                    <div>
                                        10 / {{ series.rating.average_rating }}
                                    </div>
                                </div>
                            </div>
                            <div class="border-t border-gray-200">
                                <dl>
                                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Director
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 flex items-center">
                                            {{ directors[0].primary_name}}
                                            <span class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none text-red-100 bg-indigo-600 rounded-full ml-3">+{{ directors.length}}</span>

                                        </dd>
                                    </div>
                                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Cast
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            // TODO
                                        </dd>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Genre
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" v-text="series.genres">

                                        </dd>
                                    </div>
                                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Running time
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            {{ series.runtime_minutes}}m
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                            <div class="flex space-x-3">
                                <template v-for="season in seasonsNumbers" :key="season">
                                    <season-tab
                                        :label="`Season ${season}`"
                                        :active="Number(season) === selectedSeason"
                                        @click="selectedSeason = Number(season)"
                                        v-if="Number(season) <8"
                                        :watched="isSeriesWatched"
                                    />
                                </template>
                                <div v-if="seasonsNumbers.length>8">
                                    <div class="relative inline-block text-left">
                                        <div>
                                            <button @click="showDropdown = !showDropdown" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500" id="menu-button" aria-expanded="true" aria-haspopup="true">
                                                + {{ seasonsNumbers.length - 7 }} Seasons
                                                <!-- Heroicon name: solid/chevron-down -->
                                                <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div v-if="showDropdown" style="width: 180px;" class="origin-top-right bg-white space-y-3 absolute right-0 mt-2 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                                          <div class="max-h-48 overflow-y-auto p-2">
                                              <template v-for="season in seasonsNumbers" :key="season">
                                                  <season-tab :class="{'mb-2': Number(season) !== totalSeasons}" :label="`Season ${season}`" :active="Number(season) === selectedSeason" @click="selectedSeason = Number(season)" v-if="Number(season) >= 8"/>
                                              </template>
                                          </div>
                                        </div>
                                    </div>

                                </div>
<!--                                <season-tab label="Season 2" :active="true" />-->
<!--                                <season-tab label="Season 3" :watched="true" />-->
                            </div>
                            <div
                                class="bg-gray-200 text-sm py-1 px-1 rounded select-none text-gray-700 inline-block flex items-center">
                                <button
                                    class="rounded px-2 py-1 hover:bg-white hover:shadow hover:text-green-700 font-medium focus:outline-none"
                                    :class="[series.watched ? 'bg-white shadow text-green-700': '']"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <template v-for="(episodes, index) in seasons" :key="`season-${index}`">
                            <div class="border-t border-gray-200" v-if="Number(selectedSeason) === Number(index)">
                                <table class="w-full">
                                    <template v-for="(episode, index) in episodes" :key="episode.id">
                                        <tr >
                                            <td class="px-4 py-5 whitespace-nowrap" :class="[index % 2 === 0 ? 'bg-gray-50' : 'bg-white']">
                                                <i-check :name="`episode-${episode.tconst}`"  v-model="selected[episode.tconst]" :label="episode.original_title"/>
                                            </td>
                                            <td class=" px-4 text-gray-800 w-full max-w-0" :class="[index % 2 === 0 ? 'bg-gray-50' : 'bg-white']">
                                                {{ episode.original_title }}
                                            </td>
                                            <td class=" px-4 text-gray-600  whitespace-nowrap" :class="[index % 2 === 0 ? 'bg-gray-50' : 'bg-white']">
                                                <span class="text-xs opacity-50">{{ `S${episode.season_number}E${episode.episode_number}`}}</span>
                                            </td>
                                        </tr>
                                    </template>
                                </table>
                            </div>
                        </template>
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
import iCheck from '@/Components/Checkbox.vue'
import SeasonTab from "@/Components/SeasonTab";

export default defineComponent({
    props: {
        series: {
            type: [Object, Array],
            default: undefined
        },
        directors: {
            type: [Object, Array],
            default: undefined
        },
        episodes: {
            type: [Object, Array],
            default: undefined
        },
        seasons: {
            type: [Object, Array],
            default: undefined
        }
    },
    components: {
        AppLayout,
        Star,
        iCheck,
        SeasonTab,
    },
    computed: {
        seasonsNumbers() {
            return Object.keys(this.seasons)
        },
        totalSeasons () {
            return this.seasonsNumbers.length
        },
        isSeriesWatched () {
            return !!this.series.watched
        }
    },
    data: () => ({
        selected: {},
        selectedSeason: 1,
        showDropdown: false
    })
})
</script>
