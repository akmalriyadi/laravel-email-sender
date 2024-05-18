<style lang="scss">
.el-loading-spinner {
    circle {
        stroke: white !important;
    }
}
</style>
<template>
    <div v-loading.fullscreen.lock="isLoading" element-loading-background="#00000085" type="primary">
    </div>
</template>
  
<script lang="ts" setup>
import { ref } from 'vue'
import { ElLoading } from 'element-plus'
import { computed } from 'vue'
import { useWebStore } from '@/Stores'

const isLoading = computed(() => useWebStore().isLoading);
const fullscreenLoading = ref(false)
const openFullScreen1 = () => {
    fullscreenLoading.value = true
    setTimeout(() => {
        fullscreenLoading.value = false
    }, 2000)
}

const openFullScreen2 = () => {
    const loading = ElLoading.service({
        lock: true,
        text: 'Loading',
        background: 'rgba(0, 0, 0, 0.7)',
    })
    setTimeout(() => {
        loading.close()
    }, 2000)
}
</script>
  