<style lang="scss" scope>
.my-label {
    @apply lg:w-56 w-24 align-baseline
}
</style>
<template>
    <div>
        <el-descriptions border :column="1">
            <el-descriptions-item :label="label" label-align="left" align="left" label-class-name="my-label"
                class-name="my-content">
                <slot />
            </el-descriptions-item>
        </el-descriptions>
    </div>
</template>
<script setup>
const props = defineProps({
    label: {
        type: String,
        default: ''
    }
})
</script>