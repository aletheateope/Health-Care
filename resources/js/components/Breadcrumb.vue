<script setup>
import Breadcrumb from "primevue/breadcrumb";

const props = defineProps({
    items: {
        type: Array,
        required: true,
    },
});

const isLastItem = (item) => props.items[props.items.length - 1] === item;
</script>

<template>
    <Breadcrumb :model="items" class="small">
        <template #item="{ item, props: breadProps }">
            <router-link
                v-if="item.route && !isLastItem(item)"
                v-slot="{ href, navigate }"
                :to="{ name: item.route }"
                custom
            >
                <a :href="href" v-bind="breadProps.action" @click="navigate">
                    <span class="accent-color">{{ item.label }}</span>
                </a>
            </router-link>

            <span v-else class="text-gray-400 dark:text-gray-500">
                {{ item.label }}
            </span>
        </template>

        <template #separator> / </template>
    </Breadcrumb>
</template>
