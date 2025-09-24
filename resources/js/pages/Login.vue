<script setup>
import { storeToRefs } from "pinia";
import { useAuthStore } from "@/stores/useAuthStore";
import BaseLayout from "@/layout/LandingBaseLayout.vue";

const authStore = useAuthStore();

const { credentials } = storeToRefs(authStore);

function login() {}
</script>

<template>
    <BaseLayout>
        <form
            @submit.prevent="login"
            class="flex flex-col shadow-lg bg-white w-1/3 gap-4 p-4 rounded-lg mx-auto"
        >
            <h1 class="text-4xl text-center font-bold text-primary">Login</h1>
            <input
                type="text"
                placeholder="Email"
                class="input input-primary p-2 w-full text-black bg-gray-200 rounded-lg"
            />
            <input
                type="text"
                placeholder="Password"
                class="input input-primary p-2 w-full text-black bg-gray-200 rounded-lg"
            />
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </BaseLayout>
</template>
