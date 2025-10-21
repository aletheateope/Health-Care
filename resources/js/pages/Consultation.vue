<script setup>
import { onMounted, ref, computed, provide } from "vue";
import { useRoute, useRouter } from "vue-router";

import Dialog from "primevue/dialog";
import IconField from "primevue/iconfield";
import InputIcon from "primevue/inputicon";
import InputText from "primevue/inputtext";

import { storeSelectedDoctor, resetSelectedDoctor } from "@/stores/doctor";
import { useConversationStore } from "@/stores/conversations";

import CardChat from "@/components/chat/CardChat.vue";
import CardDoctor from "@/components/chat/CardDoctor.vue";

const route = useRoute();
const router = useRouter();
const hasRoom = computed(() => !!route.params.id);

const newChatModal = ref(false);

const chatInfo = ref(false);
provide("chatInfo", chatInfo);

const doctors = ref([]);
async function fetchDoctors() {
    try {
        const res = await axios.get("/api/doctors");
        doctors.value = res.data.data;
    } catch (err) {
        console.error(err);
    } finally {
    }
}

onMounted(fetchDoctors);

async function selectDoctor(doctor) {
    try {
        const res = await axios.get("/conversation", {
            params: { doctor_id: doctor.id },
        });

        if (res.data.exists) {
            resetSelectedDoctor();

            router.push({
                name: "consultation-room",
                params: { id: res.data.ref_id },
            });
        } else {
            storeSelectedDoctor(doctor);

            router.push({
                name: "consultation-room",
                params: { id: "new" },
            });
        }
    } catch (err) {
        console.error(err);
    } finally {
        newChatModal.value = false;
    }
}

const conversationStore = useConversationStore();
onMounted(() => {
    if (!conversationStore.list.length) {
        conversationStore.fetchMyConversations();
    }
});
</script>

<style>
.create-msg-modal {
    .p-dialog-content {
        height: 100%;
    }
}
</style>

<template>
    <div class="flex flex-row h-full">
        <aside
            class="flex flex-col border-r border-color w-full md:w-64 lg:w-80 xl:w-130 py-4 px-4 gap-4"
        >
            <div class="flex flex-row justify-between items-center">
                <h4>Chats</h4>
                <Button
                    icon="pi pi-pen-to-square"
                    aria-label="New Chat"
                    severity="secondary"
                    variant="outlined"
                    size="small"
                    rounded
                    @click="newChatModal = true"
                />
            </div>
            <IconField>
                <InputIcon class="pi pi-search" />
                <InputText placeholder="Search" fluid />
            </IconField>
            <div class="overflow-auto flex-grow h-0">
                <CardChat
                    v-for="conversation in conversationStore.list"
                    :key="conversation.id"
                    :conversation="conversation"
                    :active="route.params.id === conversation.ref_id"
                />
            </div>
        </aside>
        <RouterView v-if="hasRoom" />
        <div v-else class="flex flex-col w-full justify-center items-center">
            <p class="text-gray-500">Select a chat to start messaging.</p>
        </div>
        <aside class="border-l border-color xl:w-130" v-if="chatInfo"></aside>
    </div>
    <Dialog
        v-model:visible="newChatModal"
        modal
        header="Compose Message"
        dismissableMask
        :draggable="false"
        class="create-msg-modal w-[98%] sm:w-[60%] md:w-[40%] h-[70%]"
    >
        <div class="flex flex-col gap-4 h-full">
            <h6>Doctors</h6>
            <IconField>
                <InputIcon class="pi pi-search" />
                <InputText placeholder="Search" fluid />
            </IconField>
            <div class="flex flex-col h-full overflow-auto">
                <CardDoctor
                    v-for="doctor in doctors"
                    :key="doctor.id"
                    :name="'Dr. ' + doctor.first_name + ' ' + doctor.last_name"
                    :specialty="doctor.specialty.name"
                    @click="selectDoctor(doctor)"
                />
            </div>
        </div>
    </Dialog>
</template>
