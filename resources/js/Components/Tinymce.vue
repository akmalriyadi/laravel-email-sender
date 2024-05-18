<style lang="scss">
.tox-tinymce {
    border: 1px solid #dcdfe6 !important;
    border-radius: 4px !important;
}
</style>
<template>
    <div class="flex flex-col space-y-2">
        <label for="" class="">{{ label }}</label>
        <editor v-model="model" api-key="zsuulaj3j338t2e9ak7npeudihzopp017hz7iyq5w7srwsp3" />
    </div>
</template>
<script setup lang="ts">
import Editor from '@tinymce/tinymce-vue'
const model = defineModel()
const props = defineProps({
    label: {
        type: String,
        default: 'Body'
    }
})
</script>