<template>
    <el-dialog v-if="isOpen && !useWebStore().isLoading" v-model="centerDialogVisible" :show-close="false" width="500"
        align-center>
        <div class="flex flex-col items-center ">
            <div class="flex justify-center">
                <div
                    class="w-16 h-16 rounded-full border-2 border-green-500 text-green-500 flex justify-center items-center">
                    <i :class="iconClasses" class="text-2xl"></i>
                </div>
            </div>
            <h1 class="text-2xl text-center text-black font-bold mt-4">{{ titlePopUp }}</h1>
            <!-- <slot></slot> -->
            <p v-html="textPopUp" class="flex justify-center mt-2 text-center"></p>
        </div>
        <div class="flex justify-center mt-4">
            <Button width="inline-block" @click="toggleModal()">Oke</Button>
        </div>
    </el-dialog>
</template>
<script setup>
import { ref, computed } from 'vue'
import { useWebStore } from '@/Stores'
import { Button } from '@/Components'
const centerDialogVisible = ref(true)
const icon = computed(() => useWebStore().iconPopUp)
const isOpen = computed(() => useWebStore().popUpOpen);
const textPopUp = computed(() => useWebStore().textPopUp);
const titlePopUp = computed(() => useWebStore().titlePopUp);
const iconClasses = computed(() => {
    const iconMappings = {
        info: "fa-solid fa-exclamation",
        success: "fa-solid fa-check",
        delete: "fa-solid fa-xmark",
    };
    return iconMappings[icon.value] ?? iconMappings["success"];
});
const toggleModal = () => {
    useWebStore().togglePopUp()
};
</script>
  