<template>
    <div>
        <autocomplete
            :search="search"
            aria-label="Search for title"
            placeholder="Search for title"
            :get-result-value="getResultValue"
            :debounceTime="300"
        >
            <template #result="{ result, props }">
                <li
                    v-bind="props"
                    class="autocomplete-result wiki-result flex justify-between"
                    @click="redirect(result)"
                >
                    <div class="search-title">
                        {{ result.title }}
                    </div>
                    <div class="flex">
                        <div class="bg-gray-100 text-gray-800 search-year inline-flex items-center px-2 py-0.5 rounded text-xs font-medium leading-4 mr-2">
                            {{ result.start_year }}
                        </div>
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium leading-4"
                            :class="{'bg-indigo-100 text-indigo-800': result.title_type === 'movie', 'bg-purple-100 text-purple-800': result.title_type !== 'movie'}"
                        >
                            {{ result.title_type === 'movie' ? 'Movie' : 'Tv Series'}}
                        </span>
                        <div
                            class="ml-3 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium leading-4 mr-2"
                            :class="{'bg-green-100 text-green-800':result.watched, 'bg-red-100 text-red-800': !result.watched }"
                        >
                            {{ result.watched ? 'Watched' : 'Not watched' }}
                        </div>
                    </div>

                </li>
            </template>
        </autocomplete>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        data() {
            return {
                results: []
            }
        },
        methods: {
            search(e) {
                return axios.get(`/search?search=${e}`).then(res => {
                    const result = res.data.titles.map(item => {
                        return {
                            tconst: item.tconst,
                            title_type: item.title_type,
                            title: item.original_title,
                            start_year: item.start_year,
                            watched: item.watched
                        }
                    })

                    return result
                })
            },
            getResultValue (result) {
                return result.title
            },
            redirect(result) {
                if (result.title_type === 'movie') {
                    window.location.href = `/movies/${result.tconst}`
                }

                if (result.title_type === 'tvSeries') {
                    window.location.href = `/series/${result.tconst}`
                }

            }
        }
    }

</script>
