import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/portal/dashboard",
        name: "dashboard",
        component: () => import("@/pages/Dashboard.vue"),
    },
    {
        path: "/portal/appointments",
        name: "appointments",
        component: () => import("@/pages/Appointments.vue"),
    },
    {
        path: "/:pathMatch(.*)*",
        name: "not-found",
        meta: { title: "Page Not Found" },
        component: () => import("@/pages/NotFound.vue"),
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
