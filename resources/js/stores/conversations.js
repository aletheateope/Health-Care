import { defineStore } from "pinia";

export const useConversationStore = defineStore("conversation", {
    state: () => ({
        list: [],
    }),
    actions: {
        async fetchMyConversations() {
            const res = await axios.get("/conversations");
            this.list = res.data.data;
        },
    },
});
