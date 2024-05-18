<template>
    <AppLayout title="Create Template">
        <div class="flex flex-col space-y-4">
            <div class="flex flex-col space-y-2">
                <p class=" font-semibold text-2xl">Create Template</p>
                <button-back />
            </div>
            <el-form @submit.prevent :label-position="`top`" ref="formSubmit" :model="form">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-9">
                        <div class="flex flex-col space-y-4">
                            <Card>
                                <Input label="Title" v-model="form.title" :error="error.title" />
                                <!-- <Input label="Body" v-model="form.body" :error="error.body" /> -->
                                <tinymce v-model="form.body" />
                            </Card>
                            <Card>
                                <p class="font-semibold text-md mb-4">Body Word</p>
                                <Button color="primary" @click="addIndex()">Add Body word</Button>
                                <div class="flex flex-col space-y-4">
                                    <div class="border rounded p-4 mt-4" v-for="(bodyWord, index) in bodyWords">
                                        <div class="flex justify-between">
                                            <p class="font-semibold mb-2">Body word {{ index + 1 }}</p>
                                            <div class="text-white bg-red-500 w-7 h-7 rounded flex justify-center items-center cursor-pointer"
                                                @click="removeIndex(bodyWord.id)">
                                                <i class="fas fa-minus"></i>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <Input label="Title" v-model="bodyWord.title" />
                                            <Input label="Value" v-model="bodyWord.val_title" />
                                        </div>
                                    </div>
                                </div>
                            </Card>
                            <Card>
                                <p class="font-semibold text-md mb-4">Document</p>
                                <Button color="primary" @click="addIndexDocument()">Add Document</Button>
                                <div class="flex flex-col space-y-4">
                                    <div class="border rounded p-4 mt-4" v-for="(document, index) in documents">
                                        <div class="flex justify-between">
                                            <p class="font-semibold mb-2">Document {{ index + 1 }}</p>
                                            <div class="text-white bg-red-500 w-7 h-7 rounded flex justify-center items-center cursor-pointer"
                                                @click="removeIndexDocument(document.id)">
                                                <i class="fas fa-minus"></i>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 gap-4">
                                            <Input select placeholder="Choose document" :options="dataDocument.data"
                                                v-model="document.document_id" sData="title" style="margin-bottom: 0px;" />
                                        </div>
                                    </div>
                                </div>
                            </Card>
                        </div>
                    </div>
                    <div class="col-span-3">
                        <Card>
                            <Button color="primary" @click="postTemplate(formSubmit)" width="w-full">Submit</Button>
                        </Card>
                    </div>
                </div>
            </el-form>
        </div>
    </AppLayout>
</template>
<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue'
import { Card, Input, ButtonBack, Button, Tinymce } from '@/Components'
import { ref, onMounted } from 'vue'
import { useTemplateComposables, useDocumentComposables } from '@/Composables'
import { router } from '@inertiajs/vue3'
import type { ComponentSize, FormInstance, FormRules } from 'element-plus'
import { route } from 'ziggy-js';
import { useWebStore } from '@/Stores'
const { postData, error, findData, data } = useTemplateComposables()
const { fetchData: fetchDataDocument, data: dataDocument } = useDocumentComposables()


interface formInterface {
    title: string,
    body: string,
    documents: documentInterface[],
    bodyWords: bodyWordInterface[]
}

interface documentInterface {
    id: number,
    document_id: string
}

interface bodyWordInterface {
    id: number
    title: string,
    val_title: string
}

const formSubmit = ref()
const id = route().params.id

const form = ref<formInterface>({
    title: '',
    body: '',
    documents: [],
    bodyWords: []
})
const bodyWords = ref<bodyWordInterface[]>([])
const documents = ref<documentInterface[]>([])

let nextIndexId = 0
let nextIndexIdDocument = 0

const addIndex = () => {
    bodyWords.value.push(
        { id: nextIndexId++, title: '', val_title: '' }
    );
}
const removeIndex = (id: number) => {
    const index = bodyWords.value.findIndex(item => item.id == id)
    if (index !== -1) {
        bodyWords.value.splice(index, 1)
    }
}
const addIndexDocument = () => {
    documents.value.push(
        { id: nextIndexIdDocument++, document_id: '' }
    );
}
const removeIndexDocument = (id: number) => {
    const index = documents.value.findIndex(item => item.id == id)
    if (index !== -1) {
        documents.value.splice(index, 1)
    }
}

const getDocument = async () => {
    try {
        await fetchDataDocument()
    } catch (e) {

    }
}

const postTemplate = async (formEl: FormInstance) => {
    try {
        form.value.documents = documents.value
        form.value.bodyWords = bodyWords.value
        if (!route().params.id) {
            await postData(form.value)
            useWebStore().onPopUp('success', 'Data has Created', 'Success')
        } else {
            await postData(form.value, true, route().params.id)
            useWebStore().onPopUp('success', 'Data has Updated', 'Success')
        }
        router.get('/admin/templates')
    } catch (e) {
        useWebStore().offLoading()
    }
}

const getEditedData = async () => {
    try {
        await findData(Number(id))
        const editData = data.value.data
        form.value.title = editData.title
        form.value.body = editData.body
        for (let i = 0; i < editData.body_words.length; i++) {
            bodyWords.value.push(
                { id: nextIndexId++, title: editData.body_words[i]['title'], val_title: editData.body_words[i]['val_title'] }
            );
        }
        for (let d = 0; d < editData.documents.length; d++) {
            documents.value.push(
                { id: nextIndexIdDocument++, document_id: editData.documents[d]['id'] }
            );
        }
        console.log(editData.documents)

    } catch (e) {

    }
}

onMounted(() => {
    getDocument()
    if (id) {
        getEditedData()
    }
})
</script>