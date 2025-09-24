<script setup>
import FloatLabel from "primevue/floatlabel";
import InputText from "primevue/inputtext";

const props = defineProps({
    id: String,
    type: String,
    label: String,
});
</script>

<template>
    <FloatLabel variant="on">
        <InputText class="w-full" :id="props.id" :type="props.type" />
        <label :for="props.id">{{ props.label }}</label>
    </FloatLabel>
</template>
