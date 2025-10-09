<script setup>
import { ref } from "vue";
import Drawer from "primevue/drawer";
import Button from "primevue/button";

const sidebarVisible = ref(false);

const links = [
    { name: "Home", path: "/" },
    { name: "About", path: "/about" },
    { name: "Find a Doctor", path: "/doctor" },
    { name: "Services", path: "/services" },
    { name: "Contact", path: "/contact" },
    { name: "Login", path: "/login" },
];
</script>

<template>
    <Button icon="pi pi-bars" @click="sidebarVisible = true" />

    <Drawer
        v-model:visible="sidebarVisible"
        header="Healthcare Company"
        :pt="{ root: { class: 'w-full! sm:w-[20rem]!' } }"
    >
        <ul>
            <li v-for="link in links" :key="link.name">
                <Button
                    :label="link.name"
                    :href="link.path"
                    variant="text"
                    severity="contrast"
                    as="a"
                    fluid
                    class="justify-start!"
                />
            </li>
        </ul>
    </Drawer>
</template>
