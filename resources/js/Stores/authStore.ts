import { defineStore } from "pinia";

export const useAuthStore = defineStore('auth', {
    state: () => ({
        authUser: null as Object | null,
        authToken: null
    }),
    getters: {
        user: () => {
            const storedUser = localStorage.getItem('authUser');
            if (storedUser !== null) {
                return JSON.parse(storedUser);
            } else {
                return null;
            }
        },
        // getToken: () => localStorage.getItem('authToken')
    },
    actions: {
        async setToken(token: string) {
            localStorage.setItem('authToken', token)
        },
        async setAuth(user: Object | null = null) {
            this.authUser = user
            localStorage.setItem('authUser', JSON.stringify(user))
        },
        getUser() {
            const user = localStorage.getItem('authUser');
            if (user !== null) {
                return JSON.parse(user);
            } else {
                return null;
            }
        },
        getToken() {
            return localStorage.getItem('authToken')
        }
    }
})
