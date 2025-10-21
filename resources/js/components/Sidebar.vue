<script setup>
import { computed } from "vue";
import { useRoute } from "vue-router";
import { storeToRefs } from "pinia";

import { useAuthStore } from "@/stores/auth";

const auth = useAuthStore();
const { user } = storeToRefs(auth);

const sidebarItems = {
    admin: [
        {
            label: "Dashboard",
            icon: "pi pi-th-large",
            route: "dashboard",
        },
        {
            label: "Users",
            icon: "pi pi-user",
            route: "users",
        },
    ],
    doctor: [
        {
            label: "Dashboard",
            icon: "pi pi-th-large",
            route: "dashboard",
        },
        {
            label: "Schedules",
            icon: "pi pi-calendar",
            route: "schedules",
        },
        {
            label: "Patients",
            icon: "pi pi-address-book",
            route: "patients",
        },
        {
            label: "Prescriptions",
            icon: "pi pi-pencil",
            route: "prescriptions",
        },
        {
            label: "Consultation",
            icon: "pi pi-comment",
            route: "consultation",
        },
    ],
    patient: [
        {
            label: "Dashboard",
            icon: "pi pi-th-large",
            route: "dashboard",
        },
        {
            label: "Find a Doctor",
            icon: "pi pi-user",
            route: "doctors",
        },
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
    const role = user.value?.role.toLowerCase();
    if (!role) return [];
    return sidebarItems[role] || [];
});

const route = useRoute();
const isActive = (itemRoute) => {
    const segments = route.path.split("/").filter(Boolean);
    const mainSegment = segments[1];
    return mainSegment === itemRoute;
};

const sidebarWidth = computed(() =>
    route.meta.collapsedSidebar ? "w-[55px]" : "w-[55px] lg:w-52"
);
</script>

<template>
    <aside
        v-if="user"
        class="flex flex-col h-screen sticky top-0 p-2 border-r border-color text-nowrap"
        :class="sidebarWidth"
    >
        <div class="flex flex-col gap-2">
            <ul>
                <li>
                    <RouterLink :to="{ name: 'profile' }">
                        <Button
                            variant="text"
                            severity="contrast"
                            fluid
                            class="hover:underline justify-start! p-0!"
                            :class="{
                                underline: isActive('profile'),
                            }"
                            style="background: transparent"
                        >
                            <img
                                src="https://cdn.pixabay.com/photo/2023/02/18/11/00/icon-7797704_1280.png"
                                alt=""
                                class="rounded-full w-9 h-9 object-cover border border-color"
                            />
                            <span
                                v-if="user?.profile"
                                class="p-button-label truncate"
                                :class="{
                                    'font-bold!': isActive('profile'),
                                }"
                                >{{ user?.profile?.first_name }}
                                {{ user?.profile?.last_name }}</span
                            >
                        </Button>
                    </RouterLink>
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
                            class="justify-start! px-[10px]! gap-4!"
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
    </aside>
</template>
