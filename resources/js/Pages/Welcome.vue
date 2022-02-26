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
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
              Welcome to iWatched. You can register to track movies or tv shows that you watched.
            </div>
        </div>
    </app-layout>
</template>

<script>
import {defineComponent} from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import Movie from '@/Components/Movie.vue'
import iButton from "../Jetstream/Button";
import Filters from "../Components/Filters";
import { Link } from '@inertiajs/inertia-vue3'

export default defineComponent({
    components: {
        AppLayout,
        Movie,
        iButton,
        Filters,
        Link
    },
    methods: {

    }
})
</script>
