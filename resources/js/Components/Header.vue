<template>
    <div class="flex justify-end items-center h-full py-2">
        <el-dropdown class="focus-visible:outline-none">
            <div ref="dropdownParent"
                class="focus-visible:outline-none flex items-center space-x-4 bg-white py-2 px-4 rounded">
                <img src="/assets/images/avatar2.png" class="w-10 h-10 object-fill bg-blue-500 rounded-full" alt="">
                <div class="space-y-1 text-blue-500">
                    <p class="font-semibold">Admin</p>
                    <p>Superadmin</p>
                </div>
            </div>
            <template #dropdown>
                <el-dropdown-menu :style="{ width: dropdownParentWidth + 'px' }">
                    <el-dropdown-item @click="submitLogout()" divided>Logout</el-dropdown-item>
                </el-dropdown-menu>
            </template>
        </el-dropdown>
    </div>
</template>
<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useAuthComposables } from '@/Composables';
import { useWebStore } from '@/Stores';

const { handleLogout } = useAuthComposables()
const dropdownParent = ref()
const dropdownParentWidth = ref(0)

const submitLogout = async () => {
    try {
        await handleLogout()
        // useWebStore().offLoading()
    } catch (e) {
        useWebStore().offLoading()

    }
}

onMounted(() => {
    if (dropdownParent.value) {
        dropdownParentWidth.value = dropdownParent.value.offsetWidth
    }
})
</script>