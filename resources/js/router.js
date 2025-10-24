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
                    roles: ["admin"],
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
                    roles: ["doctor"],
                    title: "Schedules",
                    parentClass: "h-screen",
                    mainClass: "h-full",
                },
            },

            {
                path: "prescriptions",
                name: "prescriptions",
                component: () => import("@/pages/Prescriptions.vue"),
                meta: {
                    roles: ["doctor"],
                    title: "Prescriptions",
                    parentClass: "h-screen",
                    mainClass: "h-full",
                },
            },
            // PATIENT
            {
                path: "doctors",
                name: "doctors",
                component: () => import("@/pages/Doctors.vue"),
                meta: {
                    roles: ["patient"],
                    title: "Doctors",
                },
            },
            {
                path: "appointments",
                name: "appointments",
                component: () => import("@/pages/Appointments.vue"),
                meta: {
                    roles: ["patient"],
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
                    roles: ["patient"],
                    title: "Doctor Appointment",
                },
            },
            {
                path: "medical-records",
                name: "medical-records",
                component: () => import("@/pages/MedicalRecords.vue"),
                meta: {
                    roles: ["patient"],
                    title: "Medical Records",
                    parentClass: "h-screen",
                    mainClass: "h-full",
                },
            },
            {
                path: "billing",
                name: "billing",
                component: () => import("@/pages/Billing.vue"),
                meta: {
                    roles: ["patient"],
                    title: "Billing",
                    parentClass: "h-screen",
                    mainClass: "h-full",
                },
            },
            // STAFFS
            {
                path: "test-requests",
                name: "test-requests",
                component: () => import("@/pages/TestRequests.vue"),
                meta: {
                    roles: ["staff"],
                    title: "Test Requests",
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
            {
                path: "patients",
                name: "patients",
                component: () => import("@/pages/Patients.vue"),
                meta: {
                    roles: ["doctor", "staff"],
                    title: "Patients",
                    parentClass: "h-screen",
                    mainClass: "h-full",
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

import { useAuthStore } from "@/stores/auth";

router.beforeEach(async (to, from, next) => {
    const auth = useAuthStore();

    // Set page title
    const nearestWithTitle = to.matched
        .slice()
        .reverse()
        .find((r) => r.meta?.title);
    document.title = nearestWithTitle?.meta.title || "Laravel";

    // Check if route requires roles
    const requiredRoles = to.meta.roles;
    if (requiredRoles) {
        if (!auth.isAuthenticated) {
            // Not logged in → redirect to login
            return next({ path: "/login" });
        }

        const userRole = auth.role;
        if (!requiredRoles.includes(userRole)) {
            // Logged in but wrong role → redirect to not authorized or dashboard
            return next({ name: "dashboard" });
        }
    }
    next();
});
export default router;
