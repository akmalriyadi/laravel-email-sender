<style lang="scss" scoped>
.primary {
    @apply bg-blue-500 hover:bg-blue-400;
}
</style>
<template>
    <div>
        <Link :href="link" v-if="type == 'link'" :class="`${defaultClass} ${width} ${className}`">
        <slot></slot>
        </Link>
        <button type="button" :disabled="disabled" v-else :class="`${defaultClass} ${width} ${className}`">
            <slot></slot>
        </button>
    </div>
</template>
<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { computed } from 'vue'
const props = defineProps({
    type: {
        type: String,
        default: 'button'
    },
    disabled: {
        type: Boolean,
        default: false
    },
    link: {
        type: String,
        default: ''
    },
    width: {
        type: String,
        default: 'w-fit'
    },
    className: {
        type: String,
        default: ''
    },
    backgroundColor: {
        type: String,
        default: 'bg-blue-500'
    },
    textColor: {
        type: String,
        default: 'text-white'
    },
    color: {
        type: String,
        default: ''
    }
})
// const defaultClass = 'px-4 py-2 text-md rounded flex items-center justify-center'
const defaultClass = computed(() => {
    let backgroundColor = props.backgroundColor
    let textColor = props.textColor
    if (props.color == 'primary') {
        backgroundColor = 'bg-blue-500 hover:bg-blue-400'
    }
    return `px-4 py-1.5 text-md rounded flex items-center justify-center ${backgroundColor} ${textColor}`
})
</script>