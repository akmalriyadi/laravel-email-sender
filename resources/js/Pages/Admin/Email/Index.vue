<template>
    <AppLayout title="Email Sender">
        <div class="grid grid-cols-4 gap-4">
            <Card>
                <div class="flex space-x-2 items-center">
                    <div class="flex w-16 h-16 justify-center items-center bg-[#eceaff] rounded-lg">
                        <i class="fa-solid fa-envelope text-blue-500 text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-lg">Total Email</p>
                        <p class="font-bold text-2xl">{{ data.paginate ? data.paginate.total : 0 }}</p>
                    </div>
                </div>
            </Card>
            <!-- <Card>
                <div class="flex space-x-2 items-center">
                    <div class="flex w-16 h-16 justify-center items-center bg-[#eceaff] rounded-lg">
                        <i class="fa-solid fa-paper-plane text-blue-500 text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-lg">Total Send</p>
                        <p class="font-bold text-2xl">{{ data.paginate ? data.paginate.total : 0 }}</p>
                    </div>
                </div>
            </Card> -->
        </div>
        <Button type="link" link="/admin/email-senders/create" color="primary" className="mt-4">Create</Button>
        <Card class="mt-4">
            <basic-table :headers="headers" :trashed="trashed" :data="data.data" :lg="4" :type-action="typeAction(8)"
                :total="total" :trash-function="fetchTrash" :fetch-function="fetchData" @editData="handleEdit($event)"
                @deleteData="handleDelete($event)" @forceDelete="handleForce($event)" @restore="handleRestore($event)"
                @sendEmail="handleSendEmail($event)" />
        </Card>
    </AppLayout>
</template>
<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue'
import typeAction from '@/lib/typeAction'
import { useWebStore } from '@/Stores'
import { useEmailSenderComposables, useResponseComposables } from '@/Composables'
import { Card, BasicTable, Button } from '@/Components'
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

const { data, fetchData, send, total, deleteData, fetchTrash, forceDelete, restoreData } = useEmailSenderComposables()

const { responseForce, responseDelete, responseRestore } = useResponseComposables()

const url = '/admin/email-senders/'
const trashed = ref(false)

const headers = [
    { label: 'Receiver', name: 'to' },
    { label: 'Subject', name: 'subject' },
    { label: 'Created At', name: 'created_at', type: 'date' },
    { label: 'Status', name: 'status', align: 'center' },
]

const handleEdit = (id: Number) => {
    router.get(url + 'edit/' + id)
}
const handleShow = (id: Number) => {
    router.get(url + 'show/' + id)
}
const handleSendEmail = async (id: Number) => {
    try {
        ElMessageBox.confirm('Are you sure send email. Continue?', 'Warning', {})
            .then(async () => {
                useWebStore().onLoading()
                await send(id)
                useWebStore().offLoading()
                useWebStore().onPopUp('success', 'Email has Send', 'Success')
            })
            .catch((e) => {
                useWebStore().onPopUp('danger', e, 'Error')
                useWebStore().offLoading()
            })

    } catch (e) {
        console.log(e)
        useWebStore().offLoading()
    }
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