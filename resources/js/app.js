import "./bootstrap";
import { createApp } from "vue";
import App from "@/App.vue";
import router from "@/router";
import { createPinia } from "pinia";

import PrimeVue from "primevue/config";
import Aura from "@primeuix/themes/aura";
import { definePreset } from "@primeuix/themes";

import Toast from "primevue/toast";
import ToastService from "primevue/toastservice";
import Button from "primevue/button";

import { useAuthStore } from "@/stores/auth";

async function bootstrap() {
    const app = createApp(App);
    const pinia = createPinia();

    app.use(pinia);

    const MyPreset = definePreset(Aura, {
        semantic: {
            primary: {
                50: "{teal.50}",
                100: "{teal.100}",
                200: "{teal.200}",
                300: "{teal.300}",
                400: "{teal.400}",
                500: "{teal.500}",
                600: "{teal.600}",
                700: "{teal.700}",
                800: "{teal.800}",
                900: "{teal.900}",
                950: "{teal.950}",
            },
        },
    });

    app.use(PrimeVue, { theme: { preset: MyPreset } });
    app.use(ToastService);

    app.component("Button", Button);
    app.component("Toast", Toast);

    const auth = useAuthStore();

    try {
        await auth.fetchUser();
    } catch (e) {
        console.error("Failed to fetch user:", e);
    }

    app.use(router);
    app.mount("#app");
}

bootstrap();
