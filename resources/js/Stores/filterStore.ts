import { defineStore } from 'pinia';
interface SearchParam {
    key: any;
    value: any;
}
export const useFilterStore = defineStore('filterStore', {
    state: () => ({
        searchParams: [] as SearchParam[],
        queryParams: '',
        sortParams: ''
    }),
    actions: {
        handleSearch(search: any) {
            this.searchParams = search
            this.handleQuery()
        },
        resetFilter() {
            this.queryParams = ''
            this.sortParams = ''
        },
        handleQuery() {
            this.queryParams = this.searchParams
                .filter((param: any) => param.value !== "")
                .map((param: any) => `search[${param.key}]=${param.value}`)
                .join("&");
        },
        pushSearch(key: any, value: any) {
            this.searchParams.push({ key: key, value: value })
            this.handleQuery()
        },
        handleFilter(goFilter: any) {
            const newDataKey = Object.keys(goFilter)[0];
            if (newDataKey == 'sort') {
                this.sortParams = `&sort[dir]=${goFilter.sort.dir}&sort[column]=${goFilter.sort.columns}`
            } else {
                for (const key in goFilter) {
                    const existingIndex = this.searchParams.findIndex(param => param.key === key);

                    if (existingIndex !== -1) {
                        this.searchParams[existingIndex].value = goFilter[key];
                    } else {
                        this.searchParams.push({ key: key, value: goFilter[key] });
                    }
                }
                this.handleQuery()
            }
        }
    },
});
