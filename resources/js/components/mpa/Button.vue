<script setup>
import Button from "primevue/button";

const props = defineProps({
    type: String,
    label: String,
    icon: String,
    iconPos: String,
    as: String,
    loading: Boolean,
    variant: String,
    href: String,
    severity: String,
    class: String,
});
</script>

<template>
    <Button v-bind="props" :class="props.class" />
</template>
