<template>
    <div class="flex justify-center items-center min-h-screen p-5 bg-blue-500">
        <div class="grid grid-cols-12 bg-white rounded-2xl overflow-hidden shadow-md">
            <div class="md:col-span-7 md:block hidden">
                <div class="bg-auth relative">
                    <div class="flex justify-end">
                        <img src="/assets/images/logo-white.png" alt="">
                    </div>
                    <div class="flex flex-col justify-center items-center h-full mt-[-2rem] text-white">
                        <p class="font-bold text-4xl ">Laravel Email Sender</p>
                        <p class="text-lg mt-2">Simple way to manage your email</p>
                    </div>
                </div>
            </div>
            <div class="md:col-span-5 col-span-12 ">
                <div class="flex justify-center items-center h-full md:px-16">
                    <el-form @submit.prevent :label-position="`top`" ref="formLogin" :model="form">
                        <div class="flex flex-col space-y-4">
                            <div class="space-y-2 mb-4">
                                <h3 class="font-bold text-3xl">Welcome <span class="text-blue-500">Back!</span></h3>
                                <p>Please login first for use this application.</p>
                            </div>
                            <Input label="Username" v-model="form.username" :error="error.username" />
                            <Input label="Password" type="password" v-model="form.password" :error="error.password" />
                            <div>
                                <Button width="w-full" @click="handleSubmit(formLogin)"
                                    className="primary mt-4">Submit</Button>
                            </div>
                        </div>
                    </el-form>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup lang="ts">
import { Input, Button } from '@/Components/'
import { useAuthComposables } from '@/Composables'
import { ref, watch, computed } from 'vue'
import type { ComponentSize, FormInstance, FormRules } from 'element-plus'
import { useWebStore } from '@/Stores';


const { handleLogin, error } = useAuthComposables()
const notificationOpen = computed(() => useWebStore().notificationOpen)

interface FormLogin {
    username: string,
    password: string
}

const formLogin = ref()
const form = ref<FormLogin>({
    username: '',
    password: ''
})

watch(() => notificationOpen.value, () => {
    if (notificationOpen.value) {
        // ElNotification({
        //     title: "Error",
        //     message: "There is an error, please contact administrator"
        // })
    }
})

const handleSubmit = async (formEl: FormInstance) => {
    try {
        await handleLogin(form.value)
    } catch (e) {
        // ElNotification({
        //     title: "Error",
        //     message: "There is an error, please contact administrator"
        // })
    }
}

</script>