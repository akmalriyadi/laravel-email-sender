import { useWebStore } from "@/Stores"

export default function useResponseComposables() {
    const responseForce = async (id: Number, forceDelete: Function, fetchTrash: Function) => {
        try {
            ElMessageBox.confirm('permanently delete the data. Continue?', 'Warning', {})
                .then(async () => {
                    useWebStore().onLoading()
                    await forceDelete(id)
                    await fetchTrash()
                    useWebStore().offLoading()
                    useWebStore().onPopUp('success', 'Data has Delete', 'Success')
                })
                .catch((e) => {
                    useWebStore().onPopUp('danger', e, 'Error')
                    useWebStore().offLoading()
                })

        } catch (e) {
            console.log(e)
            console.log('kambing')
            useWebStore().offLoading()
        }
    }
    const responseRestore = async (id: Number, restoreData: Function, fetchTrash: Function) => {
        try {
            ElMessageBox.confirm('Are you sure restore the data. Continue?', 'Warning', {})
                .then(async () => {
                    useWebStore().onLoading()
                    await restoreData(id)
                    await fetchTrash()
                    useWebStore().offLoading()
                    useWebStore().onPopUp('success', 'Data has Restore', 'Success')
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
    const responseDelete = async (id: Number, deleteData: Function, fetchData: Function) => {
        try {
            ElMessageBox.confirm('Are you sure delete the data. Continue?', 'Warning', {})
                .then(async () => {
                    useWebStore().onLoading()
                    await deleteData(id)
                    await fetchData()
                    useWebStore().offLoading()
                    useWebStore().onPopUp('success', 'Data has Delete', 'Success')
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

    return {
        responseForce,
        responseRestore,
        responseDelete
    }
}