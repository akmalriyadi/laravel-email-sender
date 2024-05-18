<style lang="scss" scoped>
.el-button {
    @apply w-full py-4 h-0 font-normal #{!important};
}
</style>
<template>
    <div :class="`${width}`">
        <Link :href="link" v-if="type == 'link'">
        <el-button :type="colorType">
            <slot></slot>
        </el-button>
        </Link>
        <el-button v-else :type="colorType">
            <slot></slot>
        </el-button>
    </div>
</template>
<script setup>
import { Link } from '@inertiajs/vue3'
const props = defineProps({
    type: {
        type: String,
        default: 'button'
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
    colorType: {
        type: String,
        default: 'primary'
    }
})
const defaultClass = 'px-4 py-1 rounded flex items-center justify-center'
</script>