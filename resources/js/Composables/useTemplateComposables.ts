import useCoreComposables from "./useCoreComposables"
import useBaseComposables from "./useBaseComposables"

export default function useTemplateComposables() {
    const url = '/templates'
    const core = useCoreComposables(url)
    const useBase = useBaseComposables()

    return {
        ...core,
    }
}