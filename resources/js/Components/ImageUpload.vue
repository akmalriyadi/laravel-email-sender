<style lang="scss">
.img-upload.error {
    .el-upload-dragger {
        @apply border border-red-500 #{!important};
    }
}
</style>
<template>
    <div class="img-upload" :class="[error ? 'error' : '']">
        <div class="mb-2">
            <label for="">{{ label }}</label>
        </div>
        <el-upload class="upload-demo" drag action="#" :auto-upload="false" :show-file-list="false"
            :on-change="handleChange">
            <div v-if="imagePreview || nameDocument" class="w-full max-h-[200px] relative img-container">
                <div class="img-cover absolute w-full h-full flex items-center justify-center bg-[#00000017] ">
                    <p class="bg-slate-700 py-1 px-2 rounded text-white ">Upload File</p>
                </div>
                <!-- <el-icon><Document /></el-icon> -->
                <img v-if="type == 'image'" :src="imagePreview" class="w-full max-h-[200px] object-contain" alt="">
                <div v-else class="p-4 flex flex-col items-center">
                    <i class="fa-solid fa-file text-[5rem]"></i>
                    <p class="border w-fit px-2 mt-4 rounded">{{ nameDocument }}</p>
                </div>
            </div>
            <div v-else>
                <el-icon class="el-icon--upload"><upload-filled /></el-icon>
                <div class="el-upload__text">
                    Drop file here or <em>click to upload</em>
                </div>
            </div>

        </el-upload>
        <div v-if="error" class="text-error">{{ error[0] }}</div>
    </div>
</template>
  
<script setup lang="ts">
import { UploadFilled } from '@element-plus/icons-vue'
import { ref, watch } from 'vue'
const model = defineModel()
const props = defineProps({
    label: {
        type: String,
        default: ''
    },
    imageData: {
        type: String,
        default: ''
    },
    error: {
        type: [Array, String],
        default: ''
    },
    type: {
        type: String,
        default: ''
    }
})
const imagePreview = ref('')
const nameDocument = ref('')
const handleChange = (value) => {
    console.log(value)
    model.value = value.raw
    nameDocument.value = value.name
    imagePreview.value = URL.createObjectURL(value.raw)
}
watch(() => props.imageData,
    (newImage) => {
        if (newImage && props.type == 'image') {
            imagePreview.value = newImage;
        }
        if (newImage && props.type !== 'image') {
            console.log('test')
            nameDocument.value = newImage;
        }
    }
);

</script>

<style lang="scss">
.el-upload-dragger {
    @apply p-4;
}

.img-container {
    .img-cover {
        @apply opacity-0 transition-all;
    }

    &:hover .img-cover {
        @apply opacity-100 transition-all #{!important};
    }
}

// .el-upload
</style>
  