import useBaseComposables from "./useBaseComposables";
import { ref, Ref, reactive } from "vue";

export default function useCoreComposables(url: string) {
    const data = ref<any>([])
    const cData = reactive<any>([])
    const total = ref(0)
    const error: Ref<any | null> = ref([]);
    const initError: Ref<any | null> = ref(null);
    const useBase = useBaseComposables()
    const isLoadingData = ref(true)
    const isLoadingPost = ref(false)

    async function fetchTrash(page: Number = 1, size: Number = 5, params: Object = {}) {
        try {
            const response = await useBase.fetchData(`${url}/trashed?page=${page}&limit=${size}&${params}`, 'get', '')
            data.value = response
            // console.log(response)
            total.value = response.paginate.total
        } catch (e: any) {
            throw e
        }
    }

    async function fetchData(page: Number = 1, size: Number = 5, params: Object = {}) {
        try {
            const response = await useBase.fetchData(`${url}?page=${page}&limit=${size}&${params}`, 'get', '')
            data.value = response
            // console.log(response)
            total.value = response.paginate.total
        } catch (e: any) {
            throw e
        }
    }
    async function findData(id: Number) {
        try {
            isLoadingData.value = true
            const response = await useBase.fetchData(`${url}/show/${id}`, 'get', '')
            data.value = response
            isLoadingData.value = false
        } catch (e: any) {
            throw e
        }
    }

    async function postData(form: Record<string, any>, edit: Boolean = false, id: Number | null = null) {
        try {
            error.value = []
            const formData = new FormData();
            for (const key in form) {
                if (form[key] !== null && form[key] !== undefined && form[key] !== "" && key !== 'created_at' && key !== 'updated_at') {
                    if (!Array.isArray(form[key])) {
                        formData.append(key, form[key]);
                    } else {
                        if (typeof form[key][0] === 'object' && form[key][0] !== null) {
                            form[key].forEach((variantObject: any, index: number) => {
                                // Append each property of the variant object separately
                                for (const variantKey in variantObject) {
                                    if (variantObject[variantKey] !== null && variantObject[variantKey] !== '') {
                                        formData.append(`${key}[${index}][${variantKey}]`, variantObject[variantKey]);
                                    }
                                }
                            });
                        }
                        // Jika nilai bukan objek, gunakan metode kedua
                        else {
                            console.log('halo3')
                            let i = 0;
                            form[key].forEach((value: any, index: number) => {
                                if (value !== null && value !== undefined && value !== '') {
                                    formData.append(`${key}[${i++}]`, value);
                                }
                            });
                        }
                    }
                }
            }
            let postUrl = url;
            if (edit == true) {
                postUrl = url + `/update/${id}`;
            }
            await useBase.postData(`${postUrl}`, 'post', formData);
            return;
        } catch (e: any) {
            if (e.response && e.response.status === 422) {
                const errors = e.response.data.errors;
                error.value = errors;
            } else {
                initError.value = "please contact administrator";
            }
            throw e;
        }
    }



    async function deleteData(id: Number) {
        try {
            await useBase.postData(`${url}/delete/${id}`, 'post')
        } catch (e: any) {
            if (e.response && e.response.status === 422) {

                const errors = e.response.data.errors;
                error.value = errors;
            } else {
                initError.value = "please contact administrator";
            }
            throw e
        }
    }
    async function forceDelete(id: Number) {
        try {
            console.log('test')
            await useBase.postData(`${url}/force-delete/${id}`, 'post')
        } catch (e: any) {
            if (e.response && e.response.status === 422) {

                const errors = e.response.data.errors;
                error.value = errors;
            } else {
                initError.value = "please contact administrator";
            }
            console.log(e)
            throw e
        }
    }
    async function restoreData(id: Number) {
        try {
            await useBase.postData(`${url}/restore/${id}`, 'post')
        } catch (e: any) {
            if (e.response && e.response.status === 422) {

                const errors = e.response.data.errors;
                error.value = errors;
            } else {
                initError.value = "please contact administrator";
            }
            throw e
        }
    }

    return {
        data,
        cData,
        total,
        error,
        initError,
        isLoadingData,
        isLoadingPost,
        restoreData,
        forceDelete,
        findData,
        deleteData,
        fetchData,
        fetchTrash,
        postData
    }
}