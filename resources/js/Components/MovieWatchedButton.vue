<template>
    <div
        class="bg-white absolute z-10 bg-opacity-30 text-sm py-1 px-1 rounded select-none text-gray-400 flex items-center"
        style="left: 10px; top: 10px"
    >
        <button
            @click="$emit('toggle')"
            class="rounded px-2 py-1 hover:bg-white hover:shadow hover:text-green-700 font-medium focus:outline-none"
            :class="{'bg-white text-green-700': watched}"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                 xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </button>
    </div>
</template>

<script>
export default {
    props: {
        watched: {
            type: Boolean,
            default: false
        }
    }
}
</script>
