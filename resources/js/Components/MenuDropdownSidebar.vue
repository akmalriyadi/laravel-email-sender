<template>
    <div>
        <el-sub-menu :index="data.link">
            <template #title>
                <i :class="data.icon"></i>
                <span class="">{{ data.label }}</span>
            </template>
            <Link v-for="list in data.list" :href="list.link">
            <el-menu-item :index="list.link">{{ list.label }}</el-menu-item>
            </Link>
        </el-sub-menu>

    </div>
</template>
<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
const props = defineProps({
    data: {
        type: Object,
        default: () => ({}),
    },
})
</script>