<template>
    <AppLayout title="Create Template">
        <div class="flex flex-col space-y-4">
            <div class="flex flex-col space-y-2">
                <p class=" font-semibold text-2xl">Create Email Sender</p>
                <button-back />
            </div>
            <el-form @submit.prevent :label-position="`top`" ref="formSubmit" :model="form">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-9">
                        <Card>
                            <Input label="To" v-model="form.to" placeholder="Example: Zainnoeryadie@gmail.com" />
                            <Input label="Subject" v-model="form.subject" placeholder="Example: Laravel Developer" />
                            <Input select label="Template" :options="dataTemplate.data" placeholder="Choose template"
                                sData="title" v-model="form.template_id" @change="(value) => handleTemplate(value)" />
                            <div>
                                <Input :label="bodyWord.title" v-model="bodyWord.val"
                                    v-for="(bodyWord, index) in bodyWords" />
                            </div>
                        </Card>
                    </div>
                    <div class="col-span-3">
                        <div class="flex flex-col space-y-4">
                            <Card>
                                <Button color="primary" @click="postEmail(formSubmit)" width="w-full">Submit</Button>
                            </Card>
                            <Card>
                                <Input label="Status" v-model="form.status" select :options="statusForm"
                                    placeholder="Choose status" />
                            </Card>
                        </div>
                    </div>
                </div>
            </el-form>
        </div>
    </AppLayout>
</template>
<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue'
import { useEmailSenderComposables, useTemplateComposables } from '@/Composables'
import { useWebStore } from '@/Stores'
import { FormInstance } from 'element-plus'
import { router, usePage } from '@inertiajs/vue3'
import { Card, ButtonBack, Input, ImageUpload, Button } from '@/Components'
import { ref, onMounted } from 'vue'
import { route } from 'ziggy-js';

const { data: dataTemplate, fetchData: fetchTemplate } = useTemplateComposables()
const { data: dataEmail, postData, error, findData } = useEmailSenderComposables()

interface bodyWordsInterface {
    template_id: number
    template_word_id: number,
    title: string,
    val_title: string,
    val: string

}

interface formSubmitInterface {
    to: string,
    subject: string,
    status: string | null,
    template_id: number | null,
    bodyWords: bodyWordsInterface[]
}

const statusForm = [
    { id: 'DRAFT', name: 'DRAFT' },
    { id: 'SEND', name: 'SEND' },
]

const form = ref<formSubmitInterface>({
    to: '',
    subject: '',
    template_id: null,
    status: 'SEND',
    bodyWords: [],
})

const selectedTemplate = ref()
const formSubmit = ref()

const bodyWords = ref<bodyWordsInterface[]>([])

const handleTemplate = async (id) => {
    form.value.template_id = id
    const template = dataTemplate.value.data.find((item) => item.id == id)
    if (template) {
        bodyWords.value = []
        template.body_words.forEach((item: any) => {
            bodyWords.value.push({
                template_id: item.template_id,
                template_word_id: item.id,
                title: item.title,
                val_title: item.val_title,
                val: ''
            })
        })
    }
}

const postEmail = async (formEl: FormInstance) => {
    try {
        form.value.bodyWords = bodyWords.value
        await postData(form.value)
        router.get('/admin/email-senders')
    } catch (e) {

    }
}

const getTemplate = async () => {
    try {
        await fetchTemplate(1, 0)
    } catch (e) {

    }
}

onMounted(() => {
    getTemplate()
})
</script>