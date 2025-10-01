<script setup>
import { computed } from "vue";
import { useRoute } from "vue-router";
import { storeToRefs } from "pinia";

import { useAuthStore } from "@/stores/auth";

const auth = useAuthStore();
const { user } = storeToRefs(auth);

const sidebarItems = {
    admin: [
        { label: "Dashboard", icon: "pi pi-th-large", route: "dashboard" },
        { label: "Users", icon: "pi pi-user", route: "users" },
    ],
    patient: [
        { label: "Dashboard", icon: "pi pi-th-large", route: "dashboard" },
        {
            label: "Appointments",
            icon: "pi pi-calendar",
            route: "appointments",
        },
        {
            label: "Medical Records",
            icon: "pi pi-address-book",
            route: "medical-records",
        },
        {
            label: "Consultation",
            icon: "pi pi-comment",
            route: "consultation",
        },
        {
            label: "Billing",
            icon: "pi pi-receipt",
            route: "billing",
        },
    ],
};

const navItems = computed(() => {
    const role = user.value?.role;
    if (!role) return [];
    return sidebarItems[role] || [];
});

const route = useRoute();
const isActive = (itemRoute) => {
    const segments = route.path.split("/").filter(Boolean);
    const mainSegment = segments[1];
    return mainSegment === itemRoute;
};
</script>

<template>
    <aside
        v-if="user"
        class="flex flex-col w-52 h-screen sticky top-0 p-2 justify-between border-r border-color"
    >
        <div class="flex flex-col gap-2">
            <ul>
                <li>
                    <Button
                        label="test"
                        variant="text"
                        severity="contrast"
                        fluid
                        class="hover:underline justify-start! p-0!"
                        style="background: transparent"
                    >
                        <img
                            src="https://cdn.pixabay.com/photo/2023/02/18/11/00/icon-7797704_1280.png"
                            alt=""
                            class="rounded-full w-9 h-9 object-cover border border-color"
                        />
                        <span class="p-button-label" v-if="user?.profile"
                            >{{ user?.profile?.first_name }}
                            {{ user?.profile?.last_name }}</span
                        >
                    </Button>
                </li>
            </ul>
            <ul class="flex flex-col gap-1">
                <li v-for="item in navItems" :key="item.route">
                    <RouterLink :to="{ name: item.route }">
                        <Button
                            :label="item.label"
                            :icon="item.icon"
                            severity="contrast"
                            variant="text"
                            fluid
                            class="justify-start!"
                            :style="{
                                'background-color': isActive(item.route)
                                    ? 'var(--accent-color)'
                                    : '',
                                color: isActive(item.route)
                                    ? 'var(--p-button-primary-color) !important'
                                    : 'var(--primary-text-color)',
                            }"
                        >
                        </Button>
                    </RouterLink>
                </li>
            </ul>
        </div>
        <ul>
            <li>
                <Button
                    label="Logout"
                    icon="pi pi-sign-out"
                    severity="contrast"
                    variant="text"
                    fluid
                    class="justify-start!"
                    @click="auth.logout()"
                />
            </li>
        </ul>
    </aside>
</template>
