<template>
    <div class="btn-status">
        <input type="checkbox" @change="updateStatus()" v-model="checked" name="checkbox" :id="`checkbox${movie.id}`" class="hidden checkbox" />
        <label
            :for="`checkbox${movie.id}`"
            class="btn-change flex items-center p-1 rounded-lg w-12 h-6 cursor-pointer"
            :class="{'checked': watched}"
        ></label>
    </div>

</template>

<script>
    import axios from "axios";
    import dayjs from "dayjs";

    export default {
        props: {
           episode: {
               type: Object,
               default: undefined
           }
        },
        data () {
           return {
               checked: false,
               movie: {}
           }
        },
        computed: {
           watched () {
               return !!this.movie.watched_at
           }
        },
        watch: {
            watched (value) {
                this.checked = value
            }
        },
        mounted() {
            this.checked = this.watched
            this.movie = this.episode
        },
        methods: {
            updateStatus () {
                axios.put(`/watched/${this.movie.tconst}`, { watched: !!this.watched }).then(() => {
                    if (this.watched) {
                        this.movie['watched_at'] = null
                        return
                    }

                    this.movie['watched_at'] = dayjs()
                })
            }
        }

    }
</script>
