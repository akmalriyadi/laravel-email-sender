<template>
    <div>
        <el-select v-model="model" size="default" style="width: 70px">
            <el-option v-for="item in options" :key="item[pData]" :label="item[sData]" :value="item[pData]" />
        </el-select>
    </div>
</template>
<script setup lang="ts">
const model = defineModel()
const props = defineProps({
    options: {
        type: Array,
        default: () => []
    },
    label: {
        type: String,
        default: ''
    },
    pData: {
        type: String,
        default: 'id'
    },
    sData: {
        type: String,
        default: 'name'
    }
})
</script>