<template>
    <div
        class="bg-gray-200 text-sm py-1 px-1 rounded select-none text-gray-700 flex justify-between items-center">
        <button
            class="rounded px-2 py-1 hover:bg-white focus:outline-none mr-1"
            :class="{'bg-white': active}"
        >
            {{ label }}
        </button>
        <button
            v-if="$page.props.user"
            class="rounded px-2 py-1 hover:bg-white hover:shadow hover:text-green-700 font-medium focus:outline-none"
            :class="{'bg-white text-green-700': watched}"
            @click="$emit('toggle')"
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
        label: {
            type: String,
            default: 'Season x'
        },
        active: {
            type: Boolean,
            default: false
        },
        watched: {
            type: Boolean,
            default: false
        }
    }
}
</script>
