<style lang="scss"></style>
<template>
    <div class="common-layout" scroll-region>
        <el-container class="min-h-screen">
            <el-aside width="240px" class="shadow">
                <Sidebar />
            </el-aside>
            <el-container>
                <modal-loading />
                <modal-pop-up />

                <Head :title="title" />
                <el-header class="bg-blue-500 !h-max">
                    <Header />
                </el-header>
                <el-main class="bg-gray-100">
                    <slot />
                </el-main>
                <el-footer class="bg-blue-500">
                    <div class="flex justify-center items-center h-full text-white">
                        <p>&copy;Copyright - Akmal Riyadi</p>
                    </div>
                </el-footer>
            </el-container>
        </el-container>
    </div>
</template>
<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import { Header, Sidebar, ModalLoading, ModalPopUp } from '@/Components'
const props = defineProps({
    title: {
        type: String,
        default: ''
    }
})
</script>
  