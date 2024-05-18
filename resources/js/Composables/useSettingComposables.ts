import useCoreComposables from "./useCoreComposables"
import useBaseComposables from "./useBaseComposables"

export default function useSettingComposables() {
    const url = '/setting'
    const core = useCoreComposables(url)
    const useBase = useBaseComposables()

    return {
        ...core,
    }
}