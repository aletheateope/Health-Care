import { createApp } from "vue";
import PrimeVue from "primevue/config";
import Aura from "@primeuix/themes/aura";
import { definePreset } from "@primeuix/themes";

import Button from "@/components/mpa/Button.vue";
import Password from "@/components/mpa/Password.vue";
import InputText from "@/components/mpa/InputText.vue";
import Checkbox from "@/components/mpa/CheckBox.vue";

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

const components = {
    Button,
    Password,
    InputText,
    Checkbox,
};

document.querySelectorAll("[data-vue]").forEach((el) => {
    const name = el.dataset.vue;
    const Component = components[name];
    if (!Component) return; // skip if not registered

    // Extract props from data-*
    const props = {};
    for (const key in el.dataset) {
        if (key === "vue") continue; // skip the component name
        const camelKey = key.replace(/-([a-z])/g, (_, char) =>
            char.toUpperCase()
        );
        props[camelKey] = el.dataset[key];
    }

    // Mount the Vue component
    const app = createApp(Component, props);
    app.use(PrimeVue, { theme: { preset: MyPreset } });
    app.mount(el);
});
