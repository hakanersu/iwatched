<template>
    <div class="flex-1 ml-5 relative">
        <div class="relative ">
            <svg class="w-6 h-6 text-indigo-700 absolute top-5 left-3" fill="none" stroke="currentColor"
                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <input
                type="text"
                class="search-input border-gray-200 mt-3 rounded  w-full pl-10"
                placeholder="Search movie or tv series"
                @keyup="search"
                v-model="searching"
            >
        </div>
        <div v-if="results.length>0" class="absolute z-10 inset-x-0 px-6 py-3  mt-4 overflow-y-auto bg-white border border-gray-300 rounded-md max-h-72 dark:bg-gray-800 dark:border-transparent">
            <div class="relative h-full w-full h-32 flex items-center justify-center" v-if="loading">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
           <template v-else>
               <a href="#" class="flex justify-between py-1" v-for="result in results">
                   <h3 class="font-medium text-gray-700 dark:text-gray-100 hover:underline">{{ result.primary_title }}</h3>
                   <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ result.start_year }} | 7.3 | {{ result.title_type }}</p>
               </a>
           </template>
        </div>
    </div>
</template>

<script>
import {defineComponent} from 'vue'
import {debounce} from "lodash";

export default defineComponent({
    components: {

    },

    data() {
        return {
            show: false,
            searching: '',
            results: [],
            loading: false,
        }
    },

    methods: {
        search: debounce(function () {
            this.loading = true
            fetch('/search?q=' + this.searching)
                .then(response => response.json())    // one extra step
                .then(data => {
                    this.results = data
                    this.loading = false
                })
        }, 350)
    },
})
</script>
