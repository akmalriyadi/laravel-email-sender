<template>
    <app-layout :title="route().params.id ? 'Edit Document' : 'Create Document'">
        <div class="flex flex-col space-y-4">
            <div class="flex flex-col space-y-2">
                <p class=" font-semibold text-2xl">{{ route().params.id ? 'Edit Document' : 'Create Document' }}</p>
                <button-back />
            </div>
            <el-form @submit.prevent :label-position="`top`" ref="formSubmit" :model="form">
                <div class="grid grid-cols-12 gap-4">
                    <div class="md:col-span-9 ">
                        <Card>
                            <Input label="Title" v-model="form.title" :error="error.title" />
                            <div>
                                <ImageUpload label="Document" v-model="form.file" :image-data="fileData"
                                    :error="error.file" />
                            </div>
                        </Card>
                    </div>
                    <div class="md:col-span-3 ">
                        <Card>
                            <Button color="primary" @click="post(formSubmit)" width="w-full">Submit</Button>
                        </Card>
                    </div>
                </div>
            </el-form>
        </div>
    </app-layout>
</template>
<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue'
import { useDocumentComposables } from '@/Composables'
import { useWebStore } from '@/Stores'
import { FormInstance } from 'element-plus'
import { router, usePage } from '@inertiajs/vue3'
import { Card, ButtonBack, Input, ImageUpload, Button } from '@/Components'
import { ref, onMounted } from 'vue'
import { route } from 'ziggy-js';
// import {route} from ''

const { postData, error, findData, data } = useDocumentComposables()

interface formInterface {
    title: string,
    file: object | string
}

const formSubmit = ref()
const fileData = ref('')
const form = ref<formInterface>({
    title: '',
    file: ''
})

const post = async (formEl: FormInstance) => {
    try {
        if (!route().params.id) {
            await postData(form.value)
            useWebStore().onPopUp('success', 'Data has Created', 'Success')
        } else {
            await postData(form.value, true, route().params.id)
            useWebStore().onPopUp('success', 'Data has Updated', 'Success')
        }
        router.get('/admin/documents')
    } catch (error) {

    }
}

const getEditedData = async () => {
    try {
        await findData(route().params.id)
        const dataEdit = data.value.data
        form.value.title = dataEdit.title
        fileData.value = dataEdit.file
    } catch (e) {

    }
}
onMounted(() => {
    if (route().params.id) {
        getEditedData()
    }
})
</script>