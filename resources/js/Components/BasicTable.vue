<style lang="scss">
.el-table__header {}

.table-element {
    th {
        @apply text-center bg-slate-50 #{!important};
    }

    &.slice-on {
        colgroup {
            col:first-child {
                @apply hidden;
            }
        }

        td:hover {
            @apply cursor-pointer
        }
    }
}


.link-table {
    &:hover {
        @apply text-blue-500
    }
}



.el-table__expand-column {
    @apply hidden
}
</style>
<template>
    <div class="mb-4">
        <div class="inline-block md:flex w-full justify-between">
            <div class="mb-4" v-if="!initPageSize">
                <Select :options="sizeData" v-model="pageSize" />
            </div>
            <div>
                <Input v-model="searchQuery.name" placeholder="Search data ... " />
            </div>
        </div>
        <div class="flex space-x-2 mb-4" v-if="!noTrash">
            <Button @click="trashHandler(false)" :disabled="!trashed">View</Button>
            <Button @click="trashHandler(true)" :disabled="trashed" backgroundColor="bg-red-500">Trash</Button>
        </div>
        <div class="table-element" :class="[slicing > 0 ? 'slice-on' : '']">
            <el-table @sort-change="sortChange" :data="filteredOptions" stripe border style="width: 100%"
                table-layout="auto" :row-key="row => row.id" :expand-row-keys="expandRowKeys"
                @expand-change="handleExpandChange" @cell-click="celle">
                <!-- <el-table-column>
                <template #default="props">
                    <div>
                        halo
                    </div>
                </template>
            </el-table-column> -->
                <template v-if="slicing > 0">
                    <el-table-column type="expand">
                        <template #default="props" class="hidden">
                            <div v-for="header in headers.slice(slicing)">
                                <show-data :label="header.label">
                                    <div v-if="header.type == 'array'">
                                        <div v-for="item in props.row[header.name]">
                                            <p class="font-bold">{{ item[header.head][header.headName] }}
                                                <span class="!font-normal"> : {{ item[header.sub] }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div v-else-if="header.type == 'image'">
                                        <img :src="props.row[header.name] ?? 'https://via.placeholder.com/600x600'"
                                            class="h-24" />
                                    </div>
                                    <div v-else>
                                        <p>{{ getNestedPropertyValue(props.row, header.name) }}</p>
                                    </div>
                                </show-data>
                            </div>
                        </template>
                    </el-table-column>
                    <el-table-column width="50" label="#" align="center">
                        <template #default="scope">
                            <div>
                                {{ scope.row['rowIndex'] }}
                            </div>
                        </template>
                    </el-table-column>
                </template>

                <!-- <content-table :headers="headers" /> -->
                <template v-if="slicing > 0">
                    <content-table :headers="headers" :function-format="functionFormat" :slice="slicing" />
                </template>
                <template v-else>
                    <el-table-column width="50" label="#" align="center">
                        <template #default="scope">
                            <div>
                                {{ scope.row['rowIndex'] }}
                            </div>
                        </template>
                    </el-table-column>
                    <content-table :headers="headers" :function-format="functionFormat" />
                </template>
                <el-table-column v-if="typeAction.length > 0" label="action" width="100">
                    <template #default="scope">
                        <div class="flex justify-center space-x-2">
                            <el-dropdown>
                                <i class="fas fa-dot-circle"></i>
                                <template #dropdown>
                                    <el-dropdown-menu style="width:max-content">
                                        <template v-for="( action, index ) in typeAction">
                                            <el-dropdown-item v-if="action.trash !== true && !trashed"
                                                @click="$emit(action.eventName, scope.row.id)">
                                                <div class="flex items-center space-x-1">
                                                    <i class="text-[12px]" v-if="action.type == 'icon'"
                                                        :class="action.label"></i>
                                                    <p>
                                                        {{ action.tool }}
                                                    </p>
                                                </div>
                                            </el-dropdown-item>
                                            <el-dropdown-item v-if="action.trash == true && trashed"
                                                @click="$emit(action.eventName, scope.row.id)">
                                                <div class="flex items-center space-x-4">
                                                    <i class="text-[12px]" v-if="action.type == 'icon'"
                                                        :class="action.label"></i>
                                                    <p>
                                                        {{ action.tool }}
                                                    </p>
                                                </div>
                                            </el-dropdown-item>
                                        </template>

                                    </el-dropdown-menu>
                                </template>
                            </el-dropdown>
                        </div>
                    </template>
                </el-table-column>
            </el-table>
        </div>
    </div>
    <div class="flex justify-between">
        <!-- {{ total }} -->
        <i class=" text-[12px]">Show {{ data.length }} from {{ total ?? 0 }} data</i>
        <el-pagination background layout="prev, pager, next" v-model:current-page="currentPage" :page-size="pageSize"
            :total="total" v-if="!initPageSize" />
    </div>
</template>
  
<script  setup lang="ts">
import debounce from 'lodash.debounce'
import { formatToWIB, formatWithTime } from '@/lib/dateTime';
import { ContentTable, Button, Select, Input, ShowData } from '@/Components'
import { ref, watch, onMounted, computed } from 'vue'
import { useFilterStore, useWebStore } from '@/Stores'

const emits = defineEmits(['editData', 'deleteData', 'forceDelete', 'restore', 'showData', 'returnFormat', 'sendEmail'])
const props = defineProps({
    noTrash: {
        type: Boolean,
        default: false
    },
    data: {
        type: Array,
        default: () => []
    },
    fetchFunction: {
        type: Function,
        default: null
    },
    trashFunction: {
        type: Function,
        default: null
    },
    headers: {
        type: Array,
        default: () => []
    },
    typeAction: {
        type: Array,
        default: () => []
    },
    total: {
        type: Number,
        default: 0
    },
    trashed: {
        type: Boolean,
        deafult: false
    },
    loadFilter: {
        type: Boolean,
        default: false
    },
    findId: {
        type: [String, Number],
        default: ''
    },
    functionFormat: {
        type: Function,
        default: null
    },
    initPageSize: {
        type: [String, Number],
        default: null
    },
    lg: {
        type: Number,
        default: null
    },
    md: {
        type: Number,
        default: null
    },
    sm: {
        type: Number,
        default: null
    },
})
const sortFilter = ref({
    sort: {
        dir: 'desc',
        columns: 'id'
    }
})

const slicing = ref(0)
const expandRowKeys: Ref<any> = ref([])
const handleExpandChange = (row, expandedRows) => {
    const id = row.id;
    console.log(expandedRows)
    console.log(row)
    const lastId = expandRowKeys.value[0];
    // disable mutiple row expanded 
    expandRowKeys.value = id === lastId ? [] : [id];
}

const getNestedPropertyValue = (obj, path) => {
    return path.split('.').reduce((acc, key) => acc?.[key], obj);
}

const celle = (row: any, column: any, cell: HTMLTableCellElement, event: Event) => {
    const parentElement = cell.parentNode;
    const targetElement = parentElement.querySelector('.el-table__expand-icon');
    const check = ['el-table__cell', 'cell'].some(className => event.target.parentNode.classList.contains(className));

    if (targetElement && check) {
        targetElement.click()
    } else {
    }
}

const isLarge = ref(false)
const isMedium = ref(false)
const isSmall = ref(false)
const expand = ref(false)

const checkScreenSize = () => {
    const screenWidth = window.innerWidth;
    isLarge.value = screenWidth >= 1024;
    isMedium.value = screenWidth <= 1024 && screenWidth > 768;
    isSmall.value = screenWidth <= 768;
    if (isLarge.value) {
        console.log('check1')
        if (props.lg < props.headers.length) {
            expand.value = true
            slicing.value = props.lg
        }
    } else if (isMedium.value) {
        console.log('check2')
        if (props.md < props.headers.length) {
            expand.value = true
            slicing.value = props.md
        }
    } else if (isSmall.value) {
        console.log('check')
        if (props.sm < props.headers.length) {
            expand.value = true
            slicing.value = props.sm
        }
    } else {
        slicing.value = 0
    }
};

const sortChange = (value) => {
    let order = 'asc'
    if (value.order == null) {
        sortFilter.value.sort = {
            dir: 'desc',
            columns: 'id',
        }
    } else {
        if (value.order == 'ascending') {
            order = 'asc'
        }
        if (value.order == 'descending') {
            order = 'desc'
        }
        sortFilter.value.sort = {
            dir: order,
            columns: value.prop,
        }
    }
    useFilterStore().handleFilter(sortFilter.value)
}

const pageSize = ref(5)
const queryParams = computed(() => useFilterStore().queryParams)
const sortParams = computed(() => useFilterStore().sortParams)
const currentPage = ref(1)
const checkLoading = ref(true)

const filteredOptions = computed(() => {
    return props.data.map((row, index) => {
        return {
            ...row,
            rowIndex: getRowIndex(index)
        }
    })
})
const trashed = ref(false)
const getRowIndex = (index) => {
    const startIndex = (currentPage.value - 1) * pageSize.value
    return startIndex + index + 1
}
const changePage = ref(false)
const sizeData = [
    { id: 5, name: 5 },
    { id: 10, name: 10 },
    { id: 50, name: 50 }
]
const searchQuery = ref({
    name: "",
});
const getData = async () => {
    try {
        useWebStore().onLoading()
        console.log(props.initPageSize)
        if (props.findId) {
            if (!trashed.value) {
                if (props.initPageSize) {
                    await props.fetchFunction(props.findId, currentPage.value, props.initPageSize, queryParams.value + sortParams.value)
                } else {
                    await props.fetchFunction(props.findId, currentPage.value, pageSize.value, queryParams.value + sortParams.value)
                    console.log(props.data)
                }
            } else {
                await props.trashFunction(props.findId, currentPage.value, pageSize.value, queryParams.value + sortParams.value)
            }
        } else {
            if (props.initPageSize) {
                await props.fetchFunction(currentPage.value, props.initPageSize, queryParams.value + sortParams.value)
            } else {
                if (!trashed.value) {
                    await props.fetchFunction(currentPage.value, pageSize.value, queryParams.value + sortParams.value)
                } else {
                    await props.trashFunction(currentPage.value, pageSize.value, queryParams.value + sortParams.value)
                }
            }

        }
        useWebStore().offLoading()
    } catch (e) {
        console.log(e)
        useWebStore().offLoading()
    }
}
const b = 'c'
defineExpose({
    getData,
});
watch(() => props.trashed, (newTrashed) => {
    if (trashed.value) {
        trashed.value = false
    }
})
const trashHandler = (action) => {
    if (action) {
        trashed.value = true
        currentPage.value = 1
        useFilterStore().resetFilter()
    } else {
        trashed.value = false
        currentPage.value = 1
        useFilterStore().resetFilter()
    }

    if (searchQuery.value.name == '') {
        getData()
    } else {
        searchQuery.value.name = ''
    }
}
const handleFilter = (goFilter, wl = null) => {
    if (wl) {
        checkLoading.value = false
    } else {
        checkLoading.value = true
    }
    useFilterStore().handleFilter(goFilter)
}
const debouceFilter = debounce((newQuery) => {
    handleFilter(newQuery, props.loadFilter)
}, 300)

const delayedFetchData = debounce(() => {
    getData()
}, 300);

watch(searchQuery.value, (newQuery) => {
    debouceFilter(newQuery)
})

watch([queryParams, sortParams], () => {
    delayedFetchData()
})
watch([pageSize], ([newSize], [oldSize]) => {
    console.log('test')
    if (oldSize !== newSize) {
        currentPage.value = 1
        changePage.value = true
        getData()
    }
})
watch([currentPage], ([newCurrent], [oldCurrent]) => {
    console.log('test2')
    if (!changePage.value) {
        getData()
    }
    changePage.value = false
})
onMounted(() => {
    checkScreenSize();
    window.addEventListener('resize', checkScreenSize);
    getData()
})
// onBeforeRouteLeave(() => {
//     useFilterStore().resetFilter();
// })


</script>
  