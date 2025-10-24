<script setup>
import { useRouter } from "vue-router";
import { formatPastTime } from "@/utils/date";

const props = defineProps({
    conversation: {
        type: Object,
        required: true,
    },
    active: {
        type: Boolean,
        default: false,
    },
});

const router = useRouter();
function goToConversation(ref_id) {
    router.push({
        name: "consultation-room",
        params: { id: ref_id },
    });
}
</script>
<template>
    <Button
        severity="contrast"
        variant="text"
        fluid
        class="flex flex-row border justify-start! p-0! px-2! py-2! gap-3!"
        :class="{ 'bg-(--p-button-text-contrast-hover-background)!': active }"
        @click="goToConversation(conversation.ref_id)"
    >
        <div
            class="size-12 shrink-0 border border-color rounded-full overflow-hidden"
        >
            <img
                class="object-cover w-full h-full"
                src="https://cdn.pixabay.com/photo/2023/02/18/11/00/icon-7797704_1280.png"
                alt=""
            />
        </div>
        <div class="flex flex-col gap-1 w-full min-w-0">
            <div class="flex flex-row items-center justify-between">
                <h6 class="text-base! font-medium truncate">
                    {{ conversation.participant.first_name }}
                    {{ conversation.participant.last_name }}
                </h6>
                <p class="small text-gray-600">
                    {{ formatPastTime(conversation.last_message?.created_at) }}
                </p>
            </div>
            <div class="flex flex-row">
                <p class="truncate">
                    {{
                        conversation.last_message?.message || "No messages yet"
                    }}
                </p>
            </div>
        </div>
    </Button>
</template>
