import axios from "axios"
import { ElNotification } from "element-plus"
import useBaseComposables from "./useBaseComposables"
import useCoreComposables from "./useCoreComposables"
import { useAuthStore, useWebStore } from "@/Stores"
import { router } from '@inertiajs/vue3'

export default function useAuthComposables() {
    const url = '/auth'
    const urlLogin = '/login'
    const core = useCoreComposables(url)
    const useBase = useBaseComposables()

    async function me() {
        try {
            const response = await useBase.fetchData('/auth/me', 'post', '')
            console.log(response)
            useAuthStore().setAuth(response)
        } catch (error) {
            console.log(error)
        }
    }

    async function handleLogin(form: Record<string, any>) {
        try {
            // console.log('check');
            const response = await post('/auth/login', 'post', form)
            if (response.data.status == false) {
                core.error.value = [];
                core.error.value.init = response.data.message
                throw response.data.message
            } else {
                await useAuthStore().setToken(response.data.access_token)
                core.error.value = [];
                router.get('/admin/dashboard')
            }
        } catch (e: any) {
            if (e.response && e.response.status === 422) {
                const errors = e.response.data.errors;
                core.error.value = errors;
            } else if (e.response && e.response.status === 400) {
                console.log(e)
                ElNotification({
                    title: "Error",
                    message: e.response.data.message,
                    type: "error"
                })
            } else {
                core.error.value = [];
            }
            throw e
        }
    }

    async function post(endpoint: string, method: string, data: Object = {}) {
        const apiUrl = import.meta.env.VITE_APP_URL;
        const api = axios.create({
            baseURL: apiUrl,
            headers: {
                'Content-Type': 'application/json',
                // 'Access-Control-Allow-Origin': '*',
            }
        });
        try {
            const response = await api.request({
                url: endpoint,
                method: method,
                data: data,
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });
            return response;
        } catch (e: any) {
            if (e.response.status === 401) {
                useAuthStore().setToken('')
                router.get(urlLogin)
            }
            if (e.response.status === 422 || e.response.status === 400) {
                console.log(e)
                throw e;
            } else {
                ElNotification({
                    title: "Error",
                    message: "There is an error, please contact administrator",
                    type: "error",
                    duration: 3000,
                })
            }

        }
    }

    async function handleLogout() {
        try {
            useWebStore().onLoading()
            await useBase.fetchData('/auth/logout', 'post', '', true)
            useAuthStore().setToken('')
            useAuthStore().setAuth('')
            useWebStore().offLoading()
            router.get('/login')
        } catch (e: any) {
            throw e
        }
    }


    return {
        ...core,
        handleLogin,
        handleLogout,
    }
}