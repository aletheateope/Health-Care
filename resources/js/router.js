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
            // DOCTOR
            {
                path: "schedules",
                name: "schedules",
                component: () => import("@/pages/Schedules.vue"),
                meta: {
                    title: "Schedules",
                },
            },
            {
                path: "patients",
                name: "patients",
                component: () => import("@/pages/Patients.vue"),
                meta: {
                    title: "Patients",
                },
            },
            {
                path: "prescriptions",
                name: "prescriptions",
                component: () => import("@/pages/Prescriptions.vue"),
                meta: {
                    title: "Prescriptions",
                },
            },
            // PATIENTS,
            {
                path: "doctors",
                name: "doctors",
                component: () => import("@/pages/Doctors.vue"),
                meta: {
                    title: "Doctors",
                },
            },
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
                path: "billing",
                name: "billing",
                component: () => import("@/pages/Billing.vue"),
                meta: {
                    title: "Billing",
                },
            },
            // SHARED
            {
                path: "profile",
                name: "profile",
                component: () => import("@/pages/Profile.vue"),
                meta: {
                    title: "Profile",
                },
            },
            {
                path: "consultation",
                name: "consultation",
                component: () => import("@/pages/Consultation.vue"),
                meta: {
                    title: "Consultation",
                    parentClass: "h-screen",
                    mainClass: "p-0! h-full",
                    collapsedSidebar: true,
                },
                children: [
                    {
                        path: "c/:id",
                        name: "consultation-room",
                        component: () => import("@/pages/ConsultationRoom.vue"),
                        meta: {
                            collapsedSidebar: true,
                        },
                    },
                ],
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
