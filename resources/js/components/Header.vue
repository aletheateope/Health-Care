<script setup>
import { computed } from "vue";
import { useRoute } from "vue-router";
// const props = defineProps({
//     title: {
//         type: String,
//         default: "Dashboard",
//     },
// });
const route = useRoute();

const title = computed(() => route.meta.title || "Dashboard");
</script>

<template>
    <header
        class="flex flex-row items-center justify-between py-2 px-4 border-b border-color"
    >
        <div>
            <h6 class="text-base! font-semibold">{{ title }}</h6>
        </div>
        <div class="flex flex-row gap-1">
            <Button
                icon="pi pi-cog"
                aria-label="Settings"
                variant="text"
                severity="secondary"
            />
            <Button
                icon="pi pi-bell"
                aria-label="Notifications"
                variant="text"
                severity="secondary"
            />
        </div>
    </header>
</template>
