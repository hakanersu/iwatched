<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pb-10">
                <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg text-gray-600">
                    <div class="grid grid-cols-1 md:grid-cols-3">
                        <div class="p-6 text-center">
                            <div class="text-lg leading-7 font-semibold text-gray-900 dark:text-white">Movies watched
                            </div>
                            <h1 class="text-5xl">
                                {{ watched.movie }}
                            </h1>
                        </div>

                        <div
                            class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l text-center">
                            <div class="text-lg leading-7 font-semibold text-gray-900 dark:text-white">TV Series
                                watched
                            </div>
                            <h1 class="text-5xl">
                                {{ watched.tvseries }}
                            </h1>
                        </div>
                        <div
                            class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l text-center">
                            <div class="text-lg leading-7 font-semibold text-gray-900 dark:text-white">Episodes
                                watched
                            </div>
                            <h1 class="text-5xl">
                                {{ watched.tvepisode }}
                            </h1>
                        </div>
                    </div>
                </div>


                <!-- This example requires Tailwind CSS v2.0+ -->
                <div class="flex flex-col mt-5">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Year
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Count
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                    <template v-for="year in watchedByYears" :key="year.start_year">
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    {{ year.start_year }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ year.count }}
                                            </td>

                                        </tr>
                                    </template>
                                    </tbody>
                                </table>
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
import Welcome from '@/Jetstream/Welcome.vue'

export default defineComponent({
    components: {
        AppLayout,
        Welcome,
    },
    props: {
        watched: String,
        watchedByYears: String,
    }
})
</script>
