<template>
	<div class="bg-white shadow p-1 rounded flex flex-col justify-between movie" v-if="title">
	    <div>
	        <div class="image-placeholder">
	            <a :href="url">
	                <img :src="poster" alt="poster" class="hover:opacity-75 transition ease-in-out duration-150 rounded">
	            </a>
	        </div>
	        <div class="mt-2">
	            <a :href="`https://www.imdb.com/title/${movie.tconst}`" target="_blank" class="text-md mt-2 hover:text-indigo-700">{{ movie.original_title }}</a>
	            <div class="flex items-center justify-between text-gray-400 text-sm mt-1">
	                <div class="flex">
	                    <svg class="fill-current text-orange-500 w-4" viewBox="0 0 24 24"><g data-name="Layer 2"><path d="M17.56 21a1 1 0 01-.46-.11L12 18.22l-5.1 2.67a1 1 0 01-1.45-1.06l1-5.63-4.12-4a1 1 0 01-.25-1 1 1 0 01.81-.68l5.7-.83 2.51-5.13a1 1 0 011.8 0l2.54 5.12 5.7.83a1 1 0 01.81.68 1 1 0 01-.25 1l-4.12 4 1 5.63a1 1 0 01-.4 1 1 1 0 01-.62.18z" data-name="star"/></g></svg>
	                    <span class="ml-1">{{ movie.rating ? movie.rating.average_rating : '-' }}</span>
	                </div>
	                <span>{{ movie.start_year }}</span>
	            </div>
	        </div>
	    </div>
	    <div class="text-gray-400 text-sm w-full">
	        <button
				class="py-1 px-3 mt-3 text-white rounded w-full"
				:class="{'bg-red-500': isWatched, 'bg-indigo-800': !isWatched}"
				@click="setWatched()"
			>{{ isWatched ? 'Remove from watched' : 'Add to watched' }}</button>
	    </div>
	</div>
</template>

<script>
import axios from 'axios'
import dayjs from 'dayjs'

export default {
    props: {
        title: {
            type: Object,
            default: undefined
        }
    },
    data () {
        return {
            movie: {},
            types: {
                'movie': 'movies',
                'tvSeries': 'series'
            }
        }
    },
    computed: {
        poster () {
            if (this.movie.poster) {
                return `/storage/posters/${this.movie.poster.image}`
            }
            return `/storage/posters/movie.jpg`
        },
        titleType () {
            return this.types[this.movie.title_type]
        },
        url () {
            return `/${this.titleType}/${this.movie.tconst}`
        },
        isWatched () {
            return this.movie.watched && this.movie.watched.watched_at
        }
    },
    mounted () {
        this.movie = this.title
    },
    methods: {
        setWatched () {
            axios.put(`/watched/${this.movie.tconst}`, { watched: this.isWatched ? true : false }).then((res) => {
                if (this.isWatched) {
                    this.movie['watched'] = null
                    return
                }

                this.movie['watched'] ={
                    'watched_at': dayjs()
                }
            })
        }
    }
}
</script>
