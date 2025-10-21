<script setup>
import { inject, computed, onMounted, ref, watch, nextTick } from "vue";
import { useRoute, useRouter } from "vue-router";

import { Form } from "@primevue/forms";
import Textarea from "primevue/textarea";

import { selectedDoctor } from "@/stores/doctor";
import { useConversationStore } from "@/stores/conversations";

import MessageBubble from "@/components/chat/MessageBubble.vue";

const loading = ref(false);

const route = useRoute();
const router = useRouter();

const conversationStore = useConversationStore();

const doctor_id = computed(() => selectedDoctor.value.id);
const doctor_name = computed(() => selectedDoctor.value.name);

const hasConversation = computed(
    () => route.params.id && route.params.id !== "new"
);

const chatInfo = inject("chatInfo");

function checkSelectedDoctor() {
    if (route.params.id === "new" && !doctor_id.value) {
        router.replace({ name: "consultation" });
    }
}

onMounted(checkSelectedDoctor);

const conversation_id = computed(() => route.params.id);

const conversation = ref({});

async function fetchMyConversation() {
    loading.value = true;

    try {
        const res = await axios.get("/my-conversation", {
            params: { conversation_id: conversation_id.value },
        });
        conversation.value = res.data;
        console.log(res.data);
    } catch (err) {
        const status = err.response?.status;

        if (status === 403 || status === 404) {
            router.replace({ name: "consultation" });
        } else {
            console.log(err);
        }
    } finally {
        loading.value = false;
    }
}

onMounted(() => {
    if (hasConversation.value) {
        fetchMyConversation();
    }
});

const recipientName = computed(() => {
    if (!hasConversation.value) {
        return doctor_name.value;
    } else {
        const recipient = conversation.value.recipient;
        if (recipient) {
            const fullName = `${recipient.first_name} ${recipient.last_name}`;
            return recipient.role === "doctor" ? `Dr. ${fullName}` : fullName;
        }
        return "";
    }
});

const formRef = ref(null);

const messageInitialValues = {
    message: "",
};
const fileInput = ref(null);

async function triggerFileInput() {
    fileInput.value.click();
}

function onEnterSubmit(event) {
    if (event.shiftKey) return;

    event.preventDefault();

    const formEl = event.target.closest("form");
    if (formEl) {
        formEl.dispatchEvent(new Event("submit", { cancelable: true }));
    }
}

async function onSubmitMessage(values) {
    const payload = {
        conversation_id: conversation_id.value,
        doctor_id: doctor_id.value,
        ...values.values,
    };

    if (!payload.message || payload.message.trim() === "") {
        return;
    }

    try {
        const res = await axios.post("/conversation", payload);

        if (!res.data.new) {
        } else {
            await conversationStore.fetchMyConversations();
            router.push({
                name: "consultation-room",
                params: { id: res.data.ref_id },
            });
        }
    } catch (err) {
        console.log(err);
    } finally {
        formRef.value?.reset();
    }
}

watch(
    () => route.params.id,
    (newId) => {
        if (newId && newId !== "new") {
            fetchMyConversation();
        }
    },
    { immediate: true }
);
</script>

<template>
    <div class="flex flex-col w-full">
        <header
            class="flex flex-row justify-between items-center border-b border-color py-4 px-4"
        >
            <Button variant="link" class="hover:underline p-0! text-color">
                <div
                    class="size-10 shrink-0 border border-color rounded-full overflow-hidden"
                >
                    <img
                        src="https://cdn.pixabay.com/photo/2023/02/18/11/00/icon-7797704_1280.png"
                        alt=""
                        class="h-full w-full object-cover"
                    />
                </div>
                <h6 v-if="loading" class="text-base! font-semibold">
                    Loading...
                </h6>
                <h6 v-else class="text-base! font-semibold">
                    {{ recipientName }}
                </h6>
            </Button>
            <Button
                v-if="hasConversation"
                icon="pi pi-info-circle"
                aria-label="Info"
                severity="secondary"
                variant="text"
                :class="{
                    'bg-(--p-button-text-secondary-hover-background)!':
                        chatInfo,
                }"
                @click="chatInfo = !chatInfo"
            />
        </header>
        <div
            v-if="!hasConversation"
            class="flex flex-col h-full items-center justify-center gap-2 text-center text-gray-400"
        >
            <i class="pi pi-heart-fill text-3xl!"></i>
            <div>
                <p>You haven't started a conversation with this doctor yet.</p>
                <p>Send a message to begin.</p>
            </div>
        </div>
        <div
            v-else
            class="h-0 flex-grow flex flex-col-reverse px-2 overflow-auto"
        >
            <MessageBubble
                v-for="message in conversation.messages"
                :key="message.id"
                :message="message"
                :recipient="conversation.recipient"
            />
        </div>
        <footer>
            <Form
                ref="formRef"
                :initialValues="messageInitialValues"
                @submit="onSubmitMessage"
            >
                <div
                    class="flex flex-row border-t border-color px-2 py-4 gap-2 items-end"
                >
                    <Button
                        icon="pi pi-paperclip"
                        aria-label="Attachment"
                        severity="secondary"
                        variant="text"
                        @click="triggerFileInput"
                        class="shrink-0"
                    />
                    <input ref="fileInput" type="file" hidden />
                    <Textarea
                        placeholder="Send a message..."
                        rows="1"
                        fluid
                        autoResize
                        name="message"
                        class="resize-none max-h-25 min-h-[42px] overflow-y-auto!"
                        @keydown.enter="onEnterSubmit"
                    />
                    <Button
                        icon="pi pi-send"
                        aria-label="Send"
                        type="submit"
                        class="shrink-0"
                    />
                </div>
            </Form>
        </footer>
    </div>
</template>
