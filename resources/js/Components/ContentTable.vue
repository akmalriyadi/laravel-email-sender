<style lang="scss" scoped>
img {
    @apply cursor-default
}
</style>
<template>
    <template v-for="head in   slice > 0 ? headers.slice(0, slice) : headers  ">
        <template v-if="head.type === 'image'">
            <el-table-column :prop="head.name" :label="head.label">
                <template #default="scope">
                    <div class="flex justify-center ">
                        <img :src="scope.row[head.name] ?? 'https://via.placeholder.com/600x600'" class="h-24" />
                    </div>
                </template>
            </el-table-column>
        </template>
        <template v-else-if="head.type === 'array'">
            <el-table-column :prop="head.name" :label="head.label">
                <template #default="scope">
                    <div v-for="item in scope.row[head.name]" class="">
                        <p class="font-bold">{{ item[head.head][head.headName] }}
                            <span class="!font-normal"> : {{ item[head.sub] }}</span>
                        </p>
                    </div>
                </template>
            </el-table-column>
        </template>
        <template v-else-if="head.type == 'price'">
            <el-table-column :sortable="head.nSort ? false : 'custom'" :prop="head.name" :label="head.label"
                :formatter="formatPrice" />
        </template>
        <template v-else-if="head.type == 'date'">
            <el-table-column :sortable="head.nSort ? false : 'custom'" :prop="head.name" :label="head.label">
                <template #default="scope">
                    <p>{{ formatToWIB(scope.row[head.name]) }}</p>
                </template>
            </el-table-column>
        </template>
        <template v-else-if="head.type == 'dateTime'">
            <el-table-column :sortable="head.nSort ? false : 'custom'" :prop="head.name" :label="head.label"
                :align="head.align ? head.align : 'left'">
                <template #default="scope">
                    <p>{{ formatWithTime(scope.row[head.name]) }}</p>
                </template>
            </el-table-column>
        </template>
        <template v-else-if="head.type == 'custom'">
            <el-table-column :sortable="head.nSort ? false : 'custom'" :width="head.width ?? ''" :prop="head.name"
                :label="head.label">
                <template #default="scope">
                    <!-- {{  }} -->
                    <div v-html="formatCustom(scope.row[head.name], head.options ?? '')" class="flex justify-center">
                    </div>
                </template>
            </el-table-column>
        </template>
        <template v-else-if="head.type == 'link'">
            <el-table-column :sortable="head.nSort ? false : 'custom'" :width="head.width ?? ''" :prop="head.name"
                :label="head.label">
                <template #default="scope">
                    <Link class="link-table" :href="getNestedPropertyValue(scope.row, head.name)"> {{
                        getNestedPropertyValue(scope.row,
                            head.text) }}</Link>
                </template>
            </el-table-column>
        </template>
        <template v-else>
            <el-table-column :sortable="head.nSort ? false : 'custom'" :prop="head.name" :label="head.label"
                :width="head.width ?? ''" :align="head.align ? head.align : 'left'">
                <template #default="scope">
                    <div v-if="head.link">
                        <Link class="link-table" :href="head.link + getNestedPropertyValue(scope.row, head.id)">
                        {{
                            getNestedPropertyValue(scope.row, head.name)
                        }}</Link>
                    </div>
                    <div v-else class="" v-html="getNestedPropertyValue(scope.row, head.name)">
                    </div>
                </template>
            </el-table-column>
        </template>
    </template>
</template>

<script setup>
import { formatToWIB, formatWithTime } from '@/lib/dateTime';
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
const props = defineProps({
    headers: {
        type: Array
    },
    slice: {
        type: Number,
        default: null
    },
    functionFormat: {
        type: Function,
        default: null
    },
})

const formatPrice = (row, column) => {
    const init = (row[column.property]).toString()
    const formattedValue = init.replace(/\B(?=(\d{3})+(?!\d))/g, ',')
    return `Rp. ${formattedValue}`
}
const formatCustom = (value, options) => {
    const val = props.functionFormat(value, options)
    return val
}
const getNestedPropertyValue = (obj, path) => {
    return path.split('.').reduce((acc, key) => acc?.[key], obj);
}
</script>