<template>
    <app-layout title="TV Series">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                TV Series
            </h2>
        </template>
        <template #filters>
            <filters />
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-4 gap-4">
                <movie type="series" name="Matrix: Ressurection" src="https://m.media-amazon.com/images/M/MV5BOTY2NzFjODctOWUzMC00MGZhLTlhNjMtM2Y2ODBiNGY1ZWRiXkEyXkFqcGdeQXVyMDM2NDM2MQ@@._V1_.jpg"/>
                <movie type="series" :active="true"  name="Matrix: Ressurection" src="https://m.media-amazon.com/images/M/MV5BOTY2NzFjODctOWUzMC00MGZhLTlhNjMtM2Y2ODBiNGY1ZWRiXkEyXkFqcGdeQXVyMDM2NDM2MQ@@._V1_.jpg"/>
                <movie type="series"  name="Matrix: Ressurection" src="https://m.media-amazon.com/images/M/MV5BOTY2NzFjODctOWUzMC00MGZhLTlhNjMtM2Y2ODBiNGY1ZWRiXkEyXkFqcGdeQXVyMDM2NDM2MQ@@._V1_.jpg"/>
                <movie type="series" />
                <movie type="series" :active="true"  name="Matrix: Ressurection" src="https://m.media-amazon.com/images/M/MV5BOTY2NzFjODctOWUzMC00MGZhLTlhNjMtM2Y2ODBiNGY1ZWRiXkEyXkFqcGdeQXVyMDM2NDM2MQ@@._V1_.jpg"/>
                <movie type="series"  name="Matrix: Ressurection" src="https://m.media-amazon.com/images/M/MV5BOTY2NzFjODctOWUzMC00MGZhLTlhNjMtM2Y2ODBiNGY1ZWRiXkEyXkFqcGdeQXVyMDM2NDM2MQ@@._V1_.jpg"/>
                <movie type="series"  name="Matrix: Ressurection" src="https://m.media-amazon.com/images/M/MV5BOTY2NzFjODctOWUzMC00MGZhLTlhNjMtM2Y2ODBiNGY1ZWRiXkEyXkFqcGdeQXVyMDM2NDM2MQ@@._V1_.jpg"/>
                <movie type="series"  name="Matrix: Ressurection" src="https://m.media-amazon.com/images/M/MV5BOTY2NzFjODctOWUzMC00MGZhLTlhNjMtM2Y2ODBiNGY1ZWRiXkEyXkFqcGdeQXVyMDM2NDM2MQ@@._V1_.jpg"/>
            </div>
        </div>
    </app-layout>
</template>

<script>
import {defineComponent} from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import Movie from '@/Components/Movie.vue'
import Filters from "@/Components/Filters";
export default defineComponent({
    components: {
        AppLayout,
        Movie,
        Filters,
    },
})
</script>
