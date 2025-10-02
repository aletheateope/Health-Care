<script setup>
import { computed, ref } from "vue";
import { useRoute } from "vue-router";

import { useAuthStore } from "@/stores/auth";

const auth = useAuthStore();

// const props = defineProps({
//     title: {
//         type: String,
//         default: "Dashboard",
//     },
// });
const route = useRoute();

const title = computed(() => route.meta.title || "Dashboard");

import TieredMenu from "primevue/tieredmenu";

const menu = ref();

const menuItems = ref([
    {
        label: "Theme",
        icon: "pi pi-palette",
        items: [
            {
                label: "Light",
                icon: "pi pi-sun",
                command: () => setTheme("light"),
            },
            {
                label: "Dark",
                icon: "pi pi-moon",
                command: () => setTheme("dark"),
            },
            {
                label: "System",
                icon: "pi pi-desktop",
                command: () => setTheme("system"),
            },
        ],
    },
    {
        label: "Logout",
        icon: "pi pi-sign-out",
        command: () => auth.logout(),
    },
]);

const moreMenu = (event) => {
    menu.value.toggle(event);
};
</script>

<template>
    <header
        class="flex flex-row items-center justify-between py-2 px-4 border-b border-color"
        id="header"
    >
        <div>
            <h6 class="text-base! font-semibold">{{ title }}</h6>
        </div>
        <div class="flex flex-row gap-1">
            <Button
                icon="pi pi-bell"
                aria-label="Notifications"
                variant="text"
                severity="secondary"
            />
            <Button
                icon="pi pi-cog"
                aria-label="Settings"
                variant="text"
                severity="secondary"
                aria-haspopup="true"
                aria-controls="more"
                @click="moreMenu"
            />
            <TieredMenu
                ref="menu"
                id="more"
                :model="menuItems"
                popup
                appendTo="#header"
            />
        </div>
    </header>
</template>
