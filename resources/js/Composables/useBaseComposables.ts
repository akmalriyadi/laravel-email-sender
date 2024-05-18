import axios from "axios"
import { router } from '@inertiajs/vue3'
import { useAuthStore, useWebStore } from "@/Stores";

export default function useBaseComposables() {
    const apiUrl = import.meta.env.VITE_API_URL;
    const baseAppUrl = import.meta.env.VITE_APP_URL;
    // console.log(apiUrl)
    let api = axios.create({
        baseURL: apiUrl,
        headers: {
            'Content-Type': 'application/json',
            // 'Access-Control-Allow-Origin': '*',
        }
    });
    const urlLogin = '/login'
    async function fetchData(endpoint: string, method: string, params: Object = {}, nonApi: boolean = false) {
        try {
            if (nonApi) {
                api = axios.create({
                    baseURL: baseAppUrl,
                    headers: {
                        'Content-Type': 'application/json',
                        // 'Access-Control-Allow-Origin': '*',
                    }
                });
            }
            const response = await api.request({
                url: endpoint,
                method: method,
                params: params,
                headers: {
                    Authorization: 'Bearer ' + useAuthStore().getToken(),
                    'Content-Type': 'application/json'
                }
            });
            if (response.data.code === 500) {
                throw (response.data.message.error_message);
            }
            return response.data;
        } catch (e: any) {
            if (e.response && e.response.status === 401) {
                console.log('ini error' + e)
                useAuthStore().setToken('')
                router.get(urlLogin)
            } else {
                ElNotification({
                    title: "Error",
                    message: "There is an error, please contact administrator",
                    type: "error",
                    duration: 5000,
                })
                console.log(e)
                throw e;
            }
        }
    }
    async function fetch(endpoint: string, method: string, params: Object = {}) {
        try {
            const response = await api.request({
                url: endpoint,
                method: method,
                params: params
            });
            return response.data;
        } catch (e: any) {
            if (e.response && e.response.status === 401) {
                useAuthStore().setToken('')
                router.get(urlLogin)
            } else {
                throw e;
            }
        }
    }
    async function postData(endpoint: string, method: string, data: Object = {}) {
        try {
            useWebStore().onLoading()
            const response = await api.request({
                url: endpoint,
                method: method,
                data: data,
                headers: {
                    Authorization: 'Bearer ' + useAuthStore().getToken(),
                    'Content-Type': 'multipart/form-data'
                }
            });
            // console.log(response)
            if (response.data.code === 500) {
                throw (response.data.message.error_message);
            }
            // useWebStore().offLoading()
            return;
        } catch (e: any) {
            if (e.response && e.response.status === 401) {
                useAuthStore().setToken('')
                router.get(urlLogin)
            }
            if (e.response && e.response.status === 400) {
                throw e.response.data.message
            } else {
                ElNotification({
                    title: "Error",
                    message: "There is an error, please contact administrator",
                    type: "error",
                    duration: 3000,
                })
            }
            console.log(e)
            useWebStore().offLoading()
            throw e;
        }
    }
    async function post(endpoint: string, method: string, data: Object = {}) {
        console.log(method)
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
    return {
        fetchData,
        fetch,
        postData,
        post
    }
}