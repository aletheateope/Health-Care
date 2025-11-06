<script setup>
import { computed } from "vue";
import { useRoute } from "vue-router";
import Sidebar from "@/components/Sidebar.vue";
import Header from "@/components/Header.vue";

const route = useRoute();

const parentClass = computed(() => route.meta.parentClass || "");
const mainClass = computed(() => route.meta.mainClass || "");
</script>

<template>
    <div class="flex flex-row">
        <Sidebar />
        <div :class="['flex flex-col flex-grow', parentClass]">
            <Header />
            <main :class="['p-4', mainClass]">
                <RouterView v-slot="{ Component, route }">
                    <transition name="fade" mode="out-in" :key="route.fullPath">
                        <div class="h-full">
                            <component :is="Component" />
                        </div>
                    </transition>
                </RouterView>
            </main>
        </div>
    </div>
</template>
