import useCoreComposables from "./useCoreComposables"
import useBaseComposables from "./useBaseComposables"

export default function useEmailSenderComposables() {
    const url = '/email-senders'
    const core = useCoreComposables(url)
    const useBase = useBaseComposables()

    async function send(id: Number) {
        try {
            const response = await useBase.postData(`${url}/send/${id}`, 'post')
        } catch (e) {
            throw e
        }
    }

    return {
        ...core,
        send
    }
}