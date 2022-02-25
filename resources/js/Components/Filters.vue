<template>
    <div class="flex items-center">
        <svg class="w-6 h-6 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
        <div class="filters flex space-x-3">
            <select v-model="year" @change="update()" class="block w-52 text-gray-700 py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500" name="animals">
                <option value="">
                    Year
                </option>
                <template v-for="year in years" :key="year">
                    <option :value="year" >
                        {{ year}}
                    </option>
                </template>
            </select>
            <select v-model="not_watched" @change="update()" class="block w-52 text-gray-700 py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500" name="animals">
                <option value="">
                    Type: All
                </option>
                <option value="no">
                    Watched
                </option>
                <option value="yes">
                    Not Watched
                </option>
            </select>
            <select v-model="rating" @change="update()" class="block w-52 text-gray-700 py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500" name="animals">
                <option value="">
                    Rating: All
                </option>
                <template  v-for="index in 10" :key="index" >
                    <option :value="11-index" >
                        {{ 11 - index}}
                    </option>
                </template>
            </select>
        </div>
    </div>
</template>

<script>
import {defineComponent} from 'vue'

export default defineComponent({
    computed: {
        years () {
            const year = new Date().getFullYear()
            return Array.from({length: year - 1900}, (value, index) => year - index)
        }
    },
    data: () => ({
        year: '',
        rating: '',
        not_watched: '',
    }),
    mounted () {
        const params = new URLSearchParams(window.location.search)
        this.year = params.has('year') ? params.get('year') : ''
        this.rating = params.has('rating') ? params.get('rating') : ''
        this.not_watched = params.has('not_watched') ? params.get('not_watched') : ''
    },
    methods: {
        update () {
            const data = {page: 1}
            if (this.year !== '') {
                data['year'] = this.year
            }
            if (this.rating !== '') {
                data['rating'] = this.rating
            }
            if (this.not_watched !== '') {
                data['not_watched'] = this.not_watched
            }
            this.$inertia.visit('/movies',{
                data: data
            })
        }
    }
})
</script>
