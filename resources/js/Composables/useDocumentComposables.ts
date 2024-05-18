import useCoreComposables from "./useCoreComposables"
import useBaseComposables from "./useBaseComposables"

export default function useDocumentComposables() {
    const url = '/documents'
    const core = useCoreComposables(url)
    const useBase = useBaseComposables()

    return {
        ...core,
    }
}