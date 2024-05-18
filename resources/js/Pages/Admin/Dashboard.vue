<template>
    <AppLayout title="Dashboard">
        <div class="grid grid-cols-4 gap-4">
            <Card>
                <div class="flex space-x-2 items-center">
                    <div class="flex w-16 h-16 justify-center items-center bg-[#eceaff] rounded-lg">
                        <i class="fa-solid fa-pen-nib text-blue-500 text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-lg">Total Template</p>
                        <p class="font-bold text-2xl">10</p>
                    </div>
                </div>
            </Card>
            <Card>
                <div class="flex space-x-2 items-center">
                    <div class="flex w-16 h-16 justify-center items-center bg-[#eceaff] rounded-lg">
                        <i class="fa-solid fa-envelope text-blue-500 text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-lg">Total Email</p>
                        <p class="font-bold text-2xl">10</p>
                    </div>
                </div>
            </Card>
            <Card>
                <div class="flex space-x-2 items-center">
                    <div class="flex w-16 h-16 justify-center items-center bg-[#eceaff] rounded-lg">
                        <i class="fa-solid fa-paper-plane text-blue-500 text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-lg">Total Send</p>
                        <p class="font-bold text-2xl">10</p>
                    </div>
                </div>
            </Card>
        </div>
    </AppLayout>
</template>
<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue'
import { Card } from '@/Components'
</script>