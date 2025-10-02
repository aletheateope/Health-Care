<script setup>
import Breadcrumb from "primevue/breadcrumb";

import { useRoute, useRouter } from "vue-router";

const router = useRouter();
const route = useRoute();

const bcItems = [
    { label: "Appointments", route: "appointments" },
    { label: "Doctor Selection", route: "doctor-appointment" },
];

const isLast = (item) => bcItems[bcItems.length - 1] === item;
</script>

<template>
    <section>
        <Breadcrumb :model="bcItems" class="small">
            <template #item="{ item, props }">
                <router-link
                    v-if="item.route && !isLast(item)"
                    v-slot="{ href, navigate }"
                    :to="{ name: item.route }"
                    custom
                >
                    <a :href="href" v-bind="props.action" @click="navigate">
                        <span class="accent-color">{{ item.label }}</span>
                    </a>
                </router-link>
                <span v-else class="text-gray-400 dark:text-gray-500">{{
                    item.label
                }}</span>
            </template>
            <template #separator> / </template>
        </Breadcrumb>
    </section>
</template>
