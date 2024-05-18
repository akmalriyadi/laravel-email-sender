<style lang="scss">
label {
    @apply text-[16px] #{!important};
}

.el-input__wrapper,
.el-select__wrapper {
    @apply py-1 #{!important};
}

.el-input__inner,
.el-select__wrapper {
    @apply text-[16px] #{!important};
}

.el-input__inner,
.el-select__selection {
    @apply h-[30px] #{!important};
}

.el-input__wrapper:has(input[readonly]) {
    @apply bg-slate-100;
}

textarea {
    height: 200px;
}
</style>
<template>
    <el-form-item default="0" :label="label" :error="error[0]" :style="style" :prop="prop">
        <el-row class="w-full">
            <el-col :span="slots ? slotGrid : 24">
                <el-select v-if="select" filterable v-model="model" :placeholder="placeholder" :disabled="readonly"
                    @change="handleChange">
                    <el-option :key="''" :label="placeholder" :value="''" class="!text-gray-300"></el-option>
                    <el-option v-if="defaultVal && (options.length < 1)" :key="defaultVal.id" :label="defaultVal.name"
                        :value="defaultVal.id"></el-option>
                    <el-option v-for="item in options" :key="item[pData]" :label="getNestedPropertyValue(item, sData)"
                        :value="item[pData]" />
                </el-select>
                <div v-else>
                    <el-input v-model="model" :readonly="readonly" :placeholder="placeholder"
                        :formatter="formatter ? formatterFunction : null"
                        :parser="formatter ? (value) => value.replace(/\Rp\s?|(,*)/g, '') : null" :type="type"
                        @input="handleInput" @blur="handleBlur" :show-password="showPassword" />
                </div>
            </el-col>
            <el-col :span="24 - slotGrid" v-if="slots" style="text-align: -webkit-right;">
                <slot />
            </el-col>
        </el-row>
    </el-form-item>
</template>
<script setup lang="ts">
import { computed } from 'vue';
const emits = defineEmits(['change', 'update'])
const model = defineModel()
const handleBlur = (value: string) => {
    if (props.format == 'number') {
        if (model.value == '') {
            model.value = props.value
        }
    }
}

// let initError = computed(() => props.error)

const getNestedPropertyValue = (obj, path) => {
    return path.split('.').reduce((acc, key) => acc?.[key], obj);
}

const handleInput = (value: string) => {
    emits('update', value)
}

const handleChange = (value: string) => {
    emits('change', value)
}
const formatterFunction = (value: string) => {
    if (value) {
        const numericValue = value.replace(/\D/g, '')
        const cleanedValue = numericValue.replace(/^0(?=\d)/, '')
        const formattedValue = cleanedValue.replace(/\B(?=(\d{3})+(?!\d))/g, ',')
        return `Rp ${formattedValue}`
    } else {
        return `Rp 0`
    }
}
const parserFunction = (value: string) => {
    return value.replace(/\$\s?|(,*)/g, '')
}
const props = defineProps({
    defaultVal: {
        type: Object,
        default: null
    },
    formatter: {
        type: Boolean,
        default: false
    },
    readonly: {
        type: Boolean,
        default: false
    },
    slots: {
        type: Boolean,
        default: false
    },
    slotGrid: {
        type: Number,
        default: 22
    },
    select: {
        type: Boolean,
        default: false
    },
    style: {
        type: Object,
        default: {}
    },
    options: {
        type: Array,
        default: () => []
    },
    pData: {
        type: String,
        default: 'id'
    },
    sData: {
        type: String,
        default: 'name'
    },
    label: {
        type: String,
        default: ''
    },
    type: {
        type: String,
        default: 'text'
    },
    placeholder: {
        type: String,
        default: ''
    },
    showPassword: {
        type: Boolean,
        default: false
    },
    error: {
        type: [Array, String],
        default: ''
    },
    hidden: {
        type: Boolean,
        default: false
    },
    readOnly: {
        type: Boolean,
        default: false,
    },
    prop: {
        type: String,
        default: ''
    },
    value: {
        type: [String, Number],
        default: null
    },
    format: {
        type: String,
        default: null
    },
})
</script>