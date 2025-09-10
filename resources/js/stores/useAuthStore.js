import { defineStore } from 'pinia';
import api from '@/utils/api';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null,
        token: null,
        isAuthenticated: false,
        credentials: {
            email: '',
            password: '',
        },
    }),
    actions: {
        setUser(user) {
            this.user = user;
        },
        setToken(token) {
            this.token = token;
        },
        setAuthenticated(isAuthenticated) {
            this.isAuthenticated = isAuthenticated;
        },
        setCredentials(credentials) {
            this.credentials = credentials;
        },

        login() {
            api.post('/login', this.credentials)
                .then(response => {
                    this.setUser(response.data.user);
                    this.setToken(response.data.token);
                    this.setAuthenticated(true);
                })
                .catch(error => {
                    console.error(error);
                });
        },
    },
});
