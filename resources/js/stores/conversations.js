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
        updateConversation(refId, latestMessage) {
            this.$patch((state) => {
                const index = state.list.findIndex((c) => c.ref_id === refId);

                if (index === -1) return;

                const convo = state.list[index];
                convo.last_message = latestMessage;

                state.list.splice(index, 1);
                state.list.unshift(convo);
            });
        },
    },
});
