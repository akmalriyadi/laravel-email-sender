import { defineStore } from 'pinia';

export const useWebStore = defineStore('webStore', {
    state: () => ({
        popUpOpen: false,
        modalPopUp: false,
        textPopUp: '',
        titlePopUp: '',
        iconPopUp: '',
        isLoading: false,
        notificationOpen: false,
        titleNotification: '',
        messageNotification: ''
    }),
    actions: {
        togglePopUp() {
            this.popUpOpen = !this.popUpOpen;
        },
        onNotification(title: string, message: string) {
            this.titleNotification = title
            this.messageNotification = message
            this.notificationOpen = true
        },
        onPopUp(icon: string, text: string, titlePopUp: string) {
            this.iconPopUp = icon
            this.textPopUp = text
            this.titlePopUp = titlePopUp
            this.popUpOpen = true
        },
        offPopUp() {
            this.popUpOpen = false
        },
        toogleLoading() {
            this.isLoading = !this.isLoading
        },
        onLoading() {
            this.isLoading = true
        },
        offLoading() {
            this.isLoading = false
        },
    },
});
