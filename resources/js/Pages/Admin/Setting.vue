<template>
    <AppLayout title="Setting">
        <el-form @submit.prevent="handleSubmit" :label-position="`top`" ref="formSubmit" :model="form">
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-4">
                    <p class="font-semibold text-lg">Email Information</p>
                    <p class="text-sm">Update your email SMTP information for send email</p>
                </div>
                <div class="col-span-8">
                    <Card>
                        <Input label="Mailer" v-model="form.mailer" :error="error.mailer" />
                        <Input label="Host" v-model="form.host" :error="error.host" />
                        <Input label="Port" v-model="form.port" :error="error.port" />
                        <Input label="Email" v-model="form.username" :error="error.username" />
                        <Input label="Password" v-model="form.password" :error="error.password" />
                        <Input label="Encryption" select :options="encryptionData" placeholder="Choose Encryption"
                            v-model="form.encryption" :error="error.encryption" />
                        <div class="w-full flex justify-end">
                            <Button @click="handleSubmit(formSubmit)">Submit</Button>
                        </div>
                    </Card>
                </div>
            </div>
        </el-form>
    </AppLayout>
</template>
<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue'
import { useSettingComposables } from '@/Composables';
import { Card, Input, Button } from '@/Components'
import { ref, onMounted } from 'vue'
import { FormInstance } from 'element-plus'
import { useWebStore } from '@/Stores';
import { router } from '@inertiajs/vue3'

const { postData, error, findData, data, deleteData } = useSettingComposables()

interface formSubmitInterface {
    mailer: string,
    host: string,
    port: string,
    username: string,
    password: string,
    encryption: string
}

const encryptionData = [
    { id: 'tls', name: 'tls' },
    { id: 'ssl', name: 'ssl' }
]

const formSubmit = ref()

const form = ref<formSubmitInterface>({
    mailer: '',
    host: '',
    port: '',
    username: '',
    password: '',
    encryption: ''
})

const getDataEmail = async () => {
    try {
        await findData(1)
        const dataEmail = data.value.data
        form.value = {
            mailer: dataEmail.mailer,
            host: dataEmail.host,
            port: dataEmail.port,
            username: dataEmail.username,
            password: dataEmail.password,
            encryption: dataEmail.encryption
        }
    } catch (e) {

    }
}

const handleSubmit = async (formEl: FormInstance) => {
    try {
        await postData(form.value, true, 1)
        useWebStore().onPopUp('success', 'Your data has been Updated', 'Success')
        useWebStore().offLoading()
    } catch (e) {
        useWebStore().offLoading()
    }
}


onMounted(() => {
    getDataEmail()


})
</script>