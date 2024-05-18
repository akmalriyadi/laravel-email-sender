<template>
    <div>
        <Link :href="link" class="w-full">
        <el-menu-item :index="link">
            <!-- <div class="content-menu-sidebar">
                <i :class="icon"></i>
                <span class="">{{ label }}</span>
            </div> -->
            <i :class="icon"></i>
            <span class="">{{ label }}</span>
        </el-menu-item>
        </Link>

    </div>
</template>
<script setup lang="ts">
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    label: String,
    icon: {
        type: String,
        default: 'fas fa-home'
    },
    link: {
        type: String,
        default: ''
    }
})
</script>
<style lang="scss">
.el-menu-item {
    @apply w-full;
}
</style>