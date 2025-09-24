<script setup>
import { ref } from "vue";
import Checkbox from "primevue/checkbox";

const props = defineProps({
    id: String,
    label: String,
});

const checked = ref(false);
</script>

<template>
    <div class="flex items-center gap-2">
        <Checkbox :inputId="props.id" binary />
        <label :for="props.id"> {{ props.label }} </label>
    </div>
</template>
