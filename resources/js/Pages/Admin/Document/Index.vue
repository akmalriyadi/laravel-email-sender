<template>
    <AppLayout title="Tempalte">
        <div class="grid grid-cols-4">
            <Card>
                <div class="flex space-x-2 items-center">
                    <div class="flex w-16 h-16 justify-center items-center bg-[#eceaff] rounded-lg">
                        <i class="fa-solid fa-file text-blue-500 text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-lg">Total Document</p>
                        <p class="font-bold text-2xl">{{ data.paginate ? data.paginate.total : 0 }}</p>
                    </div>
                </div>
            </Card>
        </div>
        <Button type="link" link="/admin/documents/create" color="primary" className="mt-4">Create</Button>
        <Card class="mt-4">
            <basic-table :headers="headers" :trashed="trashed" :data="data.data" :lg="3" :type-action="typeAction(2)"
                :total="total" :trash-function="fetchTrash" :fetch-function="fetchData" @editData="handleEdit($event)"
                @deleteData="handleDelete($event)" @forceDelete="handleForce($event)" @restore="handleRestore($event)" />
        </Card>
    </AppLayout>
</template>
<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue'
import typeAction from '@/lib/typeAction'
import { useDocumentComposables, useResponseComposables } from '@/Composables'
import { Card, BasicTable, Button } from '@/Components'
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

const { data, fetchData, total, deleteData, fetchTrash, forceDelete, restoreData } = useDocumentComposables()

const { responseForce, responseDelete, responseRestore } = useResponseComposables()

const url = '/admin/documents/'
const trashed = ref(false)

const headers = [
    { label: 'Title', name: 'title', width: '200' },
    { label: 'File', name: 'file_link', type: 'link', text: 'file' },
    { label: 'Real Name', name: 'real_name' },
]

const handleEdit = (id: Number) => {
    router.get(url + 'edit/' + id)
}
const handleShow = (id: Number) => {
    router.get(url + 'show/' + id)
}

const handleForce = async (id: Number) => {
    await responseForce(id, forceDelete, fetchTrash)
}
const handleRestore = async (id: Number) => {
    await responseRestore(id, restoreData, fetchTrash)
}
const handleDelete = async (id: Number) => {
    await responseDelete(id, deleteData, fetchData)
}
</script>