const edit = { label: 'fas fa-pencil-alt', type: 'icon', eventName: 'editData', bg: '', tool: 'Edit' }
const show = { label: 'fas fa-eye', type: 'icon', eventName: 'showData', bg: 'bg-show', tool: 'Show' }
const deleteData = { label: 'fas fa-trash', type: 'icon', eventName: 'deleteData', bg: 'bg-red-500', tool: 'Delete' }
const restore = { label: 'fas fa-water', type: 'icon', eventName: 'restore', bg: '', trash: true, tool: 'Restore' }
const forceDelete = { label: 'fas fa-trash', type: 'icon', eventName: 'forceDelete', bg: 'bg-red-500', trash: true, tool: 'Force Delete' }
const forceNoDelete = { label: 'fas fa-trash', type: 'icon', eventName: 'forceDelete', bg: 'bg-red-500', tool: 'Force Delete' }
const send = { label: 'fa-solid fa-paper-plane', type: 'icon', eventName: 'sendEmail', bg: 'bg-red-500', tool: 'Send Email' }


const typeAction1 = [show, edit, deleteData, restore, forceDelete]
const typeAction2 = [edit, deleteData, restore, forceDelete]
const typeAction3 = [edit, deleteData]
const typeAction4 = [show, deleteData, restore, forceDelete]
const typeAction5 = [show]
const typeAction6 = [edit]
const typeAction7 = [edit, deleteData]
const typeAction8 = [send, edit, deleteData, restore, forceDelete]

const typeAction = (value) => {
    if (value == 1) {
        return typeAction1
    }
    if (value == 2) {
        return typeAction2
    }
    if (value == 3) {
        return typeAction3
    }
    if (value == 4) {
        return typeAction4
    }
    if (value == 5) {
        return typeAction5
    }
    if (value == 6) {
        return typeAction6
    }
    if (value == 7) {
        return typeAction7
    }
    if (value == 8) {
        return typeAction8
    }
}

export default typeAction