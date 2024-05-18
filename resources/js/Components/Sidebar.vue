<style lang="scss"></style>
<template>
    <el-scrollbar wrap-class="scrollbar-wrapper">
        <div class="flex justify-center py-5 ">
            <!-- <img src="/assets/images/logo-white.png" class="w-28 filter invert" alt="" /> -->
            <p class="font-semibold">Laravel Email Sender</p>
        </div>
        <el-menu :default-active="usePage().url">
            <menu-sidebar label="Dashboard" icon="fas fa-home" link="/admin/dashboard" />
            <menu-sidebar label="Templates" icon="fa-solid fa-pen-nib" link="/admin/templates" />
            <menu-sidebar label="Email Senders" icon="fa-solid fa-envelope" link="/admin/email-senders" />
            <menu-sidebar label="Documents" icon="fa-solid fa-file" link="/admin/documents" />
            <menu-sidebar label="Setting" icon="fas fa-gear" link="/admin/setting" />
        </el-menu>
        <div class="px-5 mt-10">
            <div class="bg-blue-500 rounded-lg p-4">
                <a href="https://github.com/akmalriyadi">
                    <div class="flex space-x-2 items-center">
                        <div class="bg-white rounded-lg flex justify-center items-center w-10 h-10 flex-shrink-0">
                            <i class="bi bi-github text-blue-500 text-lg"></i>
                        </div>
                        <div class="text-white">
                            <p>Support me on <b>Github!</b></p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </el-scrollbar>
</template>
  
<script setup lang="ts">
import { MenuSidebar } from '@/Components'
import { usePage, Link } from '@inertiajs/vue3'
</script>
  