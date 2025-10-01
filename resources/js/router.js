import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/portal",
        component: () => import("@/layout/BaseLayout.vue"),
        children: [
            {
                path: "",
                redirect: { name: "dashboard" },
            },
            {
                path: "dashboard",
                name: "dashboard",
                component: () => import("@/pages/Dashboard.vue"),
                meta: { title: "Dashboard" },
            },
            // ADMIN
            {
                path: "users",
                name: "users",
                component: () => import("@/pages/Users.vue"),
                meta: {
                    title: "Users",
                    parentClass: "h-screen",
                    mainClass: "h-full",
                },
            },
            // PATIENTS,
            {
                path: "appointments",
                name: "appointments",
                component: () => import("@/pages/Appointments.vue"),
                meta: {
                    title: "Appointments",
                    parentClass: "h-screen",
                    mainClass: "h-full",
                },
            },
            {
                path: "appointments/doctor",
                name: "doctor-appointment",
                component: () => import("@/pages/DoctorAppointment.vue"),
                meta: {
                    title: "Doctor Appointment",
                },
            },
            {
                path: "medical-records",
                name: "medical-records",
                component: () => import("@/pages/MedicalRecords.vue"),
                meta: {
                    title: "Medical Records",
                },
            },
            {
                path: "consultation",
                name: "consultation",
                component: () => import("@/pages/Consultation.vue"),
                meta: {
                    title: "Consultation",
                },
            },
            {
                path: "billing",
                name: "billing",
                component: () => import("@/pages/Billing.vue"),
                meta: {
                    title: "Billing",
                },
            },
        ],
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
