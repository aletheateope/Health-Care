import { defineStore } from "pinia";
import axios from "axios";

export const useAuthStore = defineStore("auth", {
    state: () => ({
        user: null,
        loading: false,
    }),

    actions: {
        async fetchUser() {
            this.loading = true;
            try {
                const { data } = await axios.get("/user");
                this.user = data.data;
            } catch (error) {
                this.user = null;
            } finally {
                this.loading = false;
            }
        },

        async logout() {
            await axios.post("/logout");
            this.user = null;
            window.location.href = "/login";
        },
    },

    getters: {
        isAuthenticated: (state) => !!state.user,
    },
});
